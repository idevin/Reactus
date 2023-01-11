<?php

namespace App\Traits\Api\Sites;


use App\Models\Setting;
use App\Models\Site;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use Illuminate\Http\JsonResponse;
use RobotsTxtParser\RobotsTxtParser;
use Session;
use Symfony\Component\HttpFoundation\Request;

trait SeoApi
{
    /**
     * @return JsonResponse
     * @api {GET} /api/sites/seo/form Форма для SEO
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function seoForm(): JsonResponse
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $settings = [
            'title' => $site->title,
            'disable_indexing' => $site->disable_indexing,
            'head_tags' => $site->head_tags
        ];

        if ($site->setting) {
            $settings = $settings + $site->setting->toArray();
            $settings['robots_data'] = Utils::getRobotsTxt();
        }

        return $this->success($settings);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/sites/seo/save Сохранение формы SEO
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} title название сайта
     * @apiParam {string} yandex_code ТОЛЬКО хеш-код яндекса
     * @apiParam {string} google_code ТОЛЬКО хеш-код Google
     * @apiParam {string} yandex_verification ТОЛЬКО хеш-код Яндекс верификации сайта
     * @apiParam {string} google_verification ТОЛЬКО хеш-код Google верификации сайта
     * @apiParam {string} robots_data контент файла robots.txt
     * @apiParam {string} seo_title Мета название
     * @apiParam {string} seo_description Мета описание
     *
     */
    public function seoSave(Request $request): JsonResponse
    {
        $data = $request->all();
        $site = Site::whereDomain(env('DOMAIN'))->get()->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $siteSetting = $site->setting;

        if (!$siteSetting) {
            $siteSetting = Setting::firstOrCreate([
                'site_id' => $site->id
            ]);
        }

        $yandexCode = null;
        $googleCode = null;
        $googleVerification = null;
        $yandexVerification = null;
        $seoTitle = null;
        $seoDescription = null;
        $googleTag = null;

        $siteData = [];

        if (isset($data['yandex_code'])) {
            $yandexCode = trim(strip_tags($data['yandex_code']));
        }

        if (isset($data['google_code'])) {
            $googleCode = trim(strip_tags($data['google_code']));
        }

        if (isset($data['google_tag'])) {
            $googleTag = trim(strip_tags($data['google_tag']));
        }

        if (isset($data['yandex_verification'])) {
            $yandexVerification = trim(strip_tags($data['yandex_verification']));
        }

        if (isset($data['google_verification'])) {
            $googleVerification = trim(strip_tags($data['google_verification']));
        }

        if (isset($data['title'])) {
            $title = Utils::cleanChars($data['title']);

            $siteData += [
                'title' => $title
            ];
        }

        if (isset($data['seo_title']) && !empty($data['seo_title'])) {
            $seoTitle = Utils::cleanChars($data['seo_title']);
        }

        if (isset($data['seo_description']) && !empty($data['seo_description'])) {
            $seoDescription = Utils::cleanChars($data['seo_description']);
        }

        if (isset($data['disable_indexing'])) {
            $siteData['disable_indexing'] = (bool)$data['disable_indexing'];
        }

        if (isset($data['head_tags']) && !empty($data['head_tags'])) {
            $siteData['head_tags'] = strip_tags($data['head_tags'], ['meta']);
        }

        if (!empty($data['robots_data'])) {
            $parser = new RobotsTxtParser($data['robots_data']);
            $rules = $parser->getRules();

            if (empty($rules)) {
                return $this->error("Неверные данные для robots.txt");
            }

            if ($siteData['disable_indexing'] == true) {
                $robotsTxtData = self::getDisallowedRobotsString();
            } else {
                $robotsTxtData = $this->getRobotsString($rules);
            }

            if (empty($robotsTxtData)) {
                return $this->error("Невозможно синхронизировать файл robots.txt");
            }

            $robotsTxtPath = Utils::getRobotsTxtPath();
            file_put_contents($robotsTxtPath, $robotsTxtData);
        }

        if (!empty($siteData)) {
            $site->update($siteData);
        }

        $allData = [
            'yandex_code' => $yandexCode,
            'google_code' => $googleCode,
            'yandex_verification' => $yandexVerification,
            'google_verification' => $googleVerification,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'google_tag' => $googleTag
        ];

        $siteSetting->update($allData);

        $allData += [
            'head_tags' => $siteData['head_tags'] ?? null,
            'disable_indexing' => (int)$siteData['disable_indexing']
        ];

        reloadSite($site);

        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));

        return $this->success($allData);
    }
}