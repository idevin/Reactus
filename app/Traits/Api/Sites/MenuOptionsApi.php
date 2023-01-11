<?php

namespace App\Traits\Api\Sites;


use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSlide;
use App\Models\Site;
use App\Traits\Site as SiteTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait MenuOptionsApi
{
    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/menu_options/form Форма для опций меню сайта
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function menuOptionsForm()
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $user = Auth::user();

        if (!$user->hasPermission('menu_options_edit')) {
            return $this->error('У вас нет прав для редактирования меню');
        }

        return $this->success([
            'menu_options' => $site->menu_options
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/sites/menu_options/save Сохранение параметров меню сайта
     * @apiGroup Site
     * @apiParam {json} menu_options Опции меню
     */
    public function menuOptionsSave(Request $request)
    {
        $data = $request->all();
        $site = Site::query()->whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден');
        }

        if (!isset($data['menu_options']) || empty($data['menu_options'])) {
            return $this->error('Не заданы параметры меню');
        }

        $menuOptions = json_decode($data['menu_options']);

        if (!$menuOptions) {
            return $this->error('Невалидный json формат');
        }

        $site->update([
            'menu_options' => $data['menu_options']
        ]);

        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));
        ModuleSettings::flushCache();
        ModuleSlide::flushCache();
        ModuleArticle::flushCache();

        return $this->success();
    }
}