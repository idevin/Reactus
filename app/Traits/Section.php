<?php

namespace App\Traits;

use App\Http\Controllers\Api\Catalog\ObjectsController;
use App\Models\Article;
use App\Models\BlogArticle;
use App\Models\BlogSection;
use App\Models\BlogSectionUser;
use App\Models\BlogSite;
use App\Models\Modules\ModuleSection;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSlider;
use App\Models\NeoCatalog;
use App\Models\NeoCatalogFieldGroup;
use App\Models\NeoUserCatalog;
use App\Models\Section as SectionModel;
use App\Models\SectionUser;
use App\Models\Site;
use App\Models\User;
use App\Traits\Article as ArticleTrait;
use App\Traits\NeoObject as NeoObjectTrait;
use Cache;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;
use stdClass;
use Validator;

trait Section
{
    use NeoObjectTrait;

    /**
     * @param Site $site
     * @param string $modelClass
     * @param bool $withRoot
     * @return array
     */
    public static function treeOptions(Site $site, string $modelClass, bool $withRoot = true): array
    {
        $options = [];
        $repeat = function ($item) {
            return (int)$item['depth'] > 1 ?
                str_repeat('&#8735;', round($item['depth'] / ($item['depth'] + 0.9))) : null;
        };
        $nodes = self::getNodes($site, $withRoot, $modelClass);

        if ($nodes) {
            foreach ($nodes->toArray() as $item) {
                $options[$item['id']] = sprintf('%s %s',
                    str_repeat('&nbsp;', abs($item['depth'] * 3 - 1)) . $repeat($item), $item['title']);
            }
        }

        return $options;
    }

    private static function getNodes($site, $withRoot, $modelClass)
    {
        $sectionRoots = $modelClass::roots();
        $nodes = [];

        if ($sectionRoots) {
            $node = $sectionRoots->bySite($site->id)->get()->first();
            $nodes = null;

            $nodes = function ($node, $withRoot) {
                return $withRoot ? $node->getDescendantsAndSelf() : $node->getDescendants();
            };

            if (!$node) {
                $node = $modelClass::create(['site_id' => $site->id, 'title' => 'Разделы',
                    'path' => '/', 'slug' => 'root']);
            }

            $nodes = $nodes($node, $withRoot);
        }

        return $nodes;
    }

    public static function optionsBuilder($class, $notId = null, $empty = false,
                                          $notSiteId = null, $withRoot = true): array
    {
        $data = $class::with(['site' => function ($query) {
            return $query->thematic();
        }]);

        if ($notId) {
            $data = $data->whereNotIn('id', [$notId]);
        }

        if ($notSiteId) {
            $data = $data->whereNotIn('site_id', [$notSiteId]);
        }

        $data = $data->get();

        if ($empty == true) {
            $allData = [null => 'Выберите раздел...'];
        } else {
            $allData = [];
        }

        foreach ($data as $object) {
            $string = str_repeat('&nbsp;&nbsp;', $object->depth + 1) . '&nbsp;  ∟ &nbsp;' . $object->title;
            if ($object->site && $object->site->domain) {
                $allData[$object->site->domain][$object->id] = $string;
            }
        }

        return $allData;
    }

