<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Template;
use App\Models\TemplateScheme;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Colors;
use App\Traits\Site as SiteTrait;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Session;
use Validator;

class ColorsController extends Controller
{
    /**
     * @activity done
     */
    use SiteTrait;
    use Activity;
    use Colors;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Template::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['update', 'create', 'delete']);
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {GET} /api/colors/edit Форма цветовой схемы
     * @apiGroup Template Colors
     * @apiParam {string} token Токен пользователя
     * @apiParam {integer} template_scheme_id ID цветовой схемы
     */
    public function edit(Request $request): JsonResponse|bool|string
    {
        $result = self::check($request);

        if (!is_array($result)) {
            return $result;
        }

        return $this->success($result['scheme']);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/colors/delete Удаление цветовой схемы
     * @apiGroup Template Colors
     * @apiParam {string} token Токен пользователя
     * @apiParam {integer} template_id ID шаблона
     * @apiParam {integer} template_scheme_id ID схемы шаблона
     */
    public function delete(Request $request)
    {


        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден');
        }

        $templateId = $request->get('template_id');

        $data = $request->all();

        $customErrors = [
            'template_scheme_id' => 'required'
        ];

        $customMessages = [
            'template_scheme_id.required' => 'Не задан ID цветовой схемы'
        ];

        $validator = self::validator($data, ['name', 'colors'], $customErrors, $customMessages);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $template = Template::query()->find($templateId);

        if (!$template) {
            return $this->error('Шаблон не найден');
        }

        $scheme = $template->templateSchemes()->whereTemplateSchemeId($data['template_scheme_id'])->first();

        if (!$scheme) {
            return $this->error('Не найдена цветовая схема');
        }

        if ($template->templateSchemes()->count() == 1) {
            return $this->error('Вы не можете удалить цветовую схему. Она одна.');
        } else {
            if ($site->template_scheme_id == $scheme->id) {
                $next = $template->templateSchemes()->whereNotIn('template_scheme_id', [$scheme->id])->first();
                $site->update([
                    'template_scheme_id' => $next->id
                ]);

                reloadSite($site);

                forget(SiteTrait::getSiteCacheKey());
            }

            $scheme->delete();
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/colors/create Создание цветовой схемы
     * @apiGroup Template Colors
     * @apiParam {string} token Токен пользователя
     * @apiParam {json} colors Цвета
     * @apiParam {string} name Имя цветовой схемы
     * @apiParam {integer} template_id ID шаблона
     */
    public function create(Request $request)
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден');
        }

        $data = $request->all();

        $validator = self::validator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $template = Template::find((int)$data['template_id']);

        if (!$template) {
            return $this->error('Шаблон не найден');
        }

        $scheme = TemplateScheme::firstOrCreate([
            'name' => $data['name'],
            'colors' => $data['colors'],
            'is_user_defined' => 1,
            'default' => 0,
            'default_global' => 0
        ]);

        $template->templateSchemes()->attach($scheme);

        $this->setIsSystem(false);
        $this->setParams($scheme->toArray());
        $this->createActivity();

        return $this->success($scheme->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/colors/update Обновление шаблонов
     * @apiGroup Template Colors
     * @apiParam {string} token Токен пользователя
     * @apiParam {string} name имя цветовой схемы
     * @apiParam {integer} template_id ID шаблона
     * @apiParam {integer} template_scheme_id ID схемы шаблона
     * @apiParam {json} colors Цвета
     *
     */
    public function update(Request $request): JsonResponse|string
    {
        $result = self::check($request);

        if (!is_array($result)) {
            return $result;
        }

        $connected = $result['template']->templateSchemes()->whereTemplateSchemeId($result['scheme']->id)->first();

        if (!$connected) {
            return $this->error('Цветовая схема не принадлежит шаблону');
        }

        $result['scheme']->update([
            'name' => $result['data']['name'],
            'colors' => $result['data']['colors'],
            'is_user_defined' => 1,
            'default' => 0,
            'default_global' => 0
        ]);

        return $this->success($result['scheme']);
    }
}