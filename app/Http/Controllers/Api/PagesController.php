<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Modules\Module;
use App\Models\Page;
use App\Models\Site;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Page as PageTrait;
use App\Traits\Site as SiteTrait;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @activity done
     */
    use Activity;
    use PageTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Page::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['index']);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/pages Список готовых страниц
     * @apiGroup Pages
     *
     * @internal param \Request $request
     * @internal param Request $request
     */
    public function index(): bool|JsonResponse|string
    {
        $pages = Page::query()->with(['strokes' => function ($query) {
            $query->with(['modules']);
        }])->orderBy('slug')->get();

        return $this->success(compact('pages'));
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/pages/settings Настройки для страниц
     * @apiGroup Pages
     *
     * @internal param Request $request
     */
    public function settings(): bool|JsonResponse|string
    {
        $site = Site::whereDomain(env('DOMAIN'))->get()->first();

        if (!$site) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars(env('DOMAIN') . ' - 404');
            }
            return $this->error('Сайт не найден');
        }

        $copyright = $site->copyright ?? idnToUtf8($site->domain) . ' © ' . date('Y');

        if (!$site->templateScheme) {
            $site = $site->getTemplateScheme();

            forget(SiteTrait::getSiteCacheKey());
            remember(SiteTrait::getSiteCacheKey(), function () use ($site) {
                return $site;
            });
        }

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
            'breadcrumbs_position' => $site->breadcrumbs_position,
            'breadcrumbs_options' => $site->breadcrumbs_options
        ];

        $modules = Module::all()->toArray();

        $page = Page::query()->home()->bySite($site->id)->with(['header', 'footer'])->first();

        if (!$page) {
            $page = Page::createDefault();
        }

        $data = [
            'theme' => $themeData,
            'page_id' => $page->id,
            'header' => $page->header,
            'footer' => $page->footer,
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
                'site_header' => $siteHeader,
                'menu_options' => $site->menu_options
            ],
            'articles_description' => $site->articles_description,
            'default_settings' => $defaultSettings,
            'languages' => $languages,
            'current_language' => $currentLanguage,
            'modules' => empty($modules) ? null : $modules,
        ];

        $denied = User::globalCan('site_access', $site, 'Вы не можете просматривать сайт', $data);

        if ($denied) {
            return $denied;
        }

        return $this->success($data);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/pages/home Главная страница
     * @apiGroup Pages
     *
     * @internal param \Request $request
     * @internal param Request $request
     */
    public function home(): JsonResponse
    {
        $site = $this->getSite(env('DOMAIN'));

        $page = Page::query()->home()->bySite($site->id)->first();

        if (!$page) {
            $page = Page::createDefault();
        }

        $page->makeHidden(['header', 'footer']);

        $breadcrumbs = [
            [__('Home Page') => route('home')]
        ];

        $settings = [
            'seo_title' => $site->setting?->seo_title,
            'seo_description' => $site->setting?->seo_description,
            'seo_breadcrumbs' => $site->setting?->seo_breadcrumbs
        ];

        $contacts = [
            'phone' => ($site->user) ? $site->user->phone : null,
            'email' => ($site->user) ? $site->user->email : $site->email,
            'address' => $site->address,
            'workHours' => $site->work_hours
        ];

        if (!empty($page->strokes)) {
            foreach ($page->strokes as $stroke) {
                $modules = $stroke->modules()->get();

                if (count($modules) > 0) {
                    foreach ($modules as $module) {
                        if (empty($module->module_id)) {
                            $modules->forget($module->id);
                        }
                    }
                }
            }
        }

        return $this->success([
            'page' => $page,
            'breadcrumbs' => $breadcrumbs,
            'settings' => $settings,
            'contacts' => $contacts,
            'modules' => Module::getModules()
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/create Создание страницы
     * @apiGroup Pages
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {boolean} is_active активная неактивная страница (0 - неактивная, 1 - активная. Не обязательно.)
     * @apiParam {boolean} is_edit_mode состояние редактирования (0 - нет, 1 - да. Не обязательно.)
     * @apiParam {string} title Имя страницы
     * @apiParam {string} slug урл страницы (не обязательно)
     * @apiParam {string} seo_title название
     * @apiParam {string} seo_description описание страницы
     * @apiParam {string} seo_keywords ключевые слова
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $except = ['page_stroke_id', 'id'];
        $validator = self::validatePage($data, $except);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $page = Page::create(self::getData($data));

        return $this->success($page);
    }

    /**
     * @param $slug
     * @param $id
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/{slug}-{id}.html Просмотр страницы
     * @apiGroup Pages
     */
    public function show($slug, $id)
    {
        $page = Page::whereSlug($slug)->whereId($id)->first();

        if (!$page) {
            return $this->error('Страница не найдена');
        }

        $this->getMeta(__METHOD__, $page);

        return $this->success($page);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/update Обновление страницы
     * @apiGroup Pages
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} title Имя страницы
     * @apiParam {boolean} is_active активная неактивная страница (0 - неактивная, 1 - активная. Не обязательно.)
     * @apiParam {boolean} is_edit_mode состояние редактирования (0 - нет, 1 - да. Не обязательно.)
     * @apiParam {boolean} is_home главная страница (0 - нет, 1 - да. Не обязательно.)
     * @apiParam {string} id ID страницы
     * @apiParam {string} slug урл страницы (не обязательно)
     * @apiParam {string} seo_title название
     * @apiParam {string} seo_description описание страницы
     * @apiParam {string} seo_keywords ключевые слова
     */
    public function update(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $except = ['page_stroke_id'];
        $result = self::validatePage($data, $except);

        if (!is_array($result)) {
            return $result;
        }

        $result['page']->update(self::getData($data));

        return $this->success($result['page']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/active Состояние активности страницы
     * @apiGroup Pages
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {boolean} is_active активная неактивная страница (0 - неактивная, 1 - активная)
     * @apiParam {string} id ID страницы
     */
    public function active(Request $request)
    {
        $data = $request->all();

        $errors = ['is_active' => 'required'];
        $messages = ['is_active.required' => 'Не задан параметр активности'];

        $result = self::validatePage($data, ['name'], $errors, $messages);

        if (!is_array($result)) {
            return $result;
        }

        $result['page']->update(['is_active' => (int)$data['is_active']]);

        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/edit_mode Состояние редактирования страницы
     * @apiGroup Pages
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {boolean} is_edit_mode состояние редактирования (0 - нет, 1 - да. Не обязательно.)
     * @apiParam {string} id ID страницы
     */
    public function editMode(Request $request)
    {
        $data = $request->all();

        $errors = ['is_edit_mode' => 'required'];
        $messages = ['is_edit_mode.required' => 'Не задан параметр редактирования'];

        $result = self::validatePage($data, ['name'], $errors, $messages);

        if (!is_array($result)) {
            return $result;
        }

        $result['page']->update(['is_edit_mode' => (int)$data['is_edit_mode']]);

        return $this->success();
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/pages/form форма страницы
     * @apiGroup Pages
     *
     * @apiParam {string} token Токен ключ пользователя
     */
    public function form(): JsonResponse
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        if (Auth::user() && !Auth::user()->can('site_edit', $site)) {
            return $this->error('У вас нет прав редактирования этой страницы');
        }

        $modules = Module::getModules();

        $options = [
            'modules' => $modules
        ];

        $page = Page::query()->home()->bySite($site->id)->with(['header', 'footer', 'content'])->first();

        if (!$page) {
            $page = Page::createDefault();
        }

        return $this->success([
            'options' => $options,
            'page' => $page
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @apiParam {integer} id ID страницы
     * @apiParam {integer} page_stroke_id ID строки
     */
    public function undo(Request $request)
    {
        $data = $request->all();

        $validator = self::validatePage($data, ['name']);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $page = Page::query()->find($data['id']);

        if (!$page) {
            return $this->error('Страница не найдена');
        }

        if ($page->is_edit_mode != 1) {
            return $this->error('Страница не находится в состоянии редактирования');
        }

        $stroke = $page->revisionStrokes()->find($data['page_stroke_id']);

        if (!$stroke) {
            return $this->error('Строка не найдена');
        }

        if (count($stroke->modules) == 0) {
            return $this->error('Блоки не найдены');
        }

        foreach ($stroke->modules as $i => $module) {
            if ($module->is_current == 1) {
                if (isset($stroke->modules[$i - 1])) {
                    $prev = $stroke->modules[$i - 1];
                    $prev->update(['is_current' => 1]);
                }
                break;
            }
        }

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     */
    public function redo(Request $request)
    {
        return $this->success($request);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/delete Удаление страницы
     * @apiGroup Pages
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} id ID страницы
     */
    public function delete(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $errors = ['id' => 'required'];
        $messages = ['id.required' => 'Не задан ID'];

        $result = self::validatePage($data, ['name'], $errors, $messages);

        if (!is_array($result)) {
            return $result;
        }

        try {
            $result['page']->delete();
        } catch (Exception $e) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }
        }

        return $this->success();
    }
}