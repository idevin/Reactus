<?php

namespace App\Http\Controllers\Api;

use App\Contracts\RssAgregator;
use App\Contracts\SiteMapAggregator;
use App\Helpers\Deployer\Classes\Deployer;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Domain;
use App\Models\DomainThematic;
use App\Models\DomainVolume;
use App\Models\FeedbackRecipient;
use App\Models\Language;
use App\Models\Modules\Module;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleContacts;
use App\Models\Modules\ModuleFeedback;
use App\Models\Modules\ModuleInformation;
use App\Models\Modules\ModuleMenu;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSocials;
use App\Models\NeoCard;
use App\Models\NeoObjectField;
use App\Models\NeoUserCatalogData;
use App\Models\Role;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Site;
use App\Models\SiteStorageImage;
use App\Models\SiteUser;
use App\Models\StorageFile;
use App\Models\Template;
use App\Models\TemplateScheme;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Api\Sites\ContactsApi;
use App\Traits\Api\Sites\FeedbackSettingsApi;
use App\Traits\Api\Sites\MenuOptionsApi;
use App\Traits\Api\Sites\SeoApi;
use App\Traits\Api\Sites\UserbarOptionsApi;
use App\Traits\Api\Sites\ViewApi;
use App\Traits\Contacts;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Feedback;
use App\Traits\Media;
use App\Traits\Menu;
use App\Traits\NeoObject;
use App\Traits\Selectel;
use App\Traits\Site as SiteTrait;
use App\Traits\User as UserTrait;
use App\Traits\Utils;
use App\Utils\DomainInstaller;
use Bukashk0zzz\YmlGenerator\Generator;
use Bukashk0zzz\YmlGenerator\Model\Category;
use Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple;
use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Cache;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Session;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Validator;

/**
 * Class SitesController
 * @package App\Http\Controllers\Api
 * @group  ??????????
 */
class SitesController extends Controller
{
    /**
     * @activity done
     */
    use Media;
    use DomainTrait;
    use Menu;
    use CustomValidators;
    use Utils;
    use SeoApi;
    use ContactsApi;
    use ViewApi;
    use Contacts;
    use UserTrait;
    use Feedback;
    use NeoObject;
    use Activity;
    use MenuOptionsApi;
    use UserbarOptionsApi;
    use FeedbackSettingsApi;

