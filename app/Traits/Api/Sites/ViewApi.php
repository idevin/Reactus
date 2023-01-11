<?php

namespace App\Traits\Api\Sites;

use App\Models\Site;
use App\Models\SiteStorageImage;
use App\Models\User;
use App\Traits\HasRoles;
use App\Traits\Site as SiteTrait;
use Auth;
use Log;
use Session;
use Symfony\Component\HttpFoundation\Request;

trait ViewApi
{
    use HasRoles;

    /**
     * @api {GET} /api/sites/view/form Форма внешнего вида
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     * @return JSON
     */
    public function viewForm()
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        $denied = User::globalCan('site_look_edit', $site,
            'вы не имеете прав для сохранения внешнего вида сайта');

        if ($denied) {
            return $denied;
        }

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $site->site_logo = $site->originalLogo();
        $site->site_preview = $site->originalSiteHeader();
        $site->favicon = $site->faviconUrl();
        $site = $site->only(['id', 'site_preview', 'site_logo', 'favicon']);

        return $this->success($site);
    }

    /**
     * @api {POST} /api/sites/view/save Сохранение формы внешнего вида
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     * @param Request $request
     * @return JSON
     */
    public function viewSave(Request $request)
    {
        $data = $request->all();
        $site = Site::whereDomain(env('DOMAIN'))->get()->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $denied = User::globalCan('site_edit', $site,
            'вы не имеете прав для сохранения внешнего вида сайта');

        if ($denied) {
            return $denied;
        }

        if (Auth::user() && Auth::user()->can('site_look_background_image_edit', $site)) {

            if (!empty($data['site_preview'])) {
                $this->processSiteSlides($data, $site);
            } else {
                self::deleteSiteStorageImages($site);
            }

        } else {
            unset($data['site_preview']);
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('У вас нет прав для обновления фонового изображения');
            }
        }

        if (Auth::user() && Auth::user()->can('site_look_logo_image_edit', $site)) {

            if (!empty($data['site_logo'])) {
                self::saveSiteStorage($site, $data['site_logo'], SiteStorageImage::LOGO);
                $data['site_logo'] = basename($data['site_logo']['url']);
            } else {
                self::deleteSiteStorageImage($site, SiteStorageImage::LOGO);
            }

        } else {
            unset($data['site_logo']);
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('У вас нет прав для обновления лого');
            }
        }

        if (!empty($data['favicon'])) {

            self::saveSiteStorage($site, $data['favicon'], SiteStorageImage::FAVICON);

            $site->favicon = $data['favicon'] = basename($data['favicon']['url']);
        } else {
            self::deleteSiteStorageImage($site, SiteStorageImage::FAVICON);
            $data['favicon'] = null;
        }

        $oSite = $site->update($data);
        $site->site_logo = $site->originalLogo();
        $site = $site->only(['id', 'site_preview', 'site_logo', 'favicon']);

        if (Auth::user() && Auth::user()->can('site_look_logo_image_edit', $oSite)) {
            if (!empty($site['site_logo'])) {
                $site['site_logo']['thumbs'] = $this->addHash($site['site_logo']['thumbs']);
            }
        }

        if (Auth::user() && Auth::user()->can('site_look_background_image_edit', $oSite)) {

            if (!empty($site['site_preview'])) {
                $site['site_preview']['thumbs'] = $this->addHash($site['site_preview']['thumbs']);
            }
        }

        $site = (new Site())->fill($site);

       reloadSite($site);

        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));

        SiteStorageImage::flushCache();

        return $this->success($site);
    }
}