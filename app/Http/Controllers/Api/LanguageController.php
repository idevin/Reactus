<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\DomainVolume;
use App\Models\Language;
use App\Models\Site;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use App\Traits\Menu;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller
{
    /**
     * @activitty done
     */
    use Media;
    use DomainTrait;
    use Menu;
    use CustomValidators;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Language::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['add', 'addDomain']);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/language/form Форма для создания мультиязычности
     * @apiGroup Language
     *
     * @apiParam {string} token Токен ключ пользователя
     */
    public function form()
    {
        $languageSelect = Language::query()->orderBy('priority', 'asc')->get();
        $site = Site::query()->whereDomain(env('DOMAIN'))->first();
        $parent = Domain::query()->find($site->siteDomain->parent_id);

        if ($parent && $site->siteDomain->domain_type != Domain::DOMAIN_TYPE_THEMATIC) {
            $languageChildren = $parent->languages()->get(['id', 'name', 'language_id']);
            $site = $parent->site;
        } else {
            $languageChildren = $site->siteDomain->languages()->get(['id', 'name', 'language_id']);
        }

        if ($languageChildren) {
            $languageChildren = $languageChildren->keyBy('language_id');
        }

        if ($languageSelect) {
            $languageSelect = $languageSelect->keyBy('id');
        }

        $languageSelect = $languageSelect->forget($site->siteDomain->language_id);

        return $this->success([
            'language_select' => array_values($languageSelect->toArray()),
            'site' => $site,
            'languages_count' => $languageChildren->count(),
            'domains' => array_values($languageChildren->toArray())
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/language/add_domain Добавление мультиязычного сайта
     * @apiGroup Language
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} domain Имя домена (en.domain.com или mydomain.com)
     * @apiParam {integer} languageId ID языка
     */
    public function addDomain(Request $request)
    {
        $domain = $request->get('domain');
        $languageId = $request->get('languageId');

        if (empty($domain)) {
            return $this->error('Не найдено название домена');
        }

        $oDomain = Domain::whereName($domain)->first();
        $oLanguage = Language::query()->find($languageId);
        $currentDomain = Domain::whereName(env('DOMAIN'))->first();

        if ($oDomain) {
            return $this->error('Такой домен уже существует');
        }

        if (!$currentDomain) {
            return $this->error('Текущий домен не найден');
        }

        if (!$oLanguage) {
            return $this->error('Язык не найден');
        }

        $languageChildren = $currentDomain->languages()->get();

        if (count($languageChildren) >= config('netgamer.domain_language_limit')) {
            return $this->error('У Вас исчерпан лимит мультиязычных доменов');
        }

        if (mb_strlen($domain) > 255) {
            return $this->error('Домен слишком длинный');
        }

        if (env('DEVELOPMENT') == true) {
            $env = 0;
        } else {
            $env = 1;
        }

        $pvc = DomainVolume::createPvc();

        $newDomain = Domain::create([
            'name' => $domain,
            'domain_type' => Domain::DOMAIN_TYPE_LANGUAGE,
            'is_default' => 0,
            'default' => 0,
            'user_id' => Auth::user()->id,
            'environment' => $env,
            'parent_id' => $currentDomain->id,
            'language_id' => $oLanguage->id,
            'domain_thematic_id' => $currentDomain->domain_thematic_id,
            'domain_volume_id' => $pvc->id
        ]);

        self::createSite($domain, $newDomain, Auth::user(), $currentDomain);

        $this->setIsSystem(false);
        $this->setParams($newDomain->toArray());
        $this->createActivity();

        return $this->success([
            'parent' => $newDomain->only(['id', 'name'])
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/language/add Добавление языка
     * @apiGroup Language
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} language_id ID языка
     */
    public function add(Request $request)
    {
        $languageId = $request->get('language_id');
        $domain = Domain::whereName(env('DOMAIN'))->first();

        if (!$domain) {
            return $this->error('Домен не найден');
        }

        $language = Language::query()->find($languageId);

        $result = $this->checkLanguage($languageId, $domain);

        if (!is_array($result)) {
            return $result;
        }

        $domainString = $language->alias . '.' . $domain->name;

        $newDomain = Domain::whereName($domainString)->first();
        $newSite = Site::whereDomain($domainString)->first();

        if (!$newDomain && !$newSite) {

            $pvc = DomainVolume::createPvc();

            $newDomain = Domain::query()->create([
                'name' => $domainString,
                'domain_type' => Domain::DOMAIN_TYPE_LANGUAGE,
                'is_default' => 0,
                'default' => 0,
                'user_id' => Auth::user()->id,
                'environment' => env('DEVELOPMENT') == true ? 0 : 1,
                'parent_id' => $domain->id,
                'language_id' => $result['language']->id,
                'domain_thematic_id' => $domain->domain_thematic_id,
                'domain_volume_id' => $pvc->id
            ]);

            self::createSite($domainString, $newDomain, Auth::user(), $domain);
        } else {
            return $this->error('Такой домен уже существует');
        }

        $this->setIsSystem(false);
        $this->setParams($newDomain->toArray());
        $this->createActivity();

        return $this->success([
            'domain' => $domainString
        ]);
    }

    public function checkLanguage($languageId, $domain): JsonResponse|array
    {
        $language = Language::query()->find($languageId);

        if (!$language) {
            return $this->error('Язык не найден');
        }

        $languageChildren = $domain->languages()->get();

        if (count($languageChildren) >= config('netgamer.domain_language_limit')) {
            return $this->error('У Вас исчерпан лимит мультиязычных доменов');
        }

        return compact('language');
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/language/my_domain Добавление своего домена
     * @apiGroup Language
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} domain имя подключаемого домена
     * @apiParam {integer} language_id ID языка
     */
    public function myDomain(Request $request)
    {
        $languageId = $request->get('language_id');
        $domainName = $request->get('domain');

        $domain = Domain::whereName($domainName)->first();

        $currentDomain = Domain::whereName(env('DOMAIN'))->first();

        if (!$currentDomain) {
            return $this->error('Текущий домен не найден');
        }

        if ($domain) {
            return $this->error('Такой домен уже есть');
        }

        $result = $this->checkLanguage($languageId, $domain);

        if (!is_array($result)) {
            return $result;
        }

        $validator = self::createSiteDomainValidator([
            'name' => $domainName
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        return $this->success([
            'domain' => $domainName,
            'language' => $result['language']
        ]);
    }
}