    /**
     * SitesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setObject(Site::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['update', 'updateDomain', 'updateSettings']);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/check ???????????????? ???? ???????????? ?? ??????????
     * @apiGroup Site
     *
     */
    public function check()
    {
        $anonRole = Role::whereIsAnon(1)->first();

        if ($anonRole) {
            $site = get_site();
            $message = '???????? ????????????';
            $denied = User::globalCan('site_access', $site, $message);

            if ($denied) {
                return $denied;
            }
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/update Update
     * @apiGroup Site
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {integer} parent_id ???????????????? ??????????
     *
     * @apiParam {string} title ???????????????? ??????????
     * @apiParam {Text} content ???????????????? ??????????
     *
     * @apiParam {string} domain_name ?????? ????????????
     * @apiParam {string} domain_id ???????????????? ?????? ?????????? ????????????
     * @apiParam {string} parent_id ???????????????????????? ????????
     *
     * @apiParam {string} slogan ????????????
     * @apiParam {string} copyright ?????????????????? ??????????
     * @apiParam {Text} articles_description ???????????????? ?????? ???????????????? ????????????
     *
     * @apiParam {integer} template_id ID ??????????????
     * @apiParam {integer} template_scheme_id ID ??????????????
     *
     * @apiParam {Hex} default_color ?????????????????? ???????? ?????? ???????????????? ?? ????.
     *
     * @apiParam {Url} facebook_url ?????????????????? ???? facebook
     * @apiParam {Url} vk_url ?????????????????? ??????????????????
     * @apiParam {Url} ok_url ?????????????????? ??????????????????????????.????
     * @apiParam {Url} twitter_url ?????????????????? ?? twitter
     * @apiParam {Url} instagram_url ?????????????????? ?? Instagram
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {string} address ??????????
     * @apiParam {string} work_hours ?????????? ????????????
     * @apiParam {string} email Email ?????? ??????????
     *
     * @apiParam {Boolean} filter_articles ???????????????? ???????????? ????????????
     * @apiParam {Boolean} filter_sections ???????????????? ???????????? ????????????????
     *
     * @apiParam {integer} articles_limit ?????????? ???????????? ???? ????????????????
     * @apiParam {integer} sections_limit ?????????? ???????????????? ???? ????????????????
     *
     * @apiParam {string} filter_articles_sort ???????????????????? ???????????? ???? ????????
     * @apiParam {string} filter_articles_sort_direction ???????????????????? ???????????? ???? ?????????????????????? ?????? ???????????????? (asc|desc)
     *
     * @apiParam {string} filter_sections_sort ???????????????????? ???????????????? ???? ????????
     * @apiParam {string} filter_sections_sort_direction ???????????????????? ???????????????? ???? ?????????????????????? ?????? ???????????????? (asc|desc)
     * @apiParam {Base64} logo ???????? ?????? ?????????? ?? ?????????????? base64
     * @apiParam {Base64} image ?????????????? ???????????????? ?? ?????????????? base64
     * @apiParam {Base64} favicon favicon base64
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            if (isset($this)) {
                return $this->error('???????? ???? ????????????...', null, 404);
            }
        }

        if (!Auth::user() && !Auth::user()->can('site_edit', $site)) {
            return $this->error('???? ???? ???????????? ???????? ?????? ???????????????????????????? ??????????');
        }

        $customErrors = [];

        if (!empty($data['vk_url'])) {
            $customErrors['vk_url'] = 'url|active_url';
        }

        if (!empty($data['ok_url'])) {
            $customErrors['ok_url'] = 'url|active_url';
        }

        if (!empty($data['facebook_url'])) {
            $customErrors['facebook_url'] = 'url|active_url';
        }

        if (!empty($data['twitter_url'])) {
            $customErrors['twitter_url'] = 'url|active_url';
        }

        if (!empty($data['instagram_url'])) {
            $customErrors['instagram_url'] = 'url|active_url';
        }

        if (!empty($data['email'])) {
            $customErrors['email'] = 'email';
        }

        if (!empty($data['title'])) {
            $customErrors['title'] = 'max:200|min:3';
        }

        $parentId = null;
        $siteParent = null;
        $exceptErrors = ['domain'];

        if (!empty($data['parent_id'])) {
            $siteParent = Site::thematic()->find($data['parent_id']);
            if (!$siteParent) {
                return $this->error('???????????????????????? ???????? ???? ????????????');
            }

            $parentId = $siteParent->id;
        } else {
            $exceptErrors[] = 'parent_id';
        }

        $validator = self::createSiteValidator($data, $exceptErrors, $customErrors);

        if (!$validator->fails()) {
            $languages = Language::orderBy('priority')->get();
            $languageIds = array_values($languages->pluck('id')->toArray());

            if (!empty($data['interface_language']) &&
                in_array($data['interface_language'], $languageIds)
            ) {

                $site->siteDomain()->update([
                    'language_id' => $data['interface_language']
                ]);
            }

            if (!empty($data['image'])) {
                self::saveSiteStorage($site, $data['image'], SiteStorageImage::IMAGE);
                $data['image'] = basename($data['image']['url']);
            } else {
                self::deleteSiteStorageImage($site, SiteStorageImage::IMAGE);
            }

            if (!empty($data['logo'])) {
                self::saveSiteStorage($site, $data['logo'], SiteStorageImage::LOGO);
                $data['logo'] = basename($data['logo']['url']);
            } else {
                self::deleteSiteStorageImage($site, SiteStorageImage::LOGO);
            }

            $cleanData = collect($data)->except(['user_id', 'domain_id', 'user', 'token', 'domain'])->toArray();

            if (isset($data['domain_id']) && isset($data['domain_name'])) {

                if (empty($site->parent_id)) {
                    return $this->error('???????????? ?????????????????????????? ?????????????? ????????????');
                }

                $newDomain = Domain::thematic()->find($data['domain_id']);
                $domainName = slugify($data['domain_name']);

                if (!$newDomain) {
                    return $this->error('?????????? ???? ????????????...');
                }

                if (mb_strlen($domainName) > 63) {
                    return $this->error('?????? ???????????? ???????????? ???????? ???????????? 63 ????????????????');
                }

                $newSiteName = $domainName . '.' . $newDomain->name;

                if (mb_strlen($newSiteName) > 255) {
                    return $this->error('?????? ?????????? ?????????????? ???????????? ???????? ???????????? 255 ????????????????');
                }

                $siteExists = Site::where('domain', $newSiteName)->first();

                if ($siteExists) {
                    return $this->error('?????????? ???????? ?????? ????????????????????');
                }

                $env = env('ENV');

                $siteNewParent = Site::withTrashed()->where('domain', $newDomain->name)->first();

                if (!$siteNewParent) {

                    $template = Template::whereDefault(1)->get()->first();
                    $templateScheme = TemplateScheme::default()->first();

                    Site::firstOrCreate([
                        'domain' => idnToUtf8($newDomain->name),
                        'domain_id' => $newDomain->id,
                        'title' => idnToUtf8($newDomain->name),
                        'template_id' => $template->id,
                        'user_id' => Auth::user() ? Auth::user()->id : null,
                        'template_scheme_id' => $templateScheme->id
                    ]);

                    (new DomainInstaller($env))->install($newDomain->name, $newDomain->domainVolume);
                }

                $oldDomain = Domain::thematic()
                    ->where('name', idnToAscii($site->domain))->first();

                if (!$oldDomain) {
                    return $this->error('???????????? ?????????? ???? ????????????');
                }

                $this->deleteDomain($oldDomain);

                $oldDomain->update([
                    'name' => $newSiteName,
                    'parent_id' => $newDomain->id
                ]);

                (new DomainInstaller($env))->install($newSiteName, $oldDomain->domainVolume);

                $cleanData['domain_id'] = $oldDomain->id;
                $cleanData['domain'] = idnToUtf8($newSiteName);
            }

            $site->update($cleanData);

            if ($parentId) {
                $site->makeChildOf($siteParent);
            }

            $this->updateSiteSettings($site);

        } else {
            return $this->error($validator->errors());
        }

        Session::forget('site');
        Session::put('site', $site);
        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));

        SiteStorageImage::flushCache();

        $this->setIsSystem(false);
        $this->setParams($site->toArray());
        $this->createActivity();

        return $this->success($site);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/theme ?????????????????? ???????? ?????? ??????????
     * @apiParam {string} [domain] ??????????
     * @apiGroup Site
     */
    public function theme(Request $request)
    {
        $domain = $request->get('domain', env('DOMAIN'));

        $site = $this->getSite($domain);
        if (!$site) {
            return $this->error('???????? ???? ????????????');
        }

        $theme = $site->templateScheme->makeHidden(['created_at', 'updated_at']);

        $themeData = $theme->toArray();

        return $this->success($themeData);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/update_settings ???????????????????? ????????????????
     * @apiGroup Site
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {string} title ???????????????? ??????????
     * @apiParam {string} slogan ????????????
     * @apiParam {string} interface_language ?????????? ??????????
     * @apiParam {string} captcha_hash ?????? ?????????????????????? ?????? ????????
     * @apiParam {array} feedback_recipients ???????????????????? ???????????????? ?????????? (???????????? E-mail)
     *
     */
    public function updateSettings(Request $request)
    {
        $data = $request->all();
        $site = Site::query()->where('domain', env('DOMAIN'))->get()->first();
        $except = [];

        if (!$site) {
            return $this->error('???????? ???? ????????????...', null, 404);
        }

        if (!Auth::user() || !Auth::user()->can('site_edit', $site)) {
            return $this->error('???? ???? ???????????? ???????? ?????? ???????????????????????????? ??????????');
        }

        if (Auth::user() && !Auth::user()->can('site_name_edit', $site)) {
            unset($data['title']);
            $except[] = 'title';

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('?? ?????? ?????? ???????? ?????? ???????????????????????????? ????????????');
            }
        }

        if (Auth::user() && !Auth::user()->can('site_slogan_edit', $site)) {
            unset($data['slogan']);
            return $this->error('?? ?????? ?????? ???????? ?????? ???????????????????????????? ??????????????');
        }

        $validator = self::createSiteUpdateValidator($data, $except);

        if (!$validator->fails()) {
            $languages = Language::query()->orderBy('priority', 'asc')->get();

            $languageIds = array_values($languages->pluck('id')->toArray());

            if (!empty($data['interface_language'])) {
                if (!in_array((int)$data['interface_language'], $languageIds)) {
                    return $this->error('?????????? ???????? ???? ???????????? ');
                } else {
                    $site->siteDomain()->update([
                        'language_id' => $data['interface_language']
                    ]);
                }
            }

            if (isset($data['captcha_hash'])) {
                $data['captcha_hash'] = strip_tags($data['captcha_hash']);
            }

            $site->update($data);

            $seoTitle = isset($data['seo_title']) ? $data['seo_title'] : null;
            $seoDescription = isset($data['seo_description']) ? $data['seo_description'] : null;
            $seoBreadcrumbs = isset($data['seo_breadcrumbs']) ? $data['seo_breadcrumbs'] : null;

            $settingsData = [
                'seo_title' => $seoTitle,
                'seo_description' => $seoDescription,
                'seo_breadcrumbs' => $seoBreadcrumbs
            ];

            if ($site->setting) {
                $site->setting->update($settingsData);
            } else {
                Setting::firstOrCreate($settingsData);
            }

            if (Auth::user() && Auth::user()->can('site_feedback_get', $site) &&
                !empty($data['feedback_recipients'])) {
                collect($data['feedback_recipients'])->unique()->map(function ($email) use ($site) {
                    FeedbackRecipient::firstOrCreate([
                        'site_id' => $site->id,
                        'email' => $email
                    ]);
                });
            }

        } else {
            return $this->error($validator->errors());
        }

        Session::forget('site');
        Session::put('site', $site);

        $siteKey = (SiteTrait::getSiteCacheKey());
        forget($siteKey);

        forget('settings.' . env('DOMAIN'));

        SiteStorageImage::flushCache();

        $site = $site->only(['id', 'title', 'slogan']);
        $site = array_merge($site, $settingsData);

        $this->setIsSystem(false);
        $this->setParams($site);
        $this->createActivity();

        return $this->success($site);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/breadcrumbs/update ???????????????????? ?????????????? ????????????
     * @apiGroup Site
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {boolean} breadcrumbs ?????????????? ???????????? (0 - ??????, 1 - ????)
     * @apiParam {string} breadcrumbs_options ????????????
     * @apiParam {boolean} breadcrumbs_position ?????????????? ?????????????? ???????????? (0 - ??????????, 1 - ???? ????????????, 2 - ????????????)
     */
    public function breadcrumbsUpdate(Request $request): JsonResponse
    {
        $data = $request->all();
        $site = Site::query()->whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('???????? ???? ????????????...');
        }

        if (!Auth::user() || !Auth::user()->can('site_edit', $site)) {
            return $this->error('???? ???? ???????????? ???????? ?????? ???????????????????????????? ??????????');
        }

        $validator = self::createSiteBreadcrumbsValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (!json_decode($data['breadcrumbs_options'])) {
            return $this->error('???? ???????????? JSON');
        }

        $site->update([
            'breadcrumbs' => (int)$data['breadcrumbs'],
            'breadcrumbs_options' => $data['breadcrumbs_options'] ?? null,
            'breadcrumbs_position' => $data['breadcrumbs_position'] ?? null
        ]);

        Session::forget('site');
        Session::put('site', $site);

        $siteKey = (SiteTrait::getSiteCacheKey());
        forget($siteKey);

        forget('settings.' . env('DOMAIN'));

        SiteStorageImage::flushCache();

        $site = $site->only(['breadcrumbs', 'breadcrumbs_options']);

        $this->setIsSystem(false);
        $this->setParams($site);
        $this->createActivity();

        return $this->success($site);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/breadcrumbs/form ?????????? ?????????????? ????????????
     * @apiGroup Site
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     */
    public function breadcrumbsForm(): JsonResponse
    {
        $site = Site::query()->whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('???????? ???? ????????????...');
        }

        if (!Auth::user() || !Auth::user()->can('site_edit', $site)) {
            return $this->error('???? ???? ???????????? ???????? ?????? ???????????????????????????? ??????????');
        }

        $site = $site->only(['breadcrumbs', 'breadcrumbs_options', 'breadcrumbs_position']);

        $this->setIsSystem(false);
        $this->setParams($site);
        $this->createActivity();

        return $this->success($site);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/search ?????????? ???? ??????????
     * @apiGroup Site
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {string} term ?????????????? ?????? ????????????
     *
     */
    public function search(Request $request)
    {
        $term = $request->get('term', null);
        $sites = [];

        if ($term) {
            $sites = Site::thematic()
                ->select(['site.id', 'title', 'domain'])
                ->where('domain', 'like', '%' . $term . '%')
                ->orWhere('title', 'like', '%' . $term . '%')
                ->get();

            if (count($sites) > 0) {
                $sites = $sites->makeHidden(['url', 'thumbs']);
            }
        }

        return $this->success($sites);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/sites/filter_domains ???????????? ?????????????? ???? ?????????? ?? ????????????????
     * @apiGroup Site
     *
     * @apiParam {string} language (1,2,3....) ???????????????? ??????????
     * @apiParam {string} domain_thematic_id ID ???????????????? ??????????????
     * @apiParam {string} slug ?????? ???????????? ([slug].domain.com)
     */
    public function filterDomains(Request $request)
    {
        $languageId = $request->get('language');
        $thematic = $request->get('domain_thematic_id');
        $slug = $request->get('slug');

        if (!$slug) {
            return $this->error('???? ???????????? ?????? ????????????');
        }

        $domains = Domain::thematic()->own()->whereNull('parent_id')
            ->orderBy('name')->roots();
        $foundParam = null;

        if ($languageId) {
            $domains = $domains->where('language_id', $languageId);
        }

        if ($thematic) {
            $domains = $domains->where('domain_thematic_id', $thematic);
        }

        $domains = $domains->get();

        if (count($domains) > 0) {

            $domains = $domains->filter(function ($domain) use ($slug) {
                $domainWithSlug = $slug . '.' . $domain->name;
                $foundDomain = Domain::where('name', $domainWithSlug)
                    ->first();

                if (!$foundDomain) {
                    return true;
                } else {
                    return false;
                }
            });

            if (count($domains) > 0) {
                $domains = $domains->makeHidden(['default', 'created_at', 'updated_at',
                    'domain_type', 'environment', 'info', 'is_default', 'user_id']);
            }

            $foundLongDomain = null;

            $data['domains'] = $domains->values()->map(function ($domain)
            use ($slug, &$foundLongDomain) {
                $domain['parent_id'] = $domain['id'];
                $domainWithSlug = $slug . '.' . idnToAscii($domain['name']);

                if (mb_strlen($domainWithSlug) > 255) {
                    $foundLongDomain = true;
                }
                return $domain;
            });

            if ($foundLongDomain) {
                return $this->error('?????????? ?????????? ?????????? ???? ???????????? ???????? ???????????? 255
                ????????????????');
            }
        }

        return $this->success($domains);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/search_domain ?????????? ???????????????? ?????????????????? ??????????
     * @apiGroup Site
     *
     * @apiParam {string} term ?????????????? ???????????? ???? ?????????????? (test.example.com)
     *
     */
    public function searchDomain(Request $request)
    {
        $term = $request->get('term');
        if (!$term) {
            return $this->error('???? ?????????? ???????????????? ????????????');
        }

        $term = preg_replace('#[^??-??a-zA-z0-9\.\-]+#iu', '', $term);

        $domainExists = Domain::where('name', '=', idnToAscii($term))->get()->first();

        if ($domainExists) {
            return $this->error('?????????? ?????????? ????????????????????');
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/validate_domain ?????????????????? ???????????? ????????????
     * @apiGroup Site
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {string} domain ?????? ????????????
     *
     */
    public function validateDomain(Request $request)
    {
        $data = $request->all();

        $validator = self::createSiteDomainValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        return $this->success();
    }


    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/validate_site ?????????????????? ?????????? ?????? ??????????????????
     * @apiGroup Site
     *
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {integer} parent_id ID ?????????????????????????? ????????????
     * @apiParam {string} name ???????????? ???????????????? ??????????????????
     *
     */
    public function validateSite(Request $request)
    {
        $data = $request->all();

        $validator = self::createSiteValidator($data,
            ['title', 'content', 'domain'], ['name' => 'required|unique:domain'],
            ['name.required' => '???????????????? ???????????????? ????????????']);

        $domain = Domain::thematic()->find($data['parent_id']);

        if (!$domain) {
            return $this->error('???????????????????????? ?????????? ???? ???????????? ?? ??????????????');
        }

        $site = Site::where('domain', $data['name'] . '.' . idnToAscii($domain->name))->first();

        if ($site) {
            return $this->error('?????????? ???????? ?????? ????????');
        }

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        return $this->success();
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/tree Get Sites tree
     * @apiGroup Site
     *
     */
    public function tree()
    {
        function recursiveCollection(&$sites)
        {
            foreach ($sites as $id => $site) {

                $site = collect($site);

                $site = $site->only(['id', 'title', 'domain', 'children', 'slogan', 'site_domain'])
                    ->toArray();
                if ($site['site_domain']['domain_type'] != Domain::DOMAIN_TYPE_SYSTEM) {

                    $oSite = Site::find($site['id']);
                    $site['site_logo'] = $oSite->originalLogo();


                    if (!empty($sites[$id]['children'])) {
                        $sites[$id]['children'] = recursiveCollection($sites[$id]['children']);
                    }
                } else {
                    unset($sites[$id]);
                }
            }

            return array_values($sites);
        }

        $siteRoot = Site::roots()->get();
        $sites = [];
        foreach ($siteRoot as $value) {
            $allSites = $value->getDescendants()->toHierarchy()->toArray();

            if (!empty($allSites)) {
                $sites[$value->id] = $value;
                $sites[$value->id]['children'] = recursiveCollection($allSites);
            }
        }
        $sites = array_values($sites);

        return $this->success($sites);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @internal param Request $request
     * @api {POST} /api/sites/create ???????????????? ??????????
     * @apiGroup Site
     *
     * @apiParam {integer} domain_id ID ?????????????????? ?????? ??????????
     *
     * @apiParam {string} name ?????? ??????????????????
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {string} custom_domain ?????????? ????????????????????????
     * @apiParam {integer} template_id ID ??????????????
     * @apiParam {string} slogan ???????????? ?????? ??????????
     * @apiParam {string} title ???????????????? ??????????
     */
    public function create(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        if (Auth::user() && Auth::user()->can('site_create', new Site())) {

            if (empty($data['domain_id'])) {
                return $this->error('???? ???????????? ??????????');
            }

            if (!isset($data['template_id']) || empty($data['template_id'])) {
                return $this->error('???? ???? ?????????????? ????????????');
            }

            if (empty($data['name'])) {
                return $this->error('???? ?????????????? ?????? ?????? ??????????');
            }

            if (mb_strlen($data['name']) > 63) {
                return $this->error('?????? ?????????? ???????????? ???????? ???????????? 63 ????????????????');
            }

            $siteSlug = $this->siteSlug($data['name']);

            switch ($siteSlug) {
                case is_array($siteSlug):
                    $data['name'] = $siteSlug['slug'];
                    break;
                case is_a($siteSlug, JsonResponse::class);
                    return $siteSlug;
            }

            $domain = Domain::thematic()->find($data['domain_id']);

            if (!$domain) {
                return $this->error('?????????? ???? ????????????');
            } else {

                $siteDomain = Site::withTrashed()->whereDomain($domain->name)->first();

                if (!$siteDomain) {

                    $template = Template::whereDefault(1)->first();
                    $templateScheme = TemplateScheme::default()->first();

                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($domain->name . ': Create site');
                    }

                    Site::create([
                        'domain' => $domain->name,
                        'domain_id' => $domain->id,
                        'title' => $domain->name,
                        'template_id' => $template->id,
                        'user_id' => Auth::user()->id,
                        'template_scheme_id' => $templateScheme->id
                    ]);
                }

                $fullDomainName = $data['name'] . '.' . idnToAscii($domain->name);

                if (mb_strlen($fullDomainName) > 255) {
                    return $this->error('?????? ?????????? ?????????????? ???????????? ???????? ???????????? 255 ????????????????');
                }

                $site = Site::withTrashed()->whereDomain($fullDomainName)->get()->first();

                if ($site) {
                    return $this->error('?????????? ???????? ?????? ???????? ?? ??????????????');
                } else {

                    if (env('DEVELOPMENT') == true) {
                        $env = 0;
                    } else {
                        $env = 1;
                    }

                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($fullDomainName . ': Create domain');
                    }

                    $defaultLanguage = Language::whereAlias(config('app.locale'))->first();

                    $pvc = DomainVolume::createPvc();

                    $newDomain = Domain::query()->firstOrCreate(['name' => $fullDomainName], [
                        'name' => $fullDomainName,
                        'parent_id' => $domain->id,
                        'domain_type' => Domain::DOMAIN_TYPE_THEMATIC,
                        'is_default' => 0,
                        'environment' => $env,
                        'language_id' => $defaultLanguage->id,
                        'user_id' => Auth::user()->id,
                        'domain_volume_id' => $pvc->id,
                        'is_customer_domain' => 1
                    ]);

                    $customerSite = null;

                    if (isset($data['custom_domain']) && !empty($data['custom_domain'])) {

                        $customDomainName = idnToAscii($data['custom_domain']);

                        if (check_domain_name($customDomainName) == true) {
                            $customDomainExists = Domain::query()->whereName($customDomainName)->first();

                            if ($customDomainExists) {
                                return $this->error('?????????? ???????????????????????? ?????????? ?????? ????????');
                            }

                            $pvc = DomainVolume::createPvc();

                            $customDomain = Domain::query()->firstOrCreate(['name' => $customDomainName], [
                                'name' => $customDomainName,
                                'parent_id' => $newDomain->id,
                                'domain_type' => Domain::DOMAIN_TYPE_THEMATIC,
                                'is_default' => 0,
                                'environment' => $env,
                                'language_id' => $defaultLanguage->id,
                                'user_id' => Auth::user()->id,
                                'domain_volume_id' => $pvc->id,
                                'is_customer_domain' => 1
                            ]);

                            Selectel::addNsRecords($customDomainName);

                            $template = Template::whereDefault(1)->first();
                            $templateScheme = TemplateScheme::default()->first();

                            if (!$templateScheme) {
                                if (count($template->templateSchemes) > 0) {
                                    $templateScheme = $template->templateSchemes->random();
                                } else {
                                    $templateScheme = TemplateScheme::all()->random();
                                }
                            }

                            $customerSite = Site::query()->firstOrCreate(['domain' => $customDomainName], [
                                'domain' => $customDomainName,
                                'domain_id' => $customDomain->id,
                                'title' => $customDomain->name,
                                'template_id' => $template->id,
                                'user_id' => Auth::user()->id,
                                'template_scheme_id' => $templateScheme->id
                            ]);

                        } else {
                            return $this->error('???????????????? ?????? ?????????????????????????? ????????????');
                        }
                        $data['customer_domain'] = $customDomainName;
                    }

                    $site = self::createSite($fullDomainName, $newDomain, Auth::user(),
                        $domain, false, false, $data);

                    $customerSite?->update([
                        'parent_id' => $site->id
                    ]);

                    SiteUser::query()->firstOrCreate([
                        'user_id' => Auth::user()->id,
                        'site_id' => $site->id
                    ]);

                    Auth::user()->trigger('site_create');

                    return $this->success($site);
                }
            }
        }

        return $this->error('???????????????? ??????????????????...');
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/slug ?????????????? ?? ?????????? ???????????? ?????? ?????????????? ?????????? ????????????
     * @apiGroup Site
     *
     * @apiParam {string} term ?????????? ?????? ????????????
     *
     */
    public function slug(Request $request)
    {
        $term = $request->get('term');

        if (!$term) {
            return $this->error('???? ???????????? ???????????????? ??????????');
        }

        $data = $this->siteSlug($term);

        switch ($data) {
            case is_array($data):
                return $this->success($data);
            case is_a($data, JsonResponse::class);
                return $data;
        }

        return $this->error('???????????????????? ?????????????? ????????');
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @internal param Request $request
     * @api {POST} /api/sites/create_domain ?????????????????????? ????????????
     * @apiGroup Site
     *
     * @apiParam {string} name ?????? ????????????
     * @apiParam {string} reserved_domain ?????? ???????????????????? ????????????
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     */
    public function createDomain(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $validator = self::createSiteDomainValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (Auth::user() && Auth::user()->can('site_create', new Site())) {

            $domain = Domain::thematic()->whereName(idnToAscii($data['name']))->first();

            if ($domain) {
                return $this->error('?????????? ?????????? ?????? ????????');
            }

            if (mb_substr_count($data['name'], '.') >= 2) {
                return $this->error('?????????? ???? ?????????? ???????? 3-???? ????????????');
            }

            $defaultLanguage = Language::whereAlias(\Lang::getLocale())->first();

            if (env('DEVELOPMENT') == true) {
                $env = Domain::DEVELOPMENT;
            } else {
                $env = Domain::PRODUCTION;
            }

            $parentDomain = Domain::query()->whereName(env('DOMAIN'))->first();

            if (!$parentDomain) {
                return $this->error('???????????????????????? ?????????? ???? ????????????');
            }

            $pvc = DomainVolume::createPvc();

            $newDomain = Domain::query()->firstOrCreate(['name' => $data['name']], [
                'name' => $data['name'],
                'domain_type' => Domain::DOMAIN_TYPE_THEMATIC,
                'user_id' => Auth::user()->id,
                'environment' => $env,
                'language_id' => $defaultLanguage->id,
                'parent_id' => $parentDomain->id,
                'domain_volume_id' => $pvc->id,
                'is_customer_domain' => 1
            ]);

            if (isset($data['template_id'])) {
                $template = Template::find($data['template_id']);
                if (!$template) {
                    $template = Template::whereDefault(1)->first();
                }
            } else {
                $template = Template::whereDefault(1)->first();
            }
            $templateScheme = TemplateScheme::default()->first();

            if (!$templateScheme) {
                if (count($template->templateSchemes) > 0) {
                    $templateScheme = $template->templateSchemes->random();
                } else {
                    $templateScheme = TemplateScheme::all()->random();
                }
            }

            $site = Site::query()->firstOrCreate(['domain' => $newDomain->name], [
                'domain' => $newDomain->name,
                'domain_id' => $newDomain->id,
                'title' => $newDomain->name,
                'template_id' => $template->id,
                'user_id' => Auth::user()->id,
                'template_scheme_id' => $templateScheme->id,
                'parent_id' => null
            ]);

            SiteUser::firstOrCreate(['user_id' => Auth::user()->id, 'site_id' => $site->id]);

            $data['customer_domain'] = $site->domain;

            (new Deployer($newDomain->name, $pvc, false, $newDomain->name))->v1();

            $site->update([
                'parent_id' => $parentDomain->site->id
            ]);

            return $this->success(['domain' => $data['name']]);
        } else {
            return $this->error('?? ?????? ?????? ???????? ?????? ???????????????? ??????????');
        }
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/update_domain ???????????????????? ????????????
     * @apiGroup Site
     *
     * @apiParam {string} name ?????? ????????????
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     * @apiParam {integer} domain_thematic_id ID ???????????????? ???????????? (??????????????????????????)
     * @apiParam {integer} parent ID ?????????????????????????? ????????????
     * @apiParam {integer} id ID ?????????????????????????? ????????????
     * @apiParam {string} old_name ???????????? ?????? ????????????
     * @apiParam {string} custom_domain ???????????????????????????????? ?????? ????????????
     *
     */
    public function updateDomain(Request $request)
    {
        $data = $request->all();

        $customErrors['parent'] = 'required|numeric';
        $customErrors['old_name'] = 'required|domain_valid';

        $customMessages['parent.required'] = '???????????????? ???????????????????????? ??????????';
        $customMessages['old_name.required'] = '???? ???????????? ?????? ?????????????? ????????????';

        $currentDomain = Domain::find($data['id']);

        if (!$currentDomain) {
            return $this->error('?????????????? ?????????? ???? ????????????');
        }

        if (mb_substr_count($data['name'], '.') > 0) {
            $matches = preg_split('/\./', $data['name']);
            $newName = $matches[0];
            $implodedDomain = Domain::query()->whereName($matches[1] . '.' . $matches[2])->first();
            if (!$implodedDomain || $implodedDomain->name != $currentDomain->name) {
                return $this->error('?????????????? ?????????? ???? ????????????');
            }
        } else {
            $newName = slugify($data['name']);
        }

        $newDomainName = $data['name'] = slugify($newName) . '.' . $currentDomain->name;

        $validator = self::createSiteDomainValidator($data, [], $customErrors, $customMessages);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (isset($data['domain_thematic_id'])) {
            $domainThematic = DomainThematic::find($data['domain_thematic_id']);
            if (!$domainThematic) {
                return $this->error('???????????????? ???????????? ???? ??????????????');
            }
        }

        $parentDomain = Domain::thematic()->find($data['parent']);
        $oldDomain = Domain::thematic()->whereName(idnToAscii($data['old_name']))->first();

        if (!$oldDomain) {
            return $this->error('???????????? ?????????? ???? ????????????');
        }

        $domain = Domain::thematic()->where('name', $newDomainName)->first();

        if ($domain && $oldDomain->name != $newDomainName) {
            return $this->error('?????????? ?????????? ???????????????????? ?? ??????????????');
        }

        if (!$parentDomain) {
            return $this->error('???????????????????????? ?????????? ???? ????????????');
        }

        $environment = env('ENV');

        self::deleteDomain($oldDomain);

        $oldSite = Site::whereDomain(idnToAscii($oldDomain->name))->first();
        $parentSite = Site::whereDomain(idnToAscii($parentDomain->name))
            ->first();

        $oldSite->update([
            'domain' => $newDomainName
        ]);

        $oldSite->makeChildOf($parentSite);

        $oldDomain->update([
            'name' => $newDomainName,
            'parent_id' => $parentDomain->id,
            'domain_thematic_id' => isset($domainThematic) ? $domainThematic->id : null
        ]);

        $oldSite->refresh();
        $oldDomain->refresh();

        $installer = new DomainInstaller($environment);

        $installer->install($oldDomain->name, $oldDomain->domainVolume);

        $this->setIsSystem(false);
        $this->setParams($oldDomain->toArray());
        $this->createActivity();

        return $this->success($oldSite);
    }

    /**
     *
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/edit ?????????? ?????? ???????????????? ??????????
     * @apiGroup Site
     *
     * @internal param Request $request
     */
    public function edit()
    {
        $data['domains'] = Domain::thematic()->own()->roots()->orderBy('name', 'asc')
            ->get(['name', 'parent_id', 'id', 'language_id', 'domain_thematic_id']);

        if (count($data['domains']) > 0) {
            $data['domains'] = $data['domains']->makeHidden(['id'])->map(function ($domain) {
                $domain->parent_id = $domain->id;
                $domain->domain_id = $domain->id;
                return $domain;
            });
        }

        if (Auth::user() && !Auth::user()->can('site_create', new Site())) {
            return $this->error('???? ???? ???????????? ?????????????????? ??????????');
        }

        $data['thematic_select'] = DomainThematic::orderBy('name', 'asc')->get();
        $data['language_select'] = Language::orderBy('priority', 'asc')
            ->get()->pluck('title', 'id');

        return $this->success($data);
    }

    /**
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/sites/form ?????????? ??????????
     * @apiGroup Site
     * @apiParam {string} token ?????????? ???????? ????????????????????????
     */
    public function form()
    {
        $parent = Domain::getTree();
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('???????? ???? ????????????...');
        }

        if (Auth::user() && !Auth::user()->can('site_edit', $site)) {
            return $this->error('?? ?????? ?????? ???????? ???????????????????????????? ???????????????? ????????');
        }

        if (!$site->setting) {
            $site->setting = Setting::firstOrCreate([
                'site_id' => $site->id
            ]);
        }

        $site->site_logo = $site->originalLogo();
        $site->site_header = $site->originalSiteHeader();
        $site->seo_title = $site->setting->seo_title;
        $site->seo_description = $site->setting->seo_description;
        $site->seo_breadcrumbs = $site->setting->seo_breadcrumbs;

        $site->makeHidden([
            'image', 'logo', 'lft', 'rgt', 'header', 'deleted_at', 'articles_description',
            'header_home', 'depth', 'created_at', 'updated_at', 'archive', 'default_color',
            'articles_limit', 'setting', 'siteDomain'
        ]);

        $site->siteDomain->makeHidden(['created_at', 'updated_at',
            'domain_type', 'is_default', 'default',
            'environment', 'user_id', 'info']);

        $articlesSortOptions = Article::$sortOptions;
        $sectionsSortOptions = Section::$sortOptions;
        $articlesViewOptions = Article::$viewOptions;
        $sectionsViewOptions = Section::$viewOptions;

        $filterDirections = function ($element, $index) {
            $o = new stdClass();
            $o->$element = $index;

            return $o;
        };

        ModuleSettings::flushCache();

        $templates = Template::query()->orderBy('name', 'ASC')->get();
        $blocks = ModuleSettings::getBlocks($site);

        $currentTemplate = Template::whereAlias(Template::getForDomain())->first();

        if ($currentTemplate && count($currentTemplate->templateSchemes) > 0) {
            $templateSchemes = $currentTemplate->templateSchemes;
        } else {
            $templateSchemes = TemplateScheme::query()->orderBy('name', 'ASC')->get();
        }

        $headerBlocks = Module::query()
            ->whereIn('class', [ModuleMenu::class, ModuleInformation::class, ModuleFeedback::class])->get();

        $footerBlocks = Module::query()
            ->whereIn('class', [ModuleSocials::class, ModuleContacts::class,
                ModuleFeedback::class])->get();

        if (count($footerBlocks) > 0) {
            $footerBlocks->makeHidden(['url']);
        }

        /**
         * @todo ???????????????????? options ?????????????????? ?????? ????????????
         * @todo ?????????????????? ???????????? ?????????????????? ?????? ?????????????? ?????? ???????????? ????????????
         * @todo ???????????? data.blocks.content.module
         */
        $modules = Module::getModules();

        $languageSelect = Language::query()->orderBy('priority', 'asc')->get()->pluck('title', 'id');

        $thematicSelect = DomainThematic::query()->orderBy('name', 'asc')->get();

        $domains = Domain::thematic()->orderBy('name', 'desc')->own()->roots()->get(['id', 'name']);

        if (count($domains) > 0) {
            foreach ($domains as &$domain) {
                $domain->name = idnToUtf8($domain->name);
            }
        }

        $feedbackRecipients = collect();

        if (Auth::user()->can('site_feedback_get', $site)) {
            $feedbackRecipients = $site->feedbackRecipients;
        }

        $options = [
            'article' => [
                'sorts' => $articlesSortOptions,
                'sort_directions' => collect(Article::$directions)->map($filterDirections),
                'views' => $articlesViewOptions,
                'limits' => Article::$limits
            ],
            'section' => [
                'sorts' => $sectionsSortOptions,
                'sort_directions' => collect(Section::$directions)->map($filterDirections),
                'views' => $sectionsViewOptions,
                'limits' => Section::$limits
            ],
            'header_blocks' => $headerBlocks,
            'footer_blocks' => $footerBlocks,
            'template_schemes' => $templateSchemes,
            'templates' => $templates,
            'modules' => $modules,
            'language_select' => $languageSelect,
            'thematic_select' => $thematicSelect,
            'domains' => $domains,
            'feedback_recipients' => $feedbackRecipients
        ];

        return $this->success([
            'parent' => $parent,
            'site' => $site,
            'options' => $options,
            'blocks' => $blocks
        ]);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/v2/form ???????????????????????????? ??????????
     * @apiGroup Site
     * @apiParam {string} token ???????? ????????????????????????
     */
    public function formV2(): bool|JsonResponse|string
    {
        $siteObject = $this->getSite(env('DOMAIN'));

        if (!$siteObject) {
            return $this->error('???????? ???? ????????????');
        }

        if (Auth::user() && !Auth::user()->can('site_edit', $siteObject)) {
            return $this->error('?? ?????? ?????? ???????? ?????? ???????????????????????????? ??????????');
        }

        $site = $siteObject->only(['title', 'slogan', 'content', 'breadcrumbs_options', 'user']);

        $site['favicon'] = $siteObject->faviconUrl();

        $userData = ['id', 'thumbs', 'first_name', 'username', 'last_name'];
        $site['user'] = $siteObject->siteDomain?->user?->only($userData);

        $site['domain'] = main_domain($siteObject->siteDomain->name);
        $site['domain_id'] = main_domain($siteObject->siteDomain->id);
        $site['parent_id'] = main_domain($siteObject->siteDomain->parent_id);
        $site['custom_domain'] = $siteObject->siteDomain->custom_domain;

        $domainParts = preg_split('#\.#', $siteObject->siteDomain->name);

        $domainPart = $domainParts[0];

        $site['domain_part'] = $domainPart;

        $articlesSortOptions = Article::$sortOptions;
        $sectionsSortOptions = Section::$sortOptions;
        $articlesViewOptions = Article::$viewOptions;
        $sectionsViewOptions = Section::$viewOptions;

        $filterDirections = function ($element, $index) {
            $o = new stdClass();
            $o->$element = $index;

            return $o;
        };

        $templates = Template::query()->orderBy('name', 'ASC')->get();

        $currentTemplate = Template::whereAlias(Template::getForDomain())->first();

        if ($currentTemplate && count($currentTemplate->templateSchemes) > 0) {
            $templateSchemes = $currentTemplate->templateSchemes;
        } else {
            $templateSchemes = TemplateScheme::query()->orderBy('name', 'ASC')->get();
        }

        $modules = Module::getModules();

        $languageSelect = Language::query()->orderBy('priority')->get()->pluck('title', 'id');

        $thematicSelect = DomainThematic::query()->orderBy('name')->get();

        $domains = Domain::thematic()->orderBy('name', 'desc')->own()->roots()->get(['id', 'name']);

        if (count($domains) > 0) {
            foreach ($domains as &$domain) {
                $domain->name = idnToUtf8($domain->name);
            }
        }

        $feedbackRecipients = collect();

        if (Auth::user()->can('site_feedback_get', $siteObject)) {
            $feedbackRecipients = $siteObject->feedbackRecipients;
        }

        $options = [
            'article' => [
                'sorts' => $articlesSortOptions,
                'sort_directions' => collect(Article::$directions)->map($filterDirections),
                'views' => $articlesViewOptions,
                'limits' => Article::$limits
            ],
            'section' => [
                'sorts' => $sectionsSortOptions,
                'sort_directions' => collect(Section::$directions)->map($filterDirections),
                'views' => $sectionsViewOptions,
                'limits' => Section::$limits
            ],
            'template_schemes' => $templateSchemes,
            'templates' => $templates,
            'modules' => $modules,
            'language_select' => $languageSelect,
            'thematic_select' => $thematicSelect,
            'domains' => $domains,
            'feedback_recipients' => $feedbackRecipients
        ];

        return $this->success([
            'site' => $site,
            'options' => $options
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/sites/change_domain ?????????????????? ?????????? ??????????
     * @apiGroup Site
     * @apiParam {string} new_domain_name ?????????? ?????? ????????????
     * @apiParam {integer} domain_id ID ?????????????????????????? ????????????
     * @apiParam {string} token ???????? ????????????????????????
     */
    public function changeDomain(Request $request): JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'new_domain_name' => 'required',
            'domain_id' => 'required|numeric'
        ], [
            'new_domain_name.required' => '???? ???????????? ?????????? ??????',
            'domain_id.required' => '???? ?????????? ID ????????????',
            'domain_id.numeric' => 'ID ???????????? ???????????? ???????? ????????????????',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $domain = Domain::find($data['domain_id']);

        if (!$domain) {
            return $this->error('?????????? ???? ????????????');
        }

        $site = $this->getSite(env('DOMAIN'));

        if ($site->siteDomain->user_id !== Auth::user()->id || is_null($site->siteDomain->user_id)) {
            return $this->error('?????? ???????????? ???????????????? ?????? ????????????');
        }

        $newDomainName = $data['new_domain_name'] . '.' . $domain->name;

        $exists = Domain::query()->whereName($newDomainName)->first();

        if ($exists) {
            return $this->error('?????????? ?????????? ?????? ????????????????????');
        }

        $alias = preg_replace('#\.#', '-', $newDomainName);


        $site->update([
            'domain' => $newDomainName
        ]);

        $domain->update([
            'name' => $newDomainName
        ]);

        $domain->refresh();

        self::domainInstall($newDomainName, $alias, $domain->domainVolume);

        $alias = preg_replace('#\.#', '-', $domain->name);

        self::helmUninstall($alias);

        return $this->success($newDomainName);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/sites/v2/update ???????????????????? ??????????
     * @apiGroup Site
     * @apiParam {string} token ???????? ????????????????????????
     * @apiParam {string} title ???????????????? ??????????
     * @apiParam {object} favicon ????????????
     * @apiParam {string} slogan ????????????
     * @apiParam {string} content ??????????????????
     */
    public function updateV2(Request $request)
    {
        $data = $request->all();
        $site = $this->getSite(env('DOMAIN'));

        $updateData = [];
        if (isset($data['title'])) {
            $updateData['title'] = trim(strip_tags($data['title']));
        }

        if (isset($data['slogan'])) {
            $updateData['slogan'] = trim(strip_tags($data['slogan']));
        }

        if (isset($data['content'])) {
            $updateData['content'] = trim(strip_tags($data['content']));
        }

        if (isset($data['favicon'])) {
            if (isset($data['favicon']['id'])) {

                $file = StorageFile::query()->find($data['favicon']['id']);

                if (!$file) {
                    return $this->error('???????? ?????? favicon ???? ????????????');
                }

                $image = SiteStorageImage::whereSiteId($site->id)
                    ->whereType(SiteStorageImage::FAVICON)->first();

                $iconData = [
                    'storage_file_id' => $file->id,
                    'site_id' => $site->id,
                    'type' => SiteStorageImage::FAVICON
                ];

                if ($image) {
                    $image->update($iconData);
                    $image->refresh();
                } else {
                    SiteStorageImage::firstOrCreate($iconData);
                }
            }
        }

        if (!empty($updateData)) {
            $site->update($updateData);
        }

        Session::forget('site');
        Session::put('site', $site);
        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));

        SiteStorageImage::flushCache();

        $siteData = $site->toArray();
        $siteData['favicon'] = $site->faviconUrl();

        return $this->success($siteData);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/sites/home ?????????????? ????????????????
     * @apiGroup Site
     */
    public function home(Request $request)
    {
        $startTime = microtime(true);
        $site = $this->getSite(env('DOMAIN'));

        if (!$site) {
            return $this->error('???????? ?????????????????? ???? ???????????? ????????????????????...');
        }

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('home getFeedbackFields');
        }

        $feedback = $this->getFeedbackFields($site);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('home getFeedbackFields end');
        }

        $breadcrumbs = [
            ['??????????????' => route('home')]
        ];

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('home getHomeBlocks');
        }

        $startBLocks = microtime(true);
        $blocks = ModuleSettings::getHomeBlocks($site, $request);

        if (env('APP_DEBUG_VARS') == true) {
            $endBlocks = microtime(true);
            debugvars('home getHomeBlocks end in ' . ($endBlocks - $startBLocks));
        }

        $endTime = microtime(true);

        $s = $endTime - $startTime;

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('home in seconds: ' . $s);
        }

        $settingsData = [
            'seo_title' => $site->setting ? $site->setting->seo_title : null,
            'seo_description' => $site->setting ? $site->setting->seo_description : null,
            'seo_breadcrumbs' => $site->setting ? $site->setting->seo_breadcrumbs : null
        ];

        return $this->success([
            'contacts' => [
                'phone' => ($site->user) ? $site->user->phone : null,
                'email' => ($site->user) ? $site->user->email : $site->email,
                'address' => $site->address,
                'workHours' => $site->work_hours
            ],
            'feedback' => $feedback,
            'breadcrumbs' => $breadcrumbs,
            'blocks' => $blocks,
            'stroke_miniatures' => ModuleStroke::$miniatureTypes,
            'modules' => Module::getModules(),
            'settings' => $settingsData
        ]);
    }

    /**
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/sites/settings ?????????????????? ?????? ??????????
     * @apiGroup Site
     *
     */
    public function settings()
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars(env('DOMAIN') . ' - 404');
            }

            return $this->error('???????? ???? ????????????');
        }

        if (isset($site->copyright)) {
            $copyright = $site->copyright;
        } else {
            $copyright = idnToUtf8($site->domain) . ' ?? ' . date('Y');
        }

        if (!$site->templateScheme) {
            $site = $site->getTemplateScheme();

            forget(SiteTrait::getSiteCacheKey());
            remember(SiteTrait::getSiteCacheKey(), function () use ($site) {
                return $site;
            });
        }

        $blocks = ModuleSettings::getSettingsBlocks($site);
        $logo = $site->originalLogo();
        $siteHeader = $site->originalSiteHeader();

        if ($logo) {
            $logo = !empty($logo['thumbs']) ? $logo['thumbs']['thumb280x157'] : null;
        }

        $theme = $site->templateScheme->makeHidden(['created_at', 'updated_at']);

        $themeData = $theme->toArray();

        $parent = Domain::whereId($site->siteDomain->parent_id)->first();

        if ($parent && $site->siteDomain->domain_type != Domain::DOMAIN_TYPE_THEMATIC) {
            $objectDomains = $parent->languages()->with(['language'])->get();
            $objectDomains->push($parent);
        } else {
            $objectDomains = $site->siteDomain->languages()->get();
        }

        $currentLanguage = $site->siteDomain->language;
        $languages = [];

        if (count($objectDomains) > 0) {

            $languages = $objectDomains->map(function ($domain) use ($currentLanguage) {
                if ($currentLanguage && $currentLanguage->id != $domain->language->id) {
                    return [
                        'domain' => $domain->name,
                        'language' => $domain->language
                    ];
                } else {
                    return null;
                }
            })->toArray();
            $languages = array_values(array_filter($languages));
        }


        $defaultSettings = [
            'show_article_rating' => $site->show_article_rating,
            'show_section_rating' => $site->show_section_rating,
            'show_article_author' => $site->show_article_author,
            'hide_article_author_inside' => $site->hide_article_author_inside,
            'hide_section_tags' => $site->hide_section_tags,
            'breadcrumbs' => $site->breadcrumbs,
            'breadcrumbs_position' => $site->breadcrumbs_position
        ];

        $modules = Module::all()->toArray();

        $data = [
            'theme' => $themeData,
            'contacts' => [
                'phone' => $site->phone,
                'email' => $site->email,
                'address' => $site->address,
                'work_hours' => $site->work_hours,
                'show_in_about_page' => $site->show_in_about_page,
                'jivosite' => $site->jivosite,
                'text' => $site->text,
                'facebook_url' => $site->facebook_url,
                'vk_url' => $site->vk_url,
                'twitter_url' => $site->twitter_url,
                'instagram_url' => $site->instagram_url,
                'ok_url' => $site->ok_url,
                'coords' => $site->coords,
                'copyright' => $copyright
            ],
            'site' => [
                'id' => $site->id,
                'parent_id' => $site->parent_id,
                'title' => $site->title,
                'slogan' => $site->slogan,
                'description' => $site->content,
                'favicon' => $site->faviconUrl(),
                'site_logo' => $logo,
                'site_header' => $siteHeader
            ],
            'articles_description' => $site->articles_description,
            'blocks' => $blocks,
            'default_settings' => $defaultSettings,
            'languages' => $languages,
            'current_language' => $currentLanguage,
            'modules' => empty($modules) ? null : $modules,
        ];

        $denied = User::globalCan('site_access', $site, '???? ???? ???????????? ?????????????????????????? ????????', $data);

        if ($denied) {
            return $denied;
        }

        return $this->success($data);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/sites/options/form ???????????????????????????? ???????????????????? ??????????
     * @apiGroup Site
     * @apiParam {string} token ?????????? ????????????????????????
     *
     *
     */
    public function optionsForm()
    {
        $site = Site::query()->whereDomain(env('DOMAIN'))
            ->get(['id', 'show_article_rating', 'show_section_rating', 'hide_article_author_inside',
                'show_article_author', 'hide_section_tags', 'breadcrumbs', 'breadcrumbs_position', 'repeat_animation',])
            ->first()->makeHidden(['url', 'site_preview'])->toArray();

        $site['breadcrumbs_position_select'] = Site::$breadcrumbsPosition;

        return $this->success($site);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/sites/menu/form ???????????????????????????? ???????? ??????????
     * @apiGroup Site
     * @apiParam {string} token ?????????? ????????????????????????
     *
     */
    public function menuForm()
    {
        $site = $this->getSite(env('DOMAIN'));

        $menu = \App\Models\Menu::query()->BySite($site->id)->get();

        return $this->success($menu);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/sites/options/save ???????????????????? ???????????????????? ??????????
     * @apiGroup Site
     * @apiParam {Boolean} show_article_rating ???????????????????? ?????????????? ???????????? (0|1)
     * @apiParam {Boolean} show_section_rating ???????????????????? ?????????????? ?????????????? (0|1)
     * @apiParam {Boolean} hide_article_author_inside ???????????????? ???????????? ?? ???????????? (0|1)
     * @apiParam {Boolean} show_article_author ???????????????????? ???????????? ???????????? ?? ???????????? ???????????? (0|1)
     * @apiParam {Boolean} hide_section_tags ???? ???????????????????? ???????? ?? ?????????????? (0|1)
     * @apiParam {Boolean} breadcrumbs ?????????? ?????????????? ???????????? (0 - ??????, 1 - ????)
     * @apiParam {Boolean} breadcrumbs_position ?????????????? ?????????????? ???????????? (0 - ??????????, 1 - ???? ????????????, 2 - ????????????)
     *
     */
    public function optionsSave(Request $request)
    {
        $data = $request->all();
        $site = Site::query()->whereDomain(env('DOMAIN'))->first();

        if (Auth::user() && !Auth::user()->can('site_settings_access', $site)) {
            return $this->error('?? ?????? ?????? ???????? ?????? ???????????????????????????? ????????????????');
        }

        if (!$site) {
            return $this->error('???????? ???? ????????????');
        }

        $setData = function ($name) use ($data, $site) {
            if (isset($data[$name]) && in_array($data[$name], [true, false])) {
                $site->$name = (int)$data[$name];
            }
        };

        $params = [
            'show_article_rating', 'show_section_rating', 'hide_article_author_inside',
            'show_article_author', 'breadcrumbs', 'repeat_animation',
        ];

        foreach ($params as $param) {
            $setData($param);
        }

        if (Auth::user() && Auth::user()->can('content_tag_manage', $site)) {
            if (isset($data['hide_section_tags']) && in_array($data['hide_section_tags'], [true, false])) {
                $site->hide_section_tags = (int)$data['hide_section_tags'];
            }
        }

        if (isset($data['breadcrumbs_position'])) {
            $site->breadcrumbs_position = (int)$data['breadcrumbs_position'];
        }

        $site->save();

        $this->updateSiteSettings($site);

        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));
        ModuleSettings::flushCache();
        ModuleSlide::flushCache();
        ModuleArticle::flushCache();

        $site = $site->only(['id', 'show_article_rating', 'show_section_rating', 'hide_article_author_inside',
            'show_article_author', 'hide_section_tags', 'breadcrumbs', 'breadcrumbs_position', 'repeat_animation',]);

        return $this->success($site);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @throws Exception
     * @api {POST} /api/sites/destroy ???????????????? ??????????
     * @apiGroup Site
     * @apiParam {string} domain ?????? ????????????
     *
     *
     */
    public function destroy(Request $request)
    {
        $domain = $request->get('domain');
        $user = Auth::user();

        if (!$domain) {
            return $this->error('???? ???????????? ?????? ??????????????');
        }

        $site = Site::query()->whereDomain($domain)->first();

        if (!$site) {
            return $this->error('???????????? ???? ????????????');
        }

        if ($site->user_id != $user->id) {
            return $this->error('???????? ???? ????????????');
        }

        $site->delete();

        $siteKey = Site::class . '.' . idnToAscii($site->domain);

        Cache::forget($siteKey);

        return $this->success(compact($site));
    }

    public function rss()
    {
        /** @var Site $obSite */
        $obSite = $this->getSite(env('DOMAIN'));
        if (empty($obSite)) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('RSS: ' . env('DOMAIN') . " " . RssAgregator::STATUS_ERROR);
            }

            return null;
        }

        $obRss = new RssAgregator($obSite);
        if ($obRss->status() == RssAgregator::STATUS_ERROR) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('RSS: ' . RssAgregator::STATUS_ERROR, $obRss->errors());
            }

            return null;
        }
        $obRss->with(Article::class);
        return response($obRss->getXML())->header('Content-Type', 'application/xml');
    }

    public function sitemap()
    {
        $site = get_site();
        if (empty($site)) {
            return response('', 400);
        }

        $siteMap = new SiteMapAggregator($site);
        $siteMap->with([Article::class, Section::class, NeoUserCatalogData::class, NeoCard::class]);
        return response($siteMap->getSiteMapXMLString(), 200)->header('Content-Type', 'application/xml');
    }

    public function yandexMarket()
    {
        $site = get_site();
        $file = tempnam(sys_get_temp_dir(), 'YMLGenerator');
        $categories = [];
        $offers = [];
        $currencies = [];
        $deliveries = [];

        $exceptedFields = [
            NeoObjectField::FIELD_TYPE_FEEDBACK,
            NeoObjectField::FIELD_TYPE_CARD_SELECT,
            NeoObjectField::FIELD_TYPE_FILE,
            NeoObjectField::FIELD_TYPE_TARIFF_PRICE,
            NeoObjectField::FIELD_TYPE_IMAGE,
            NeoObjectField::FIELD_TYPE_TARIFF
        ];

        $settings = (new Settings())->setOutputFile($file)->setEncoding('UTF-8');

        $shopInfo = (new ShopInfo())
            ->setName($site->title)
            ->setCompany($site->description)
            ->setUrl(getSchema() . idnToAscii($site->domain));

        $catalogs = NeoUserCatalogData::query()->whereSiteId($site->id)->get();

        if (count($catalogs) > 0) {
            foreach ($catalogs as $catalog) {
                $categories[] = (new Category())
                    ->setId($catalog->id)
                    ->setName($catalog->catalog_name);

                if (count($catalog->cards) == 0) {
                    continue;
                }

                foreach ($catalog->cards as $card) {
                    if (count($card->fieldUserGroups) == 0) {
                        continue;
                    }

                    $description = '';
                    $images = [];
                    $price = 100;

                    foreach ($card->fieldUserGroups as $fieldUserGroup) {
                        if (count($fieldUserGroup->fields) == 0) {
                            continue;
                        }

                        foreach ($fieldUserGroup->fields as $field) {
                            $data = $field->data;

                            if ($field->field->alias == 'price') {
                                $price = (float)$field->data;
                            }

                            if ($field->field->field_type['id'] == NeoObjectField::FIELD_TYPE_IMAGE) {
                                if (!empty($field->data)) {
                                    foreach ($field->data as $img) {
                                        $images[] = getSchema() . idnToAscii($site->domain) . $img['url'];
                                    }
                                }
                            }

                            if (!in_array($field->field->field_type['id'], $exceptedFields)) {

                                switch ($field->field->field_type['id']) {
                                    case NeoObjectField::FIELD_TYPE_EDITOR:
                                        $data = json_decode($data, true);
                                        $blockData = '';

                                        if (!empty($data['blocks'])) {

                                            foreach ($data['blocks'] as $block) {
                                                $blockData .= strip_tags($block['text']);
                                            }
                                        }
                                        $data = $blockData;
                                        break;

                                    case NeoObjectField::FIELD_TYPE_MULTISELECT:
                                        if (!empty($data)) {
                                            $data = implode(', ', $data);
                                        }
                                }

                                if ($data) {
                                    $description .= $field->field->name;
                                    $description .= ': ' . ($data ? $data : '-');
                                    $description .= ", \n";
                                }
                            }
                        }

                        $description = trim(rtrim($description, ", \n"));
                    }

                    $offer = new OfferSimple();

                    $offer->setId($card->id)
                        ->setAvailable(true)
                        ->setUrl(route('objects.view_card', [
                            'name' => slugify($card->name),
                            'id' => $card->id
                        ]))->setPrice($price)
                        ->setCurrencyId('RUB')
                        ->setCategoryId($catalog->id)
                        ->setDelivery(false)
                        ->setName($card->name);

                    if (!empty($images)) {
                        $offer->setPictures($images);
                    }

                    if (!empty($description)) {
                        $offer->setDescription($description);
                    }

                    $offers[] = $offer;
                }
            }
        }

        (new Generator($settings))->generate(
            $shopInfo,
            $currencies,
            $categories,
            $offers,
            $deliveries
        );

        $xml = file_get_contents($file);

        return response($xml)->header('Content-Type', 'application/xml');
    }
}