    public static function createModuleSectionValidator($data, $except = [], $errors = [])
    {
        $default = [
            'view' => 'required|in:' . implode(',', ModuleSection::mapConstants(ModuleSection::$view)),
            'sort_by' => 'required|in:' . implode(',', ModuleSection::mapConstants(ModuleSection::$sortBy)),
            'module_settings_id' => 'required',
            'sort_order' => 'required|in:' . implode(',', ModuleSection::mapConstants(ModuleSection::$sortOrder)),
            'position' => 'required|in:' . implode(',', array_keys(ModuleSettings::$positionOptions)),
            'name' => 'required',
            'block_cell_id' => 'required',
            'block_type_id' => 'required'
        ];

        $messages = [
            'view.required' => 'Не задан вид блока',
            'sort_by.required' => 'Не задана сортировка',
            'sort_by.in' => 'Неверная сортировка',
            'sort_order.required' => 'Не задан порядок сортировки',
            'sort_order.in' => 'Неверный порядок сортировки',
            'module_settings_id.required' => 'Не задан ID настроек',
            'block_type.required' => 'Не выбран тип вывода статей',
            'block_type.in' => 'Неверный ID типа статей',
            'name.required' => 'Заполните название блока статей',
            'block_cell_id' => 'Не задан ID ячейки блока',
            'block_type_id' => 'Не задан тип блока для ячейки'
        ];

        $default = array_merge($default, $errors);

        $rules = collect($default)->except($except)->toArray();

        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param $site
     * @param bool $withRoot
     * @param array $except
     * @return array
     */
    public static function getOptionValues($site, bool $withRoot = true, array $except = []): array
    {
        $options = [];

        $repeat = function ($item) {
            return (int)$item->depth > 1 ?
                str_repeat('&#8735;', round($item->depth / ($item->depth + 0.9))) : null;
        };

        $nodes = self::getNodes($site, $withRoot, self::class);

        if ($nodes) {
            foreach ($nodes as $item) {
                $item->title = sprintf('%s %s',
                    str_repeat('&nbsp;', abs($item->depth * 3 - 1)) . $repeat($item), //'&#8212; 8211'
                    $item->title
                );

                $options[$item->id] = $item->title;
            }
        }
        if (!empty($except)) {
            foreach ($except as $id) {
                if (isset($id)) {
                    unset($options[$id]);
                }
            }
        }

        return $options;
    }

    #[Pure]
    public static function calculateRating($object): string
    {
        $total = 0;
        $totalRatingArticles = 0;

        if ($object->articles_cnt > 0) {
            foreach ($object->articles as $article) {
                if ($article->rating > 0) {
                    $total += $article->rating;
                    $totalRatingArticles++;
                }
            }

            if ($totalRatingArticles > 0) {
                $total = $total / $totalRatingArticles;
            }
        }

        return rating_format($total);
    }

    public function scopeDepth($query, $level)
    {
        return $query->where('depth', $level);
    }

    public function scopeSort($query, $sort, $dir)
    {
        $sort = strtolower($sort);
        if (!in_array($sort, array_keys(self::$sortable))) {
            return $query;
        }

        $dir = strtolower($dir);
        if (!in_array($dir, $this->directions)) {
            return $query;
        }

        $query->orderBy(self::$sortable[$sort], $dir);

        return $query;
    }

    /**
     * @param $request
     * @param string $sectionModel
     * @param string $sectionSettingModel
     * @param string $articleModel
     * @param User|null $user
     * @param string $siteModel
     * @return JsonResponse
     */
    public function getSectionsIndex($request, string $sectionModel, string $sectionSettingModel, string $articleModel,
                                     User $user = null, string $siteModel = Site::class): JsonResponse
    {
        $sectionId = $request->get('section_id', null);

        $site = $this->getSiteByModel($siteModel);

        $error = $request->get('error');

        if (!$sectionId) {
            $section = $sectionModel::roots()->bySite($site->id);

            if ($user) {
                $section = $section->whereUserId($user->id);
            }

            $section = $section->first();

            if (!$section) {

                $section = $sectionModel::firstOrCreate([
                    'title' => 'Содержание сайта',
                    'parent_id' => null,
                    'site_id' => $site->id
                ]);
            }

        } else {
            $section = $sectionModel::bySite($site->id);
            if ($user) {
                $section = $section->whereUserId($user->id);
            }
            $section = $section->find($sectionId);
        }

        if (!$section) {
            return $this->error('Раздел не найден...');
        }

        if (Auth::user() && !Auth::user()->can('section_view', $section)) {
            $message = 'У вас нет прав для просмотра разделов';

            if (env('APP_DEBUG_VARS') == true) {
                debugvars($message);
            }

            return $this->error($message);
        }

        $section = $section->makeHidden(['sectionStorageImages']);

        $sectionId = $section->id;

        $sectionSetting = $sectionSettingModel::where('section_id', $sectionId)->first();

        if ($sectionSetting) {
            $sortOptions = $sectionSetting;
        } else {
            $sortOptions = $site;
        }

        $defaults = [
            'field' => $sortOptions->filter_sections_sort,
            'order' => $sortOptions->filter_sections_sort_direction,
            'page' => 1,
            'term' => '',
            'view' => $sortOptions->filter_sections_view
        ];

        $field = $request->get('field', $defaults['field']);
        $order = $request->get('order', $defaults['order']);
        $term = $request->get('term', $defaults['term']);
        $view = $request->get('view', $defaults['view']);

        $limit = $sortOptions->sections_limit;

        $sections = $this->getSectionsQuery($section, $sectionModel,
            $field, $order, $limit, $view, $term);

        $rootSection = $this->getRootSection($sectionModel, $site);

        $breadcrumbs = [
            ['Главная' => route('home', [], false)],
            [$rootSection->title => route('section.index', [], false)]
        ];

        $defaultsArticles = [
            'field' => $sortOptions->filter_articles_sort,
            'order' => $sortOptions->filter_articles_sort_direction,
            'page' => 1,
            'term' => '',
            'view' => $sortOptions->filter_articles_view
        ];

        $articles = ArticleTrait::getArticles($articleModel, $defaultsArticles, $sortOptions, $site, true,
            false, null, $section);

        $articles = $articles->toArray();

        $trashedArticles = $section->articles()->withTrashed()->whereNotNull('deleted_at')->first();

        if (!empty($articles['data'])) {
            $articles['data'] = array_map(function ($item) {

                return array_intersect_key($item, array_flip([
                    'id', 'thumbs', 'rating', 'author', 'deleted_at', 'content_short', 'created_at',
                    'tags', 'last_comment', 'comments_cnt', 'count', 'url', 'title', 'site', 'views_cnt',
                    'draft', 'created_at_formated', 'updated_at_formated', 'show_article_rating'
                ]));

            }, $articles['data']);
        }

        $articles['data'] = array_values(array_filter($articles['data']));
        $data['articles'] = $articles;

        $sections = $sections->toArray();

        $trashedSections = $section->children()->withTrashed()->whereNotNull('deleted_at')->first();

        $data['trash_bin'] = null;

        if (!empty($trashedArticles) || !empty($trashedSections)) {
            $data['trash_bin'] = route('section.show_trash',
                ['id' => $section->id, 'section' => $section->slug], false);
        }

        if (!$error) {
            $data['section'] = $section;
            $data['breadcrumbs'] = $breadcrumbs;
            $data['articlesFilter'] = $defaultsArticles;
            $data['articlesSortOptions'] = $articleModel::$sortOptions;
            $data['sortOptions'] = $sortOptions;

        } else {
            unset($data['articles']);
        }

        $data['section']['settings'] = $sectionSetting;

        $data['sections'] = $sections;
        $data['sectionsFilter'] = $defaults;
        $data['sectionsSortOptions'] = $sectionModel::$sortOptions;

        $section->increment('views_cnt');

        if ($error) {
            return response()->json($data, 400);
        } else {
            return $this->success($data);
        }
    }

    /**
     * @param $section
     * @param $sectionModel
     * @param $term
     * @param $field
     * @param $order
     * @param $limit
     * @param $view
     * @return LengthAwarePaginator
     */
    public function getSectionsQuery($section, $sectionModel, $field,
                                     $order, $limit, $view, $term): LengthAwarePaginator
    {

        $qb = $section->descendantsWithSort($field, $order)->with(['site', 'setting'])
            ->depth($section->depth + 1);

        if (isset($sectionModel::$sortable[$field])) {
            /**
             * @var SectionModel|BlogSection $sectionModel
             */
            $qb->orderBy($sectionModel::$sortable[$field], $order);
        }

        if (\Auth::guest() || (Auth::user() && !Auth::user()->can('section_hide', $section))) {
            $qb = $qb->published();
        }

        if ($term) {
            $qb->where('title', 'like', '%' . $term . '%');
        }

        $qb->announced($section->id, $sectionModel, $sectionModel, $term);

        $sections = $qb->paginate($limit, ['*'], 'page');
        $sections = Utils::transformUrl($sections);

        if (count($sections->items()) > 0) {
            array_map(function ($item) {

                return $item->setting?->makeHidden([
                    'id', 'articles_limit', 'updated_at', 'sections_limit', 'section_id',
                    'filter_sections_view', 'filter_sections_sort_direction', 'filter_sections_sort',
                    'filter_sections', 'filter_articles_view', 'filter_articles_sort_direction',
                    'filter_articles_sort', 'filter_articles', 'created_at', 'articles_limit'
                ]);

            }, $sections->items());
        }

        $sections->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'section_id' => $section->id,
            'view' => $view,
            'limit' => $limit
        ]);

