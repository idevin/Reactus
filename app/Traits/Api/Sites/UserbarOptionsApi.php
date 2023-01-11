<?php

namespace App\Traits\Api\Sites;


use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSlide;
use App\Models\Site;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait UserbarOptionsApi
{
    /**
     * @return JSON
     * @api {GET} /api/sites/userbar_options/form Форма для опций юзербара
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function userbarOptionsForm()
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        return $this->success($site->userbar_options);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/sites/userbar_options/save Сохранение параметров юзербара
     * @apiGroup Site
     * @apiParam {json} userbar_options Опции меню
     */
    public function userbarOptionsSave(Request $request): JsonResponse|string
    {
        $data = $request->all();
        $result = Utils::siteInstance();

        if(!is_array($result)) {
            return $result;
        }
        if (!isset($data['userbar_options']) || empty($data['userbar_options'])) {
            return $this->error('Не заданы параметры юзербара');
        }

        $menuOptions = json_decode($data['userbar_options']);

        if (!$menuOptions) {
            return $this->error('Невалидный json формат');
        }

        $result['site']->update([
            'userbar_options' => $data['userbar_options']
        ]);

        Utils::forgetModuleCache();

        return $this->success();
    }
}