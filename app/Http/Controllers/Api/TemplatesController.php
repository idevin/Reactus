<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteStorageImage;
use App\Models\Template;
use App\Models\TemplateScheme;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Site as SiteTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class TemplatesController extends Controller
{
    /**
     * @activity done
     */
    use SiteTrait;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Template::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['update']);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/templates/form Форма для шаблонов
     * @apiGroup Templates
     * @apiParam {string} token Токен пользователя
     *
     */
    public function form(): JsonResponse
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();
        $templates = Template::with('templateSchemes')->whereHidden(0)->get();

        $templatesData = [];

        if (count($templates) > 0) {
            foreach ($templates as $index => $template) {

                $templatesData[$index] = $template->only(['id', 'name', 'default', 'alias']);

                if (count($template->templateSchemes) > 0) {

                    foreach ($template->templateSchemes as $index2 => $templateScheme) {
                        $templateData = $templateScheme->only(['id', 'name', 'default', 'default_global', 'colors']);
                        if (!empty($templateData['colors']) && !is_string($templateData['colors'])) {
                            $templateData['colors'] = json_encode($templateData['colors']);
                        }
                        $templatesData[$index]['template_schemes'][$index2] = $templateData;
                    }
                }
            }
        }

        $data['template'] = $site->template;
        $data['template']['template_scheme_id'] = $site->template_scheme_id;
        $data['options'] = $templatesData;

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/templates/update Обновление шаблонов
     * @apiGroup Templates
     * @apiParam {string} token Токен пользователя
     * @apiParam {integer} template_id ID шаблона
     * @apiParam {integer} template_scheme_id ID схемы шаблона
     *
     */
    public function update(Request $request)
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (Auth::user() && !Auth::user()->can('site_layout_edit', $site)) {
            return $this->error('У вас нет прав для обновления шаблона');
        }

        $templateId = $request->get('template_id');
        $templateSchemeId = $request->get('template_scheme_id');
        $template = Template::find($templateId);
        $templateScheme = TemplateScheme::find($templateSchemeId);

        if (!$template) {
            return $this->error('Шаблон не найден');
        }
        if (!$templateScheme) {
            return $this->error('Цветовая схема не найдена');
        }

        if (!$site) {
            return $this->error('Сайт не найден');
        }

        $site->update([
            'template_id' => $template->id,
            'template_scheme_id' => $templateScheme->id
        ]);


        reloadSite($site);

        forget(SiteTrait::getSiteCacheKey());

        forget('settings.' . env('DOMAIN'));

        SiteStorageImage::flushCache();

        session(['theme' => $site->template->alias]);

        $this->setIsSystem(false);
        $this->setParams($site->template->toArray());
        $this->createActivity();

        return $this->success(['template' => $site->template]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {GET} /api/templates Список шаблонов
     * @apiGroup Templates
     * @apiParam {string} token Токен пользователя
     * @apiParam {integer} template_type Фильтр по типу шаблона (0 - сохраненные, 1 - оплаченые, 2 - бесплатные)
     */
    public function index(Request $request): JsonResponse|string
    {
        $data = $request->all();

        $templates = Template::query()->orderBy('name', 'ASC');

        if (isset($data['template_type']) && in_array($data['template_type'], array_keys(Template::TEMPLATE_TYPES))) {
            $templates = $templates->where('template_type', (int)$data['template_type'])->get();
        }

        $templates = $templates->get();

        return $this->success($templates);
    }
}