        return $sections;
    }

    /**
     * @param $request
     * @param string $sectionModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function sortSections($request, string $sectionModel, $siteModel = Site::class)
    {
        $sectionId = $request->get('section_id', null);

        $site = $this->getSiteByModel($siteModel);

        if (Auth::user() && !Auth::user()->can('section_list_section_sort', $sectionModel)) {
            return $this->error('Вы не можете сортировать разделы');
        }

        if (!$sectionId) {
            $section = $this->getRootSection($sectionModel, $site);
        } else {
            $section = $sectionModel::bySite($site->id)->find($sectionId);
        }

        if (!$section) {
            return $this->error('Раздел не найден...');
        }

        $sectionSetting = $section->sectionSetting;

        if ($sectionSetting) {
            $sortOptions = $sectionSetting;
        } else {
            $sortOptions = $site;
        }

        $sectionsFilter = [
            'field' => $sortOptions->filter_sections_sort,
            'order' => $sortOptions->filter_sections_sort_direction,
            'page' => 1,
            'term' => null,
            'view' => $sortOptions->filter_sections_view
        ];

        $field = $request->get('field', $sectionsFilter['field']);
        $order = $request->get('order', $sectionsFilter['order']);
        $term = $request->get('term', $sectionsFilter['term']);
        $view = $request->get('view', $sectionsFilter['view']);
        $limit = $sortOptions->sections_limit;

        $sections = $this->getSectionsQuery($section, $sectionModel,
            $field, $order, $limit, $view, $term);

        $data['sections'] = $sections;

        $section->increment('views_cnt');

        return $this->success($data);
    }

    /**
     * @param $request
     * @param string $sectionModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function getSectionSlug($request, $sectionModel, $siteModel = Site::class)
    {
        $term = $request->get('term', null);
        $sectionId = $request->get('section_id', null);

        if (!$term) {
            return $this->success('Не задан параметр term');
        }

        $site = $this->getSiteByModel($siteModel);

        if ($sectionId) {
            $section = $sectionModel::bySite($site->id)->find($sectionId);
            if (!$section) {
                return $this->error('Раздел не найден');
            }

            $id = $section->id;
        } else {
            $lastSection = $sectionModel::select('id')->orderBy('id', 'DESC')->first();
            $id = $lastSection->id + 1;
        }

        $string = slugify($term) . '-' . $id;
        $data['url'] = $string;

        return $this->success($data);
    }

    /**
     * @param $request
     * @param string $sectionModel
     * @param string $sectionUserModel
     * @param string $sectionSettingModel
     * @param string $sectionImageModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function createSection($request, string $sectionModel, string $sectionUserModel,
                                  string $sectionSettingModel, string $sectionImageModel, $siteModel = Site::class)
    {
        $requestData = $request->all();

        $site = $this->getSiteByModel($siteModel);
        $sectionRoot = $this->getRootSection($sectionModel, $site);
        $validator = self::createSectionValidator($requestData);

        $this->setObject($sectionModel);

        if (!\Auth::user()->can('section_create', new $sectionModel())) {
            return $this->error('У вас нет прав для создания раздела...', $this);
        }

        if ($validator->fails()) {
            return $this->error($validator->errors(), $this);
        }

        if (!$site) {
            return $this->error('Домен не найден...', $this);
        }

        if (!empty($requestData['parent_id'])) {
            $parent = $sectionModel::find($requestData['parent_id']);
            if (!$parent) {
                return $this->error('Родительский раздел не найден', $this);
            }
        } else {
            $parent = $sectionRoot;
        }

        $data = $this->getRequestData($requestData, $site, $sectionModel,
            \Auth::user(), new $sectionModel());

        $section = $sectionModel::create($data);

        if ($data['tags']) {
            $section->tag($data['tags']);
        }

        if (!empty($requestData['images'])) {
            $this->processSectionSlides($requestData, $section, $sectionImageModel);
        } else {
            $this->deleteSectionStorageImages($section, $sectionImageModel);
        }

        if (isset($parent)) {
            $section->makeChildOf($parent);
        }

        if (\Auth::user() && \Auth::user()->can('content_tag_manage', $section)) {
            if (!empty($requestData['tags'])) {
                $section->tag(explode(',', $requestData['tags']));
            }
        } else {
            $section->untag();
        }

        $this->updateSectionSettings($section, \Auth::user(), $requestData, $site,
            $sectionSettingModel, $sectionUserModel);

        $section = $section->makeHidden(['parent', 'site']);

        $this->setObjectId($section ? $section->id : null);
        $this->setIsSystem(false);
        $this->setParams(['data' => ['user' => \Auth::user(), 'section' => $section->toArray()]]);
        $this->createActivity();

        return $this->success([
            'origin' => $section->origin
        ]);
    }

    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public static function createSectionValidator($data, array $except = [], array $customErrors = [])
    {
        $minTitleSymbols = 3;

        $default = [
            'title' => 'required|max:70|min:' . $minTitleSymbols,
            'parent_id' => 'required',
            'short_content' => 'max:160'
        ];

        if (!empty($data['title'])) {
            $data['title'] = Utils::cleanChars($data['title']);
        }

        if (!empty($data['filter_articles_sort'])) {
            $default['filter_articles_sort'] = 'required|in:' . implode(',', array_keys(Article::$sortable));
        }

        if (!empty($data['filter_articles_sort_direction'])) {
            $default['filter_articles_sort_direction'] = 'required|in:' . implode(',', Article::$directions);
        }

        if (!empty($data['filter_articles_view'])) {
            $default['filter_articles_view'] = 'required|in:' . implode(',', array_keys(Article::$viewOptions));
        }

        if (!empty($data['filter_sections_sort'])) {
            $default['filter_sections_sort'] = 'required|in:' . implode(',', array_keys(SectionModel::$sortable));
        }

        if (!empty($data['filter_sections_sort_direction'])) {
            $default['filter_sections_sort_direction'] = 'required|in:' . implode(',', SectionModel::$directions);
        }

        if (!empty($data['filter_sections_view'])) {
            $default['filter_sections_view'] = 'required|in:' . implode(',', array_keys(SectionModel::$viewOptions));
        }

        $messages = [
            'filter_sections_view.in' => 'Неверное значение вида страницы раздела',
            'filter_sections_sort_direction.in' => 'Неверное значение направления фильтра разделов',
            'filter_sections_sort.in' => 'Неверное значения для фильтра разделов',
            'filter_articles_view.in' => 'Неверное значение вида страницы статьи',
            'filter_articles_sort_direction.in' => 'Неверное значение направления фильтра статей',
            'filter_articles_sort.in' => 'Неверное значения для фильтра статей',
            'parent_id.required' => 'Выберите раздел',
            'title.required' => 'Напишите название',
            'title.unique' => 'Такое название раздела уже есть...',
            'title.max' => 'Название раздела не должно быть больше 200 символов',
            'title.min' => 'Название раздела должно быть не менее ' . $minTitleSymbols . ' символов',
            'other_section_id.required' => 'Если хотите перенести раздел на другой ресурс, выберите раздел у 
            ресурса',
            'short_content.max' => 'Краткое описание раздела должно быть не больше 160 символов'
        ];

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param $requestData
     * @param $site
     * @param $sectionModel
     * @param null $user
     * @param SectionModel|BlogSection $section
     * @return JsonResponse|array
     */
    private function getRequestData($requestData, $site, $sectionModel, $user, $section)
    {
        $parentId = null;

        if (!empty($requestData['parent_id']) && $section->parent_id != null) {
            $parent = $sectionModel::find($requestData['parent_id']);
            if (!$parent) {
                return $this->error('Указанный раздел не найден');
            }
            $parentId = $parent->id;
        }

        $isSecret = 0;
        if ($user && $user->can('section_hide', $section)) {
            if (isset($requestData['is_secret'])) {
                $isSecret = (int)$requestData['is_secret'];
            }
        }

        if (isset($requestData['content_short'])) {
            $contentShort = truncate_content($requestData['content_short'], 160, true, true, false);
        } else {
            $contentShort = truncate_content($requestData['content'], 160, true, true, false);
        }

        $seoTitle = isset($requestData['seo_title']) ? $requestData['seo_title'] : null;

        $seoDescription = isset($requestData['seo_description']) ?
            $requestData['seo_description'] : null;

        $seoBreadcrumbs = isset($requestData['seo_breadcrumbs']) ?
            $requestData['seo_breadcrumbs'] : null;

        $catalogFilterSettings = isset($requestData['filter_settings']) ?
            $requestData['filter_settings'] : null;

        $catalogSortOptions = isset($requestData['sort_options']) ?
            $requestData['sort_options'] : null;

        $objectId = isset($requestData['object_id']) ?
            (int)$requestData['object_id'] : null;

        $catalogTitle = isset($requestData['catalog_title']) ?
            $requestData['catalog_title'] : null;

        $catalogSortBy = isset($requestData['catalog_sort_by']) ?
            $requestData['catalog_sort_by'] : null;

        $catalogSortOrder = isset($requestData['catalog_sort_order']) ?
            $requestData['catalog_sort_order'] : null;

        $content = !empty($requestData['content']) ? $requestData['content'] : null;

        $reactData = !empty($requestData['react_data']) ? $requestData['react_data'] : null;

        $tags = !empty($requestData['tags']) ? $requestData['tags'] : null;

        return [
            'title' => Utils::cleanChars($requestData['title']),
            'content' => $content,
            'content_short' => $contentShort,
            'image' => null,
            'site_id' => $site->id,
            'parent_id' => $parentId,
            'is_secret' => $isSecret,
            'user_id' => Auth::user()->id,
            'react_data' => $reactData,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'seo_breadcrumbs' => $seoBreadcrumbs,
            'filter_settings' => $catalogFilterSettings,
            'sort_options' => $catalogSortOptions,
            'object_id' => $objectId,
            'catalog_title' => $catalogTitle,
            'catalog_sort_by' => $catalogSortBy,
            'catalog_sort_order' => $catalogSortOrder,
            'tags' => $tags
        ];
    }

    public function updateSectionSettings($section, $user, $requestData, $site,
                                          $sectionSettingModel, $sectionUserModel)
    {
        $sectionUserModel::firstOrCreate([
            'section_id' => $section->id,
            'user_id' => $user->id
        ]);

        if (isset($requestData['show_opened'])) {
            $requestData['show_opened'] = (int)$requestData['show_opened'];
        } else {
            $requestData['show_opened'] = 0;
        }

        if (isset($requestData['filter_articles'])) {
            $requestData['filter_articles'] = (int)$requestData['filter_articles'];
        } else {
            $requestData['filter_articles'] = 0;
        }

        if (isset($requestData['filter_sections'])) {
            $requestData['filter_sections'] = (int)$requestData['filter_sections'];
        } else {
            $requestData['filter_sections'] = 0;
        }

        if (isset($requestData['sections_limit'])) {
            $requestData['sections_limit'] = (int)$requestData['sections_limit'];
        } else {
            $requestData['sections_limit'] = $site->sections_limit;
        }

        if (isset($requestData['sections_name'])) {
            $requestData['sections_name'] = strip_tags($requestData['sections_name']);
        } else {
            $requestData['sections_name'] = __('section.name');
        }

        if (isset($requestData['hide_article_author_inside'])) {
            $requestData['hide_article_author_inside'] = (int)$requestData['hide_article_author_inside'];
        } else {
            $requestData['hide_article_author_inside'] = 0;
        }

        $showRating = 0;
        if ($user && $user->can('section_rating_hide', $section)) {
            if (isset($requestData['show_rating'])) {
                $showRating = (int)$requestData['show_rating'];
            }
        }
        $requestData['show_rating'] = $showRating;

        $showArticleAuthor = 0;
        if ($user && $user->can('section_list_article_author_hide', $section)) {
            if (isset($requestData['show_article_author'])) {
                $showArticleAuthor = (int)$requestData['show_article_author'];
            }
        }
        $requestData['show_article_author'] = $showArticleAuthor;

        $hideSectionTags = 0;
        if ($user && $user->can('section_tag_hide', $section)) {
            if (isset($requestData['hide_section_tags'])) {
                $hideSectionTags = (int)$requestData['hide_section_tags'];
            }
        }
        $requestData['hide_section_tags'] = $hideSectionTags;

        $requestData['section_id'] = $section->id;

        $sectionSetting = $sectionSettingModel::query()->where(['section_id' => $section->id])->first();

        if (!$sectionSetting) {
            $sectionSettingModel::create($requestData);
        } else {
            $sectionSetting->update($requestData);
        }

        if ($section->is_secret == 1) {
            $emailData = [
                'section' => $section,
                'site' => $site
            ];
            $this->notifyUsers($section, $sectionUserModel, 'section-hidden', $emailData);
        }
    }

    /**
     * @param SectionModel $section
     * @param SectionUser|BlogSectionUser $sectionUserModel
     * @param $template
     * @param $emailData
     * @return void
     */
    protected function notifyUsers(SectionModel $section, $sectionUserModel, $template, $emailData)
    {
        $sectionUsers = $sectionUserModel::query()->whereSectionId($section->id)->get();

        $allUsers = [];
        foreach ([$sectionUsers] as $userData) {
            foreach ($userData as $oUser) {
                $allUsers[$oUser->id] = $oUser->user;
            }
        }

        foreach ($allUsers as $user) {
            if (!empty($user->email)) {
                sendEmail($user->email, 'Раздел скрыт с сайта.', $emailData, $template);
            }
        }
    }

    /**
     * @param $request
     * @param string $sectionModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function deleteSection($request, string $sectionModel, $siteModel = Site::class)
    {
        $id = $request->input('id', null);

        if (!$id) {
            return $this->error('Не задан атрибут ID', $this);
        }

        $site = $this->getSiteByModel($siteModel);

        $section = $sectionModel::bySite($site->id)->find($id);

        if (!$section) {
            return $this->error('Раздел не найден...');
        }

        if (!Auth::user()->can('section_delete', $section)) {
            return $this->error('У вас нет прав для удаления раздела...', $this);
        }

        if (count($section->articles) > 0) {
            return $this->error('Нельзя удалить раздел, так как у него есть статьи', $this);
        }

        if (empty($section->parent_id)) {
            return $this->error('Нельзя удалить главный раздел', $this);
        }

        ModuleSlide::flushCache();
        ModuleSlider::flushCache();

        $this->setObject($sectionModel);
        $this->setObjectId($section ? $section->id : null);
        $this->setFromObject(get_class(\Auth::user()));
        $this->setFromObjectId(\Auth::user()->id);
        $this->setIsSystem(false);
        $this->setParams(['data' => ['user' => \Auth::user(), 'section' => $section->toArray()]]);
        $this->setActivityUser(\Auth::user());
        $this->setActivityFromUser(\Auth::user());
        $this->createActivity();

        $section->delete();

        return $this->success('Раздел удален!');
    }

    /**
     * @param $request
     * @param $sectionModel
     * @param $sectionSettingModel
     * @param $articleModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function getSectionform($request, $sectionModel,
                                   $sectionSettingModel, $articleModel, string $siteModel = Site::class)
    {
        $articlesSortOptions = $articleModel::$sortOptions;
        $sectionsSortOptions = $sectionModel::$sortOptions;
        $articlesViewOptions = $articleModel::$viewOptions;
        $sectionsViewOptions = $sectionModel::$viewOptions;

        $site = $this->getSiteByModel($siteModel);

        $sectionId = $request->get('section_id', null);

        $excludedSection = [];

        $articlesName = __('article.name');
        $sectionsName = __('section.name');
        $seoTitle = null;
        $seoDescription = null;
        $seoBreadcrumbs = null;

        $sectionModel::$useShortContentDots = false;

        if ($sectionId) {
            $section = $sectionModel::find($sectionId)->makeHidden(['last_article', 'tagged', 'children', 'site']);

            if ($section) {
                $excludedSection = [$sectionId];
            } else {
                return $this->error('Раздел не найден', null, 404);
            }

            $data['section'] = $section->toArray();
            $data['section']['settings'] = $sectionSettingModel::where('section_id', $section->id)
                ->first();

            if (!empty($data['section']['settings']) &&
                !empty($data['section']['settings']->articles_name)) {
                $articlesName = $data['section']['settings']->articles_name;
            }

            if (!empty($data['section']['settings']) &&
                !empty($data['section']['settings']->sections_name)) {
                $sectionsName = $data['section']['settings']->sections_name;
            }

            if (!empty($data['section']['settings']) &&
                !empty($data['section']['settings']->seo_title)) {
                $seoTitle = $data['section']['settings']->seo_title;
            }

            if (!empty($data['section']['settings']) &&
                !empty($data['section']['settings']->seo_description)) {
                $seoDescription = $data['section']['settings']->seo_description;
            }

            if (!empty($data['section']['settings']) &&
                !empty($data['section']['settings']->seo_breadcrumbs)) {
                $seoBreadcrumbs = $data['section']['settings']->seo_breadcrumbs;
            }

            $hideArticleAuthorInside = !empty($data['section']['settings']) ?
                $data['section']['settings']->hide_article_author_inside :
                $site->hide_article_author_inside;

            $data['section']['filter'] = [];

            if (!empty($section->object_id)) {

                $filter = [];
                $object = NeoCatalog::whereId($section->object_id)->first();

                if ($object) {
                    foreach ($object->fieldGroups as $fieldGroup) {
                        $oFieldGroup = NeoCatalogFieldGroup::with(['fields' => function ($query) {
                            $query->orderBy('ID(fields)', 'asc');
                        }])->whereId($fieldGroup->id)->first();

                        if ($oFieldGroup && count($oFieldGroup->fields) > 0) {
                            $oFieldGroup->fields->makeHidden(['object_field_group_id']);
                            $filter = array_merge($filter, $oFieldGroup->fields->toArray());
                        }
                    }

                    $data['section']['filter'] = $filter;
                }
            }

        } else {
            $hideArticleAuthorInside = $site->hide_article_author_inside;
        }

        $sectionOptions = $sectionModel::getOptionValues($site, true, $excludedSection);

        $filterDirections = function ($element, $index) {
            $o = new stdClass();
            $o->$element = $index;

            return $o;
        };

        $catalogOptions = $this->getCatalogForSection(Auth::user());

        $data['options'] = [
            'article' => [
                'sorts' => $articlesSortOptions,
                'sort_directions' => collect($articleModel::$directions)->map($filterDirections),
                'views' => $articlesViewOptions,
                'limits' => $articleModel::$limits,
                'articles_name' => $articlesName,
                'show_background' => 1
            ],
            'section' => [
                'sorts' => $sectionsSortOptions,
                'sort_directions' => collect($sectionModel::$directions)->map($filterDirections),
                'views' => $sectionsViewOptions,
                'limits' => $sectionModel::$limits,
                'select' => $sectionOptions,
                'all_sections_select' => $this->getAllSections($sectionModel, $site),
                'show_article_author' => $site->show_article_author,
                'show_section_rating' => $site->show_section_rating,
                'hide_article_author_inside' => $hideArticleAuthorInside,
                'hide_section_tags' => $site->hide_section_tags,
                'sections_name' => $sectionsName,
                'seo_title' => $seoTitle,
                'seo_description' => $seoDescription,
                'seo_breadcrumbs' => $seoBreadcrumbs
            ],
            'catalog' => $catalogOptions
        ];

        return $this->success($data);
    }

    /**
     * @param string $sectionModel
     * @param null $originSite
     * @return array|JsonResponse
     */
    protected function getAllSections(string $sectionModel, $originSite = null): array|JsonResponse
    {
        $otherSections = [];
        $sites = Site::thematic()->get();

        foreach ($sites as $index => $site) {
            if (!$originSite || $site->id != $originSite->id) {
                $otherSections[$site->id . '|site'] = idnToAscii($site->domain);
                $domainSections = $sectionModel::getOptionValues($site, true);

                $otherSections = $otherSections + $domainSections;
            }
        }

        $otherSections += [null => 'Выберите ресурс...'];

        return $otherSections;
    }

    /**
     * @param $request
     * @param string $sectionModel
     * @param string $sectionUserModel
     * @param string $sectionSettingModel
     * @param string $sectionImageModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function updateSection($request, string $sectionModel, string $sectionUserModel,
                                  string $sectionSettingModel, string $sectionImageModel,
                                  string $siteModel = Site::class): JsonResponse
    {
        $requestData = $request->all();

        $site = $this->getSiteByModel($siteModel);

        if (!isset($requestData['id'])) {
            return $this->error('ID не указан', $this);
        }

        $id = (int)$requestData['id'];

        $section = $sectionModel::find($id);

        if (!$section) {
            return $this->error('Раздел не найден...', null, 404, $this);
        }

        if (!Auth::user()->can('section_edit', $section)) {
            return $this->error('У вас нет прав для редактирования раздела...', $this);
        }

        $customErrors = [];
        $excludedErrors = [];

        if (!empty($requestData['other_section_id']) && \Auth::user()
            && \Auth::user()->can('section_transfer', $section)) {

            if (strstr($requestData['other_section_id'], '|')) {
                $requestData['other_section_id'] = null;
                $customErrors['other_section_id'] = 'required';
            } else {
                $otherSection = $sectionModel::find($requestData['other_section_id']);
                $section->transfer_to_section = $otherSection->id;
            }
        }

        if ($section->parent_id == null) {
            $excludedErrors[] = 'parent_id';
        }

        $validator = self::createSectionValidator($requestData, $excludedErrors, $customErrors);

        if ($validator->fails()) {
            return $this->error($validator->errors(), $this);
        }

        if (!$site) {
            return $this->error('Домен не найден...', $this);
        }

        $parentId = null;
        $parent = null;
        $sectionRoot = $this->getRootSection($sectionModel, $site);

        if (!empty($requestData['parent_id'])) {
            $parent = $sectionModel::find($requestData['parent_id']);

            if (!$parent) {
                return $this->error('Родительский раздел не найден', $this);
            }

            if ($parent->isChildOf($section)) {
                return $this->error('Неверный родительский раздел');
            }
            if ($requestData['parent_id'] == $section->id) {
                return $this->error('Неправильный родительский раздел');
            }
        } else {
            $parent = $sectionRoot;
        }

        if ((int)$requestData['parent_id'] != $section->parent_id) {
            if (!\Auth::user()->can('section_move', $section)) {
                return $this->error('У вас нет прав для переноса раздела...', $this);
            }
        }

        $data = $this->getRequestData($requestData, $site, $sectionModel, \Auth::user(), $section);

        $section->untag();

        if ($data['tags']) {
            $section->tag($data['tags']);
        }

        Cache::forget($sectionModel::$cacheKey . $section->id);

        $section->update($data);

        if (!empty($requestData['images'])) {
            $this->processSectionSlides($requestData, $section, $sectionImageModel);
        } else {
            $this->deleteSectionStorageImages($section, $sectionImageModel);
        }

        if ($parent && $section->id != $parent->id) {
            $section->makeChildOf($parent);
        }

        $this->updateSectionSettings($section, \Auth::user(), $requestData, $site,
            $sectionSettingModel, $sectionUserModel);

        ModuleSlide::flushCache();
        ModuleSlider::flushCache();
        ModuleSettings::flushCache();

        $this->setObject($sectionModel);
        $this->setObjectId($section->id);
        $this->setFromObject(get_class(\Auth::user()));
        $this->setFromObjectId(\Auth::user()->id);
        $this->setIsSystem(false);
        $this->setParams(['data' => ['user' => \Auth::user(), 'section' => $section->toArray()]]);
        $this->setActivityUser(\Auth::user());
        $this->setActivityFromUser(\Auth::user());
        $this->createActivity();

        return $this->success([
            'origin' => $section->origin
        ]);
    }

    /**
     * @param $request
     * @param string $sectionUserModel
     * @param string $sectionModel
     * @param string $siteSectionModel
     * @param string $sectionSettingModel
     * @param string $articleModel
     * @param string $siteModel
     * @param null $id
     * @param null $section
     * @param null $user
     * @return JsonResponse
     */
    public function showSection($request, string $sectionUserModel, string $sectionModel, string $siteSectionModel,
                                string $sectionSettingModel, string $articleModel, $siteModel = Site::class,
        $id = null, $section = null, $user = null): JsonResponse
    {
        $site = $this->getSiteByModel($siteModel);

        if ($id) {
            $section = $sectionModel::bySite($site->id);

            if ($user) {
                $section = $section->whereUserId($user->id);
            }

            $section = $section->whereId($id)->first();
        }

        if (!$section) {
            return $this->error('Раздел не найден...', null, 404);
        }

        if (Auth::user() && !Auth::user()->can('section_view', $section)) {
            return $this->error('У вас нет прав для просмотра разделов');
        }

        if (Auth::guest() && (int)$section->is_secret == 1) {
            return $this->error('Раздел не найден...', null, 404);
        }

        $siteSection = $siteSectionModel::where('section_id', $section->id)->first();
        $sectionId = $section->id;

        if ($siteSection) {
            $transferedSiteSection = $siteSection->rootSection();
            $sectionId = $transferedSiteSection->id;
            $section = $transferedSiteSection;
            $section->title = $siteSection->site->title;
        }

        $sectionSetting = $sectionSettingModel::whereSectionId($sectionId)->first();

        if ($sectionSetting) {
            $sortOptions = $sectionSetting;
        } else {
            $sortOptions = $site;
        }

        $field = $request->get('field', $sortOptions->filter_sections_sort);
        $order = $request->get('order', $sortOptions->filter_sections_sort_direction);
        $term = $request->get('term', '');
        $view = $request->get('view', $sortOptions->filter_sections_view);

        $limit = $sortOptions->sections_limit;

        $qb = $section->descendantsWithSort($field, $order)->published()->with(['site', 'setting']);

        /**
         * @var SectionModel|BlogSection $sectionModel
         */
        if (isset($sectionModel::$sortable[$field]) && !empty($order)
            && in_array($order, $sectionModel::$directions)) {
            $fieldOrder = $sectionModel::$sortable[$field];
            $fieldDirection = $order;

        } else {
            $fieldOrder = $sectionModel::$sortOptionsDefault['field'];
            $fieldDirection = $sectionModel::$sortOptionsDefault['order'];
        }

        $qb = $qb->orderBy($fieldOrder, $fieldDirection);
        $qb = $qb->depth($section->depth + 1);

        if (!empty($term)) {
            $qb = $qb->where('title', 'like', "%$term%");
        }

        $qb = $qb->announced($section->id, $sectionModel, $sectionModel, $term);

        $trashBin = null;

        if (Auth::user() && Auth::user()->can('trash_access', $section)) {
            $trashedSections = $sectionModel::where('parent_id', $sectionId)
                ->withTrashed()->whereNotNull('deleted_at')->first();
            $trashedArticles = $articleModel::where('section_id', $sectionId)
                ->withTrashed()->whereNotNull('deleted_at')->first();

            if ($trashedSections || $trashedArticles) {
                $trashBin = route('section.show_trash', ['section' => $section->slug, 'id' => $sectionId], false);
            }
        }

        $sections = $qb->paginate($limit, ['*'], 'page');
        $sections = Utils::transformUrl($sections);

        if (count($sections->items()) > 0) {
            array_map(function ($item) use ($site) {
                $item->makeHidden(['tagged']);

                if ($item->setting && $item->setting->hide_section_tags == 1) {
                    $item->makeHidden(['tags']);
                }

                return $item->setting?->makeHidden([
                    'id', 'articles_limit', 'updated_at', 'sections_limit', 'section_id',
                    'filter_sections_view', 'filter_sections_sort_direction', 'filter_sections_sort',
                    'filter_sections', 'filter_articles_view', 'filter_articles_sort_direction',
                    'filter_articles_sort', 'filter_articles', 'created_at', 'articles_limit'
                ]);

            }, $sections->items());
        }

        $sections->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'section_id' => $section->id,
            'view' => $view
        ]);

        $sections = $sections->toArray();

        if (count($sections['data']) > 0) {

            foreach ($sections['data'] as &$datum) {
                if ($datum['announce'] == 1) {

                    unset($datum['announce_object']['created_at'], $datum['announce_object']['updated_at'],
                        $datum['announce_object']['id'], $datum['announce_object']['object_id'],
                        $datum['announce_object']['object_type'], $datum['announce_object']['site_id'],
                        $datum['announce_object']['announce_id'], $datum['announce_object']['announce_type']);

                    if (count($datum['children']) > 0) {
                        foreach ($datum['children'] as &$child) {
                            $child['announce'] = 1;
                            Announceable::setAnnounce($child['children']);
                        }
                    }
                }
            }
        }

        $defaultsArticles = [
            'field' => $sortOptions->filter_articles_sort,
            'order' => $sortOptions->filter_articles_sort_direction,
            'page' => 1,
            'term' => '',
            'view' => $sortOptions->filter_articles_view
        ];

        $articles = ArticleTrait::getArticles($articleModel, $defaultsArticles, $sortOptions, $site,
            $defaultsArticles, $articleModel, null, $section);

        $section->increment('views_cnt');

        $sectionUser = $sectionUserModel::whereSectionId($sectionId)->with('user')->get();

        $rootSection = $this->getRootSection($sectionModel, $site);

        $breadcrumbs = [
            ['Главная' => route('home', [], false)],
            [$rootSection->title => route('section.index')]
        ];

        $permissions = permissions(null, true, $section);

        if ($section->isChild()) {
            foreach ($section->getAncestorsWithoutRoot() as $item) {
                $breadcrumbs[] = [$item->title => route_to_section($item, true)];
                $permissions = permissions(null, true, $item);
            }
        }

        if (!empty($section->seo_breadcrumbs)) {
            $title = $section->seo_breadcrumbs;
        } else {
            $title = $section->title;
        }

        $breadcrumbs[] = [$title => route_to_section($section, true)];

        $section = $section->makeHidden(['sectionStorageImages']);

        $section = $section->toArray();

        $section['settings'] = $sectionSetting;

        if (!$section['settings']) {
            $section['settings']['sections_name'] = __('section.name');
            $section['settings']['articles_name'] = __('article.name');
        }

        $catalog = [];
        $filter = [];

        if (!empty($section['object_id'])) {

            $neoObject = NeoUserCatalog::query()->find($section['object_id']);
            $request = request();

            if (!empty($neoObject)) {
                switch ($section) {
                    case (empty($section['filter_settings'])):
                        $request->query->add([
                            'object_id' => $section['object_id']
                        ]);

                        $catalog = $this->getCatalog($request);
                        $cards = $neoObject->cards()->paginate(config('app.catalog_limit'))->items();

                        if (count($cards) > 0) {
                            $newCards = collect();
                            foreach ($cards as $index => $card) {
                                if ($card->cardObject->id == $section['object_id']) {
                                    $newCards[] = $card;
                                }
                            }

                            $filter = $this->getCatalogFilter($newCards);
                        }
                        break;
                    case (!empty($section['filter_settings'])):

                        $cards = $neoObject->cards()->paginate(config('app.catalog_limit'))->items();

                        $request->query->add([
                            'object_id' => $section['object_id']
                        ]);


                        if (!empty($section['filter_settings'])) {

                            $newSettings = collect($section['filter_settings'])->map(function ($setting) {
                                if (isset($setting['data']['value']) && !empty($setting['data']['value'])) {
                                    return [
                                        'id' => $setting['id'],
                                        'term' => $setting['data']['value']
                                    ];
                                }
                                return null;
                            })->filter()->toArray();

                            $request->query->add([
                                'fields' => $newSettings,
                            ]);

                            $catalog = app(ObjectsController::class)
                                ->search($request);
                            $catalog = $catalog->getData()->data;

                        } else {
                            $catalog = NeoObjectTrait::getCatalog($request, $cards);
                        }

                        $filter = NeoObjectTrait::getCatalogFilter($cards);
                        /**
                         * END MODULE
                         */
                        break;
                }
            }
        }

        return $this->success([
            'catalog' => [
                'catalog' => $catalog,
                'filter' => $filter,
                'filter_settings' => $section['filter_settings'],
                'object_id' => $section['object_id']
            ],
            'trash_bin' => $trashBin,
            'breadcrumbs' => $breadcrumbs,
            'section' => $section,
            'articles' => $articles->toArray(),
            'permissions' => json_decode($permissions),
            'sections' => $sections,
            'sectionUsers' => $sectionUser->toArray(),
            'sectionsFilter' => compact('field', 'order', 'term', 'view'),
            'sectionsSortOptions' => $sectionModel::$sortOptions,
            'articlesFilter' => $defaultsArticles,
            'articlesSortOptions' => $articleModel::$sortOptions
        ], null, ['section' => $section['id']]);
    }


    public function setThumbsAttribute($thumbs)
    {
        $this->attributes['thumbs'] = $thumbs;
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(BlogSite::class, 'site_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(BlogArticle::class, 'section_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLastArticleIdAttribute(): int|null
    {
        $lastArticle = Article::query()->where(['section_id' => $this->id])
            ->orderBy('published_at', 'DESC')->limit(1)->first();

        return $lastArticle?->id;
    }

    public function getAttachedAttribute(): array
    {
        return [
            'video',
            'audio',
            'file',
            'favorite',
            'url'
        ];
    }
}
