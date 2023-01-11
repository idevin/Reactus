<?php

namespace App\Traits;

use App\Models\Announcement;
use App\Models\ArticleImage;
use App\Models\ArticleRevision;
use App\Models\Complain;
use App\Models\ComplainOption;
use App\Models\LanguageObject;
use App\Models\LanguageObjectGroup;
use App\Models\Model;
use App\Models\ModerationAnswer;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSlider;
use App\Models\Rating as RatingModel;
use App\Models\Section;
use App\Models\Site;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;

trait Article
{
    use HasRoles;
    use Response;

    public static bool $increments = true;

    public static function more($site, $limit, $field, $dir, $without = [],
                                $field2 = null, $dir2 = null, $filter = null, $args = null)
    {
        $articles = self::published()->active()->with(['section', 'author'])->orderBy($field, $dir);

        if ($filter && !$args) {
            $articles = $articles->$filter();
        }

        if ($filter && $args) {
            $articles = $articles->$filter($args);
        }

        if (!empty($without)) {
            $articles = $articles->without($without);
        }

        if ($site) {
            $articles->where('site_id', $site->id);
        }

        if ($field2 && $dir2) {
            $articles->orderBy($field2, $dir2);
        }

        if ($limit) {
            $articles = $articles->take($limit);
        }

        $articles = $articles->remember(config('app.remember_time'))->get();

        if (count($articles) > 0) {
            foreach ($articles as $article) {
                $article->content = truncate_content($article->content, 500);
            }
        }

        return $articles;
    }

    public static function calculateRating($object): int
    {
        $objects = RatingModel::query()->where(['object_id' => $object->id, 'object' => get_class($object)])->get();
        $total = 0;

        foreach ($objects as $object) {
            $total += $object->rating_value;
        }

        return $total <> 0 ? ($total / count($objects)) : $total;
    }

    public static function getArticles($articleModel, $defaultsArticles,
                                       $sortOptions, $site, $announcements = true, $trash = false, $siteSection = null,
                                       $section = null)
    {
        $articles = $articleModel::published()->bySite($site->id);

        if (!\Auth::user()) {
            $articles->active();
        } else {
            $articles = self::articleFilter($articleModel, $site);
        }

        if (\Auth::user() && \Auth::user()->can('trash_access', $section) && $trash == true) {
            $articles->withTrashed()->orWhereNotNull('deleted_at');
        }

        if (!$siteSection && $section) {
            $articles->bySection($section->id);
        }

        if ($announcements == true && $section) {
            $articles->announced($section->id, get_class($section), $articleModel);
        }

        if (isset($articleModel::$sortable[$sortOptions->filter_articles_sort]) &&
            !empty($sortOptions->filter_articles_sort_direction)) {

            $articles->orderBy($articleModel::$sortable[$sortOptions->filter_articles_sort],
                $sortOptions->filter_articles_sort_direction);
        }

        $articles->with(['author']);

        $articles = $articles->paginate($sortOptions->articles_limit, ['*'], 'page_a');
        $articles = Utils::transformUrl($articles);

        $articles->appends($defaultsArticles);
        return $articles;
    }

    public static function articleFilter($articleModel, $site)
    {
        $articles = $articleModel::where(
            function ($query) use ($site, $articleModel) {
                $showDrafts = [$articleModel::STATUS_DRAFT_OFF];

                $status = [$articleModel::STATUS_PUBLISHED];

                if (Auth::user() && Auth::user()->hasPermission('article_view')) {
                    $viewOthers = (int)Auth::user()->hasPermission('article_view')['other'];

                    if ($viewOthers == 1) {
                        $showDrafts[] = $articleModel::STATUS_DRAFT;
                        $status[] = $articleModel::STATUS_DRAFT;
                    }
                }

                $query->where('site_id', $site->id)
                    ->where('published_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->whereIn('status', $status)
                    ->whereIn('draft', $showDrafts)
                    ->where('active', 1);
            });

        $articles->orWhere(function ($query) use ($site) {
            $query->where('author_id', \Auth::user()->id)
                ->where('site_id', $site->id);
        });

        return $articles;
    }

    public function getVotedAttribute(): bool
    {
        $user = Auth::user();
        if ($user) {

            $rating = RatingModel::query()->where('user_id', '=', $user->id)
                ->where('object_id', '=', $this->id)
                ->where('object', '=', Article::class)->get()->first();

            if ($this->author_id == $user->id || $rating) {
                return true;
            }
        }
        return false;
    }

    public function validateData($data, $except = []): JsonResponse|bool|string|null
    {
        if (empty($data['module_id'])) {
            return $this->error('Не задан module_id');
        }

        $module = Module::checkModule(ModuleArticle::class, $data['module_id']);

        if ($module['error']) {
            return $module['error'];
        }

        if (!isset($data['name'])) {
            $data['name'] = 'Читаемое';
        }

        $validator = static::createModuleArticleValidator($data, $except);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        return true;
    }

    public static function createModuleArticleValidator($data, $except = [], $errors = [])
    {
        $default = [
            'view' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$view)),
            'sort_by' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$sortBy)),
            'module_settings_id' => 'required',
            'sort_order' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$sortOrder)),
            'position' => 'required|in:' . implode(',', array_keys(ModuleSettings::$positionOptions)),
            'block_type' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$blockTypes)),
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

    public function deleteArticleImages($article)
    {
        if (count($article->images) > 0) {
            $article->images()->each(function ($articleImage) {
                $articleImage->delete();
            });
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $articleModel
     * @param string $siteModel
     * @return false|JsonResponse|string
     */
    public function getRevisions($request, $articleModel, $siteModel = Site::class)
    {
        $id = $request->get('id');

        $site = $this->getSiteByModel($siteModel);

        if (!$id) {
            return $this->error('Не задан ID');
        }

        $article = $articleModel::query()->whereActive(1)->whereId($id)->first();

        if (!$article) {
            return $this->error('Статья не найдена');
        }

        if (!Auth::user()->can('article_history_manage', $article)) {
            return $this->error('Вы не можете просматривать ревизии');
        }

        $defaults = [
            'field' => 'id',
            'order' => 'desc',
            'page' => 1,
            'term' => null,
        ];

        $field = $request->get('field', $defaults['field']);
        $order = $request->get('order', $defaults['order']);
        $term = $request->get('term', $defaults['term']);

        $limit = $site->articles_limit;

        $articleRevisions = ArticleRevision::whereArticleId($article->id)
            ->with('author')->orderBy($field, $order);

        if ($term) {
            $articleRevisions = $articleRevisions->where('title', 'like', "%$term%");
        }

        $articleRevisions = $articleRevisions->paginate($limit, ['*'], 'page');
        $articleRevisions = Utils::transformUrl($articleRevisions);

        $articleRevisions->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term
        ]);

        foreach ($articleRevisions->items() as $revision) {
            $revision->makeHidden(['title', 'content', 'author_id', 'article_id', 'react_data']);

            $hidden = collect(array_keys($revision->author->getAttributes()))
                ->diff(['username', 'first_name', 'last_name'])->toArray();

            $revision->author->makeHidden($hidden);
            $revision->author->makeHidden(['thumbs']);
        }

        return $this->success($articleRevisions);
    }

    public function updateUnpublishedArticles($articles, $articleModel)
    {
        $articles->get()->map(function ($article) use ($articleModel) {

            if ($article->unpublished_at) {
                $now = Carbon::now()->toDateString();
                $unpublished = $article->unpublished_at->toDateString();

                if (strtotime($unpublished) > 0) {
                    if ($now >= $unpublished) {
                        $article->update([
                            'status' => $articleModel::STATUS_DRAFT,
                            'draft' => $articleModel::STATUS_DRAFT
                        ]);
                    }
                }
            }
        });
    }

    public function sortArticles($request, $sectionModel, $articleModel, $siteModel = Site::class)
    {
        if (Auth::user() &&
            !Auth::user()->can('section_list_article_sort', $articleModel)) {
            return $this->error('Вы не можете сортировать статьи');
        }

        $sectionId = $request->get('section_id', null);
        $site = $this->getSiteByModel($siteModel);
        $sectionSetting = null;

        if ($sectionId) {
            $section = $sectionModel::bySite($site->id)->find($sectionId);
            if (!$section) {
                return $this->error('Раздел не найден');
            }
            $sectionSetting = $section->sectionSetting;
        } else {
            $section = null;
        }

        if ($sectionSetting) {
            $sortOptions = $sectionSetting;
        } else {
            $sortOptions = $site;
        }

        $filter = [
            'field' => $sortOptions->filter_articles_sort,
            'order' => $sortOptions->filter_articles_sort_direction,
            'page' => 1,
            'term' => '',
            'view' => $sortOptions->filter_articles_view
        ];

        $field = $request->get('field', $filter['field']);
        $order = $request->get('order', $filter['order']);
        $term = $request->get('term', $filter['term']);
        $view = $request->get('view', $filter['view']);
        $limit = $sortOptions->articles_limit;

        $qb = $articleModel::where(
            function ($query) use ($site, $sectionId, $term, $articleModel, $section) {
                $query->where('site_id', $site->id)
                    ->where('published_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->where('status', $articleModel::STATUS_PUBLISHED)
                    ->where('draft', 0)
                    ->where('active', 1);
                if ($sectionId && $section) {
                    $query->where('section_id', $sectionId)->announced($sectionId, get_class($section), $articleModel);
                }

                if ($term) {
                    $query->where('title', 'like', "%" . $term . "%");
                }
            })->with(['author', 'section', 'lastComment'])->sort($field, $order);

        if (!Auth::user()) {
            $qb = $qb->active();
        } else {
            $qb = $qb->orWhere(function ($query) use ($site, $sectionId, $term) {
                $query->where('author_id', Auth::user()->id)
                    ->where('site_id', $site->id);
                if ($sectionId) {
                    $query->where('section_id', $sectionId);
                }

                if ($term) {
                    $query->where('title', 'like', "%" . $term . "%");
                }
            });
        }

        $articles = $qb->remember(config('app.remember_time'))->paginate($limit, ['*'], 'page');
        $articles = Utils::transformUrl($articles);

        $articles->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'view' => $view,
            'limit' => $limit
        ]);

        $data['articles'] = $articles->toArray();

        return $this->success($data);
    }

    public function massDeleteArticle($request, $articleModel, $siteModel = Site::class): JsonResponse|bool|string
    {
        $ids = $request->get('ids');
        $site = $this->getSiteByModel($siteModel);

        if (!is_array($ids)) {
            return $this->error('Неверный формат ID статей');
        }

        if (!empty($ids)) {

            $announces = [];
            $idsOnly = [];

            self::announcesMap($ids, $announces, $idsOnly);

            Announcement::deleteAll($announces);

            $collection = $articleModel::query()->bySite($site->id)->whereIn('id', $idsOnly)->get();

            foreach ($collection as $el) {
                $el->delete();
            }

        } else {
            return $this->error('На задан параметр ids');
        }

        return $this->success();
    }

    public static function announcesMap($ids, &$announces, &$idsOnly)
    {
        array_map(function ($id) use (&$announces, &$idsOnly) {
            if (!is_array($id)) {
                $idsOnly[] = $id;
            } else {
                $announces[] = $id;
            }
        }, $ids);
    }

    /**
     * @param $request
     * @param $articleModel
     * @param $sectionModel
     * @param $articleRevision
     * @param $articleGroupArticle
     * @param $articleGroup
     * @param $articleImageModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function createArticle($request, $articleModel, $sectionModel,
                                  $articleRevision, $articleGroupArticle, $articleGroup,
                                  $articleImageModel, $siteModel = Site::class): JsonResponse
    {
        if (!Auth::user()->can('article_create', new $articleModel())) {
            return $this->error('Вы не имеете прав для создания статьи...');
        }

        $site = $this->getSiteByModel($siteModel);
        $data = $request->all();

        $id = $data['id'] ?? null;

        if (empty($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }

        $validator = self::createArticleValidator($data);

        if (isset($data['article_group']) && empty($data['article_group']['name'])) {
            $validator->errors()->add('article_group.name', 'Заполните имя для группы статей');
        }

        if (isset($data['article_group']) && count($data['article_group']['items']) > 0) {
            foreach ($data['article_group']['items'] as $articleGroupItem) {
                if (!empty($articleGroupItem['article_id'])) {

                    $articleGroupArticleExists = $articleModel::query()->bySite($site->id)
                        ->find($articleGroupItem['article_id']);

                    if (!$articleGroupArticleExists) {
                        $validator->errors()->add('article_group_items', 'Статья для группы статей не найдена');
                        break;
                    }
                }
            }
        }

        if (count($validator->errors()->messages()) > 0) {
            return $this->error($validator->errors());
        }

        $status = $request->get('status', $articleModel::STATUS_PUBLISHED);

        $statusDraft = (int)$request->get('draft', $articleModel::STATUS_DRAFT_OFF);

        $article = new $articleModel();

        if (!empty($request->get('slug'))) {
            $slug = slugify($data['slug']);
        } else {
            $slug = slugify($data['title']);
        }

        $section = $sectionModel::roots()->bySite($site->id)->get()->first();

        if (isset($data['section_id'])) {
            $section = $sectionModel::query()->bySite($site->id)->find($data['section_id']);
            if (!$section) {
                return $this->error('Раздел не найден...');
            }
        }

        if (isset($data['active'])) {
            $active = (int)$data['active'];
        } else {
            $active = 1;
        }

        if (isset($data['published_at']) && Auth::user() && Auth::user()->can('article_publish_time', $article)) {
            $publishedAt = date('Y-m-d H:i:s', strtotime($data['published_at']));
            if (strtotime($publishedAt) > strtotime('now')) {
                $statusDraft = $articleModel::STATUS_DRAFT;
            }
        } else {
            $publishedAt = date('Y-m-d H:i:s');
        }

        if (isset($data['unpublished_at'])) {
            $unpublishedAt = date('Y-m-d H:i:s', strtotime($data['unpublished_at']));
        } else {
            $unpublishedAt = null;
        }

        if (isset($data['allow_comments'])) {
            $allowComments = (int)$data['allow_comments'];
        } else {
            $allowComments = 0;
        }

        if (isset($data['moderate_comments'])) {
            $moderateComments = (int)$data['moderate_comments'];
        } else {
            $moderateComments = 0;
        }

        if (isset($data['show_background'])) {
            $showBackground = (int)$data['show_background'];
        } else {
            $showBackground = 0;
        }

        if (isset($data['content_short'])) {
            $contentShort = truncate_content($data['content_short'], 161, true, true, false);
        } else {
            $contentShort = truncate_content($data['content'], 161, true, true, false);
        }

        $reactData = $data['react_data'] ?? null;

        if (!empty($data['author_id']) && Auth::user()->can('article_author_edit', $article)) {
            $authorId = $data['author_id'];
        } else {
            $authorId = Auth::user()->id;
        }

        if (!empty($data['hide_author']) && Auth::user()->can('article_author_panel_hide', $article)) {
            $hideAuthorPanel = $data['hide_author'];
        } else {
            $hideAuthorPanel = 0;

            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для скрытия панели автора у статьи');
            }
        }

        if (Auth::user() && Auth::user()->can('article_status_publish', $article)) {
            $draft = $statusDraft;
        } else {
            $draft = $articleModel::STATUS_DRAFT_OFF;

            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для управления черновиком');
            }
        }

        if (Auth::user() && Auth::user()->can('article_rating_show', $article)) {
            $showArticleRating = (int)$data['show_article_rating'];
        } else {
            $showArticleRating = 0;
            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для включения, выключения рейтинга статьи');
            }
        }

        if ($draft == $articleModel::STATUS_DRAFT) {
            $status = $articleModel::STATUS_DRAFT;
        }

        $seoTitle = $data['seo_title'] ?? null;
        $seoDescription = $data['seo_description'] ?? null;
        $seoH1 = $data['seo_h1'] ?? null;
        $seoBreadcrumbs = $data['seo_breadcrumbs'] ?? null;

        $articleData = [
            'title' => Utils::cleanChars($data['title']),
            'author_id' => $authorId,
            'site_id' => $site->id,
            'active' => $active,
            'section_id' => $section->id,
            'content' => $data['content'],
            'content_short' => $contentShort,
            'published_at' => $publishedAt,
            'draft' => $draft,
            'status' => $status,
            'slug' => $slug,
            'unpublished_at' => $unpublishedAt,
            'settings' => [
                'allow_comments' => $allowComments,
                'sort_comments' => $articleModel::SORT_BY_DATE,
                'moderate_comments' => $moderateComments,
                'show_background' => $showBackground
            ],
            'show_article_rating' => $showArticleRating,
            'perview_hash' => '',
            'react_data' => $reactData,
            'hide_author' => $hideAuthorPanel,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'seo_h1' => $seoH1,
            'seo_breadcrumbs' => $seoBreadcrumbs,
            'show_background' => $showBackground
        ];

        if (!empty($data['section_id']) && \Auth::user()->can('article_move', new $articleModel())) {
            $articleData['section_id'] = $data['section_id'];
        }

        if ($id) {
            $article = $articleModel::find($id);
            if (!$article) {
                $article = $articleModel::create($articleData);
            } else {
                $article->update($articleData);
            }
        } else {
            $article = $article->create($articleData);
        }

        if ($article->section) {
            $article->section->update([
                'last_article_date' => Carbon::now()->toDateTimeString()
            ]);
        }

        if (Auth::user() && Auth::user()->can('content_tag_manage', $article)) {
            if (!empty($data['tags'])) {
                $article->tag(explode(',', trim($data['tags'], ',')));
            }
        }

        if (!empty($data['images'])) {
            $this->processArticleSlides($data, $article, $articleImageModel);
        } else {
            $this->deleteArticleStorageImages($article, $articleImageModel);
        }

        if (Auth::user()->can('article_history_manage', $article)) {
            $this->makeRevision($article, $articleRevision);
        }

        if (\Auth::user() && \Auth::user()->can('article_book_manage', $article)) {
            $this->createArticleGroup($article, $data, $articleGroupArticle, $articleGroup, $site);
        } else {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для создания группы статей');
            }
        }

        /**
         *  $data[language_articles] = [
         *      language_id => ...,
         *      article_id => ... (nullable),
         *      title => ...,
         *      slug => ...
         *
         *  ]
         */
        if (!empty($data['multilanguage'])) {
            $this->createLanguages($article, $data['multilanguage']);
        }

        \App\Models\Article::flushCache();

        return $this->success([
            'origin' => $article->origin
        ]);
    }

    public static function createArticleValidator($data, $except = [], $errors = [])
    {

        if (!empty($data['title'])) {
            $data['title'] = Utils::cleanChars($data['title']);
        }

        if (!empty($data['content'])) {
            $data['content'] = Utils::cleanChars($data['content']);
        }

        $default = [
            'title' => 'required|max:200|min:10|clean_whitespace',
            'content' => 'required|min:10',
            'published_at' => 'date|after_or_equal:' . date('Y-m-d'),
        ];

        $messages = [
            'title.unique' => 'Такое название статьи уже есть...',
            'title.max' => 'Название статьи не должно быть больше 200 символов',
            'title.min' => 'Название статьи не должно быть меньше 10 символов',
            'title.required' => 'Название статьи обязательно для заполнения',
            'content.required' => 'Текст статьи не заполнен',
            'content.min' => 'Контент статьи должен быть минимум 10 символов',
            'published_at.date' => 'Неверная дата публикации',
            'published_at.after_or_equal' => 'Дата публикации не может быть меньше текущей даты',
            'other_section_id.required' => 'Если хотите перенести статью на другой ресурс, выберите раздел у ресурса'
        ];

        $default = array_merge($default, $errors);

        $rules = collect($default)->except($except)->toArray();

        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param \App\Models\Article|\App\Models\BlogArticle $article
     * @param $articleRevision
     * @param array $data
     */
    protected function makeRevision($article, $articleRevision, $data = [])
    {
        $countSymbols = mb_strlen(strip_tags($article->content));

        $articleRevision::firstOrCreate([
            'title' => !empty($data['title']) ? $data['title'] : $article->title,
            'content' => !empty($data['content']) ? $data['content'] : $article->content,
            'author_id' => $article->author_id,
            'article_id' => $article->id,
            'react_data' => !empty($data['react_data']) ? $data['react_data'] : $article->react_data,
            'count_symbols' => $countSymbols,
            'section_id' => !empty($data['section_id']) ? $data['section_id'] :
                (int)$article->section_id,
            'count_images' => 0
        ]);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Revision Saved');
        }
    }

    public function createArticleGroup($article, $data, $articleGroupArticleModel, $articleGroupModel, $site)
    {
        $dataArticleGroup = isset($data['article_group']) ? $data['article_group'] : null;

        if ($dataArticleGroup && count($dataArticleGroup['items']) == 1) {
            if (current($dataArticleGroup['items'])['article_id'] == null) {
                return null;
            }
        }

        $createArticleItem = function ($articleGroupItem, $articleGroup, $article) use ($articleGroupArticleModel) {

            $articleId = !empty($articleGroupItem['article_id']) ?
                $articleGroupItem['article_id'] : $article->id;

            $name = !empty($articleGroupItem['name']) ?
                $articleGroupItem['name'] : $article->title;

            $articleGroupArticleModel::where('article_id', $articleId)
                ->where('article_group_id', $articleGroup->id)->first();

            if (!$articleGroupArticleModel) {
                return $articleGroupArticleModel::create([
                    'name' => $name,
                    'article_id' => $articleId,
                    'article_group_id' => $articleGroup->id,
                    'sort_order' => $articleGroupItem['sort_order']
                ]);
            } else {
                return $articleGroupArticleModel;
            }

        };

        if (!empty($dataArticleGroup)) {
            $dataArticleGroupItems = isset($dataArticleGroup['items']) ? $dataArticleGroup['items'] : null;

            if (!empty($dataArticleGroup['id'])) {

                $newArticle = $articleGroupModel::where('article_id', $article->id)->get()->first();

                if (!$newArticle) {
                    $articleGroupModel = $articleGroupModel::find($dataArticleGroup['id']);

                    if ($articleGroupModel) {

                        if (!empty($dataArticleGroupItems)) {
                            foreach ($dataArticleGroupItems as $articleGroupItem) {
                                if (!empty($articleGroupItem['name']) && !empty($articleGroupItem['article_id'])) {
                                    $createArticleItem($articleGroupItem, $articleGroupModel, $article);
                                }
                            }
                        }

                        $found = null;

                        foreach ($dataArticleGroupItems as $articleGroupItem) {
                            if ($articleGroupItem['article_id'] == $article->id) {
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $sortOrder = 0;
                            $currentArticle = collect($dataArticleGroupItems)->where('article_id', null)->first();

                            if ($currentArticle) {
                                $sortOrder = $currentArticle['sort_order'];
                            }

                            $articleGroupArticleModel::create([
                                'name' => $article->title,
                                'article_id' => $article->id,
                                'sort_order' => $sortOrder,
                                'article_group_id' => $articleGroupModel->id
                            ]);
                        }
                    }

                    return $articleGroupModel;
                }
            } else {
                if (!empty($dataArticleGroupItems)) {

                    $articleGroupModel = $articleGroupModel::create([
                        'name' => $data['article_group']['name'],
                        'article_id' => $article->id,
                        'user_id' => \Auth::user()->id,
                        'site_id' => $site->id
                    ]);

                    $found = null;

                    foreach ($dataArticleGroupItems as $articleGroupItem) {
                        $createArticleItem($articleGroupItem, $articleGroupModel, $article);
                        if ($articleGroupItem['article_id'] == $article->id) {
                            $found = true;
                        }
                    }

                    if (!$found) {
                        $sortOrder = 0;
                        $currentArticle = collect($dataArticleGroupItems)->where('article_id', null)->first();

                        if (!empty($currentArticle)) {
                            $sortOrder = $currentArticle['sort_order'];
                        }

                        $articleGroupArticle = $articleGroupArticleModel::where('article_id', $article->id)
                            ->where('article_group_id', $articleGroupModel->id)->first();

                        $articleGroupData = [
                            'name' => $article->title,
                            'article_id' => $article->id,
                            'sort_order' => $sortOrder,
                            'article_group_id' => $articleGroupModel->id
                        ];

                        if (!$articleGroupArticle) {
                            $articleGroupArticleModel::firstOrCreate($articleGroupData);
                        } else {
                            $articleGroupArticle->update($articleGroupData);
                        }
                    }

                    return $articleGroupModel;
                }
            }
        }
        return null;
    }

    public function createLanguages($article, $languages)
    {
        LanguageObject::whereObjectId($article->id)->delete();

        foreach ($languages as $index => $language) {

            $domain = $article->site->siteDomain->languages()
                ->where('language_id', $language['language_id'])->first();

            if ($domain) {
                LanguageObject::firstOrCreate([
                    'object_id' => $article->id,
                    'object_type' => \App\Models\Article::class,
                    'link' => $language['link'],
                    'title' => $language['title'],
                    'language_id' => $language['language_id']
                ]);
            }
        }
    }

    public function saveLanguageObject($site, $article)
    {

        $languageObject = $article->languageObjects()->save(new LanguageObject());
        $language = $site->siteDomain->language;

        if ($language) {
            LanguageObjectGroup::firstOrCreate([
                'language_object_id' => $languageObject->id,
                'language_id' => $language->id,
                'mapped_id' => $article->id
            ]);
        }
    }

    /**
     * @param $request
     * @param string $articleModel
     * @param string $sectionModel
     * @param string $articleRevision
     * @param string $articleGroupArticleModel
     * @param string $articleGroupModel
     * @param string $articleImageModel
     * @param string $siteModel
     * @return JsonResponse
     */
    public function updateArticle($request, string $articleModel, string $sectionModel,
                                  string $articleRevision, string $articleGroupArticleModel,
                                  string $articleGroupModel, string $articleImageModel, $siteModel = Site::class)
    {
        $site = $this->getSiteByModel($siteModel);
        $data = $request->all();

        if (!isset($data['id'])) {
            return $this->error('параметр ID неверный');
        } else {
            $article = $articleModel::bySite($site->id)->find($data['id']);
            if (!$article) {
                return $this->error('Статья не найдена...');
            }
        }

        if (!Auth::user()->can('article_edit', $article)) {
            return $this->error('Вы не имеете прав для обновления статьи...');
        }

        $customErrors = [];
        if (!empty($data['other_section_id']) && Auth::user()->can('article_transfer', $article)) {

            if (strstr($data['other_section_id'], '|')) {
                $data['other_section_id'] = null;
                $customErrors['other_section_id'] = 'required';
            } else {
                $section = $sectionModel::find($data['other_section_id']);

                if ($section) {
                    $article->transfer_to_section = $section->id;
                    $article->status = $articleModel::STATUS_ON_TRANSFER;
                } else {
                    return $this->error('Раздел на другом сайте не найден...');
                }
            }
        }

        $validator = self::createArticleValidator($data, ['published_at'], $customErrors);

        if (isset($data['article_group']) && empty($data['article_group']['name'])) {
            $validator->errors()->add('article_group.name', 'Заполните имя для группы статей');
        }

        if (isset($data['article_group']) && count($data['article_group']['items']) > 0) {
            foreach ($data['article_group']['items'] as $articleGroupItem) {
                if (!empty($articleGroupItem['article_id'])) {

                    $articleGroupArticleExists = $articleModel::query()->bySite($site->id)
                        ->find($articleGroupItem['article_id']);

                    if (!$articleGroupArticleExists) {
                        $validator->errors()->add('article_group_items', 'Статья для группы статей не найдена');
                        break;
                    }
                }
            }
        }

        if (count($validator->errors()->messages()) > 0) {
            return $this->error($validator->errors());
        }

        $status = $request->get('status', $articleModel::STATUS_PUBLISHED);

        $statusDraft = (int)$request->get('draft', $articleModel::STATUS_DRAFT_OFF);

        if (!empty($request->get('slug'))) {
            $slug = slugify($request->get('slug'));
        } else {
            $slug = slugify($request->get('title'));
        }

        $section = $sectionModel::roots()->bySite($site->id)->get()->first();

        if (isset($data['section_id'])) {
            $section = $sectionModel::query()->bySite($site->id)->find($data['section_id']);
            if (!$section) {
                return $this->error('Раздел не найден...');
            }
        }

        if (isset($data['active'])) {
            $active = (int)$data['active'];
        } else {
            $active = 1;
        }

        if (isset($data['published_at']) && Auth::user() && Auth::user()->can('article_publish_time', $article)) {
            $publishedAt = date('Y-m-d H:i:s', strtotime($data['published_at']));
            if (strtotime($publishedAt) > strtotime('now')) {
                $statusDraft = $articleModel::STATUS_DRAFT;
            }
        } else {
            $publishedAt = $article->published_at;
        }

        if (isset($data['unpublished_at'])) {
            $unpublishedAt = date('Y-m-d H:i:s', strtotime($data['unpublished_at']));
        } else {
            $unpublishedAt = null;
        }

        if (isset($data['allow_comments'])) {
            $allowComments = (int)$data['allow_comments'];
        } else {
            $allowComments = 0;
        }

        if (isset($data['moderate_comments'])) {
            $moderateComments = (int)$data['moderate_comments'];
        } else {
            $moderateComments = 0;
        }

        if (isset($data['show_background'])) {
            $showBackground = (int)$data['show_background'];
        } else {
            $showBackground = 0;
        }

        if (isset($data['content_short'])) {
            $contentShort = truncate_content($data['content_short'], 161, true, true, false);
        } else {
            $contentShort = truncate_content($data['content'], 161, true, true, false);
        }

        if (Auth::user() && Auth::user()->can('article_rating_show', $article)) {
            $showArticleRating = (int)$data['show_article_rating'];
        } else {
            $showArticleRating = 0;
            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(Auth::user()) . ': Нет прав для включения, выключения рейтинга статьи');
            }
        }

        if (Auth::user() && Auth::user()->can('article_status_publish', $article)) {
            $draft = $statusDraft;
        } else {
            $draft = $articleModel::STATUS_DRAFT_OFF;
            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для управления черновиком');
            }
        }

        if (Auth::user() && Auth::user()->can('article_title_edit', $article)) {
            $title = $data['title'];
        } else {
            $title = $article->title;
            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(Auth::user()) . ': Нет прав для обновления названия статьи');
            }
        }

        if ($draft == $articleModel::STATUS_DRAFT) {
            $status = $articleModel::STATUS_DRAFT;
        }

        $seoTitle = isset($data['seo_title']) ? $data['seo_title'] : null;
        $seoDescription = isset($data['seo_description']) ? $data['seo_description'] : null;
        $seoH1 = isset($data['seo_h1']) ? $data['seo_h1'] : null;
        $seoBreadcrumbs = isset($data['seo_breadcrumbs']) ? $data['seo_breadcrumbs'] : null;

        $articleData = [
            'title' => Utils::cleanChars($title),
            'site_id' => $site->id,
            'active' => $active,
            'section_id' => $section->id,
            'content' => $data['content'],
            'content_short' => $contentShort,
            'published_at' => $publishedAt,
            'unpublished_at' => $unpublishedAt,
            'draft' => $draft,
            'status' => $status,
            'slug' => $slug,
            'settings' => [
                'allow_comments' => $allowComments,
                'sort_comments' => $articleModel::SORT_BY_DATE,
                'moderate_comments' => $moderateComments,
                'show_background' => $showBackground
            ],
            'perview_hash' => '',
            'show_article_rating' => $showArticleRating,
            'react_data' => isset($data['react_data']) ? $data['react_data'] : null,
            'hide_author' => $data['hide_author'],
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'seo_h1' => $seoH1,
            'seo_breadcrumbs' => $seoBreadcrumbs,
            'show_background' => $showBackground
        ];

        $articleUser = User::find($article->author_id);

        if (!$articleUser) {
            $articleData['author_id'] = Auth::user()->id;
        }

        if (!empty($data['section_id']) && Auth::user()->can('article_move', $article)) {
            $articleData['section_id'] = $data['section_id'];
        }

        if (!empty($data['author_id']) && Auth::user()->can('article_author_edit', $article)) {
            $articleData['author_id'] = $data['author_id'];
        }

        if (!empty($data['hide_author']) && Auth::user()->can('article_author_panel_hide', $article)) {
            $articleData['hide_author'] = $data['hide_author'];
        } else {
            $articleData['hide_author'] = 0;

            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для скрытия панели автора у статьи');
            }
        }

        $article->update($articleData);

        if ($section) {
            $article->section->update([
                'last_article_date' => Carbon::now()->toDateTimeString()
            ]);
        }

        if (!empty($data['images'])) {
            $this->processArticleSlides($data, $article, $articleImageModel);
        } else {
            $this->deleteArticleStorageImages($article, $articleImageModel);
        }

        if (Auth::user() && Auth::user()->can('content_tag_manage', $article)) {
            if (!empty($data['tags'])) {
                $article->retag(explode(',', trim($data['tags'], ',')));
            } else {
                $article->untag();
            }
        }

        if (Auth::user()->can('article_history_manage', $article)) {
            $this->makeRevision($article, $articleRevision);
        }

        if (\Auth::user() && \Auth::user()->can('article_book_manage', $article)) {
            $this->updateArticleGroup($article, $data, $articleGroupModel, $articleGroupArticleModel, $site);
        } else {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars(username(\Auth::user()) . ': Нет прав для редактирования группы статей');
            }
        }

        /**
         *  $data[language_articles] = [
         *      language_id => ...,
         *      article_id => ... (nullable),
         *      title => ...,
         *      slug => ...
         *
         *  ]
         */
        if (!empty($data['multilanguage'])) {
            $this->updateLanguages($article, $data['multilanguage']);
        }

        ModuleSlide::flushCache();
        ModuleSlider::flushCache();
        $articleModel::flushCache();

        return $this->success([
            'origin' => $article->origin
        ]);
    }

    public function updateArticleGroup($article, $data, $articleGroupModel, $articleGroupArticleModel, $site)
    {
        $dataArticleGroup = isset($data['article_group']) ? $data['article_group'] : null;

        if (!$dataArticleGroup) {
            $articleGroupArticle = $articleGroupArticleModel::where('article_id', $article->id)->first();
            if ($articleGroupArticle && $articleGroupArticle->article_group) {
                $articleGroupArticle->article_group->delete();
            }
        }

        if ($dataArticleGroup && count($dataArticleGroup['items']) == 1) {
            if (current($dataArticleGroup['items'])['article_id'] == null) {
                return null;
            }
        }

        if (!empty($dataArticleGroup['id'])) {
            $articleGroup = $articleGroupModel::find($dataArticleGroup['id']);
        } else {
            $articleGroup = $articleGroupModel::where('article_id', $article->id)
                ->where('site_id', $site->id)
                ->where('user_id', \Auth::user()->id)->get()->first();
        }

        if (!empty($dataArticleGroup)) {

            if (!$articleGroup) {
                $articleGroup = $articleGroupModel::create([
                    'name' => $dataArticleGroup['name'],
                    'article_id' => $article->id,
                    'user_id' => \Auth::user()->id,
                    'site_id' => $site->id
                ]);

            } else {
                $articleGroup->update([
                    'name' => $dataArticleGroup['name']
                ]);
            }

            $dataArticleGroupItems = isset($dataArticleGroup['items']) ? $dataArticleGroup['items'] : null;

            if (!empty($dataArticleGroupItems)) {
                $found = null;

                foreach ($dataArticleGroupItems as $articleGroupItem) {
                    if ($articleGroupItem['article_id'] == $article->id) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $sortOrder = 0;
                    $currentArticle = collect($dataArticleGroupItems)->where('article_id', null)->first();

                    if ($currentArticle) {
                        $sortOrder = $currentArticle['sort_order'];
                    }

                    $articleGroupArticleModel::firstOrCreate([
                        'name' => $article->title,
                        'article_id' => $article->id,
                        'sort_order' => $sortOrder,
                        'article_group_id' => $articleGroup->id
                    ]);
                }

                foreach ($dataArticleGroupItems as $articleGroupItem) {
                    if (!empty($articleGroupItem['name']) && !empty($articleGroupItem['article_id'])) {

                        $articleData = [
                            'name' => $articleGroupItem['name'],
                            'article_id' => $articleGroupItem['article_id'],
                            'article_group_id' => $articleGroup->id,
                            'sort_order' => $articleGroupItem['sort_order']
                        ];

                        $aticleGroupArticle = $articleGroupArticleModel::where('article_id', $articleGroupItem['article_id'])->where('article_group_id', $articleGroup->id)->first();

                        if (!$aticleGroupArticle) {
                            $articleGroupArticleModel::firstOrCreate($articleData);
                        } else {
                            $aticleGroupArticle->update($articleData);
                        }
                    }
                }

                return $articleGroup;
            } else {
                if ($articleGroup) {
                    $articleGroup->delete();
                }
            }
        } else {
            if ($articleGroup) {
                $articleGroup->delete();
            }
        }

        return null;
    }

    public function updateLanguages($article, $languages)
    {
        LanguageObject::whereObjectId($article->id)->delete();

        foreach ($languages as $index => $language) {

            $domain = $article->site->siteDomain->languages()
                ->where('language_id', $language['language_id'])->first();

            if ($domain) {
                LanguageObject::firstOrCreate([
                    'object_id' => $article->id,
                    'object_type' => \App\Models\Article::class,
                    'link' => $language['link'],
                    'title' => $language['title'],
                    'language_id' => $language['language_id']
                ]);
            }
        }
    }

    public function getAutoSave($request, $article, $articleRevision, $siteModel = Site::class)
    {
        if (!Auth::user()->can('article_create', new $article())) {
            return $this->error('Вы не имеете прав для создания статьи...');
        }

        $site = $this->getSiteByModel($siteModel);

        $title = $request->get('title');
        $content = $request->get('content');
        $reactData = $request->get('react_data');
        $id = $request->get('id');
        $sectionId = $request->get('section_id');

        if (!empty($title)) {
            $title = Utils::cleanChars($title);
        }

        $articleData = [
            'title' => $title,
            'content' => $content,
            'site_id' => $site->id,
            'react_data' => $reactData,
            'author_id' => Auth::user()->id,
            'slug' => slugify($title),
            'section_id' => $sectionId,
            'draft' => $article::STATUS_DRAFT,
            'status' => $article::STATUS_PUBLISHED
        ];

        if ($id) {
            $article = $article::find($id);

            if ($article) {
                if (!empty($title) && !empty($content) && !empty($reactData)) {
                    $this->makeRevision($article, $articleRevision, $articleData);
                    $article->update($articleData);
                } else {
                    return $this->error('Недостаточно контента');
                }
            }
        } else {

            if (!empty($title) && !empty($content) && !empty($reactData)) {

                $article = $article::firstOrCreate($articleData);

                $id = $article->id;

                $this->makeRevision($article, $articleRevision);

            } else {
                return $this->error('Недостаточно контента');
            }
        }

        return $this->success(['id' => $id]);
    }

    public function getSlug($request, $articleModel, $siteModel = Site::class)
    {
        $term = $request->get('term', null);
        $articleId = $request->get('article_id', null);

        if (!$term) {
            return $this->success('Не задан параметр term');
        }

        $site = $this->getSiteByModel($siteModel);

        if ($articleId) {
            $article = $articleModel::bySite($site->id)->find($articleId);
            if (!$article) {
                return $this->error('Статья не найдена...');
            }

            $id = $article->id;
        } else {
            $table = (new $articleModel())->getTable();
            $id = getLastId($table);
        }

        $string = slugify($term) . '-' . $id . '.html';
        $data['url'] = $string;

        return $this->success($data);
    }

    public function deleteArticle($request, $articleModel, $articleGroupArticleModel,
                                  $fromGroup = false, $siteModel = Site::class)
    {
        $id = $request->input('id', null);
        $articleGroupId = $request->input('article_group_id', null);
        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        if ($fromGroup == true && !$articleGroupId) {
            return $this->error('Не задан параметр ID группы');
        }

        $site = $this->getSiteByModel($siteModel);

        $article = $articleModel::bySite($site->id)->find($id);

        if (!$article) {
            return $this->error('Статья не найдена...');
        } else {

            if (!Auth::user()->can('article_delete', $article)) {
                return $this->error('У вас нет прав для удаления статьи');
            }

            $notice = '';

            if ($fromGroup) {
                $articleGroupArticle = $articleGroupArticleModel::where('article_id', $id)
                    ->where('article_group_id', $articleGroupId)->first();

                if ($articleGroupArticle) {
                    $notice = 'Статья удалена из групп статей';

                    try {
                        $articleGroupArticle->delete();
                    } catch (Exception $e) {
                        debugvars($e->getMessage());
                    }
                }

            } else {
                $notice = 'Статья была перемещена в профайл автора';

                if ($article->isStatusPublished()) {
                    $section = $article->section;

                    if ($section && $section->articles_cnt > 0) {
                        $ids = $section->getAncestorsAndSelfWithoutRoot()
                            ->where('articles_cnt', '>', 0)->pluck('id')->toArray();

                        DB::table('section')->whereIn('id', $ids)->decrement('articles_cnt');
                    }
                }

                $article->delete();
            }
        }

        ModuleSlide::flushCache();
        ModuleSlider::flushCache();
        \App\Models\Article::flushCache();
        ModuleSettings::flushCache();

        return $this->success($notice);
    }

    public function getForm($request, $articleModel, $sectionModel, $articleGroupModel,
                            $articleGroupArticleModel, $siteModel = Site::class): JsonResponse|bool|string
    {
        if (Auth::user() && !Auth::user()->can('article_create', new $articleModel())) {
            return $this->error('Вы не имеете прав для создания статьи...');
        }

        $site = $this->getSiteByModel($siteModel);

        $otherSections = [];
        $users = [];

        $articleModel::$useShortContentDots = false;

        $sections = $sectionModel::getOptionValues($site, true);
        $id = $request->input('article_id', null);
        $article = null;

        if ($id) {
            $article = $articleModel::bySite($site->id)->find($id);

            if (!$article) {
                return $this->error('Статья не найдена');
            }

            if (!Auth::user()->can('article_edit', $article)) {
                return $this->error('Вы не можете редактировать статью');
            }

            if (Auth::user()->can('article_move', $article)) {
                $otherSections = $this->getAllSections($sectionModel, $site);
            }

            if (\Auth::user()->can('article_author_edit', $article)) {
                $users = User::query()->orderBy('username', 'desc')
                    ->select(['id', 'username', 'first_name', 'last_name'])->get()->toArray();
            } else {
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars(username(\Auth::user()) . ': Нет прав для изменения пользователя к статье');
                }
            }
        }

        $statuses = (new $articleModel())->getStatusOptions();
        $currentLanguages = [];

        if ($article) {

            $articleArray = $article->toArray();
            $articleArray['article_group'] = $this->setArticleGroup($article,
                $articleGroupModel, $articleGroupArticleModel);

            if (!empty($articleArray['article_group'])) {

                if ($articleArray['article_group']['article_id'] == $article->id) {
                    $article->main = true;
                }

                $found = null;

                if (!empty($articleArray['article_group']['items'])) {
                    foreach ($articleArray['article_group']['items'] as $articleGroupItem) {
                        if ($articleGroupItem['article_id'] == $article->id) {
                            $found = true;
                            break;
                        }
                    }
                }

                if (!$found) {
                    $articleArray['article_group']['items'][] = $article->toArray();
                }
            }

            if (empty($articleArray['article_group'])) {
                $articleArray['article_group'] = null;
            }

            $languageObject = LanguageObject::whereObjectId($article->id)
                ->whereObjectType($articleModel)->first();

            if ($languageObject) {
                $articleArray['language_groups'] = $languageObject->languageObjectGroups;
                $currentLanguages = $languageObject
                    ->languageObjectGroups->map(function ($languageGroup) {
                        return $languageGroup->language_id;
                    });
            }
        } else {
            $articleArray = null;
        }

        $searchGroupArticles = $articleModel::query()->bySite($site->id)->published()
            ->orderBy('created_at', 'desc');

        if ($article) {
            $searchGroupArticles = $searchGroupArticles->whereNotIn('id', [$article->id]);
        }

        $searchGroupArticles = $searchGroupArticles->get()->take(10)
            ->makeHidden(['last_comment', 'site', 'attached', 'created']);

        $articleGroups = $articleGroupModel::bySite($site->id)->with(['articles'])
            ->orderBy('name', 'asc')->get()->take(10);

        $options = $site->only(['show_article_rating', 'hide_article_author_inside']);
        $options['show_background'] = 1;
        $languages = [];

        if ($site->siteDomain) {
            $languages = $site->siteDomain->languages()->get()
                ->map(function ($domain) {
                    return $domain->language;
                });
        }

        if (!empty($currentLanguages)) {
            $languages = $languages->filter(function ($language) use ($currentLanguages) {
                if (!in_array($language->id, $currentLanguages->toArray())) {
                    return true;
                }

                return false;
            })->values();
        }

        $multiLanguage = [];
        if ($article) {
            $multiLanguage = LanguageObject::whereObjectId($article->id)->with(['language'])
                ->whereObjectType($articleModel)->get();
        }

        return $this->success([
            'search_group_articles' => $searchGroupArticles,
            'sections' => $sections,
            'other_section_id' => $otherSections,
            'article' => $articleArray,
            'article_groups' => $articleGroups,
            'statuses' => $statuses,
            'comment_sort_options' => $articleModel::$sortComments,
            'options' => $options,
            'users' => $users,
            'languages' => $languages,
            'multilanguage' => $multiLanguage
        ]);
    }

    public function setArticleGroup($article, $articleGroupModel, $articleGroupArticleModel)
    {
        $articleGroup = $articleGroupModel::where('article_id', $article->id)->get()->first();

        if ($articleGroup) {
            $articleGroup = $articleGroup->toArray();

            $articleGroupArticles = $articleGroup['items'];
            $articlesCount = count($articleGroupArticles);

            $articleGroup['prev'] = null;
            $articleGroup['next'] = null;

            unset($articleGroup['article']);

            if ($article->id == $articleGroup['article_id']) {

                if (!empty($articleGroup['items']) && count($articleGroup['items']) == 1) {
                    if ($articleGroup['items'][0]['article_id'] == $article->id) {
                        return [];
                    }
                }

                if (in_array($articlesCount, [1, 2])) {
                    $index = 0;
                    if ($articleGroup['items'][0]['article_id'] == $article->id) {
                        $index += 1;
                    }

                    $articleGroup['next'] = collect($articleGroup['items'][$index])->only(['name', 'url']);

                } else {
                    if (!empty($articleGroup['items'])) {

                        $articleGroup['next'] = collect($articleGroup['items'][0])->only(['name', 'url']);

                        foreach ($articleGroup['items'] as $index => $articeItem) {
                            if ($articeItem['article_id'] == $article->id) {
                                if ($index > 0) {
                                    $articleGroup['prev'] = collect($articleGroup['items'][$index - 1])->only(['name', 'url']);
                                } elseif ($index == 0) {
                                    $articleGroup['prev'] = collect($articleGroup['items'][count($articleGroup['items']) - 1])->only(['name', 'url']);
                                }

                                $articleGroup['items'][$index]['main'] = true;

                                if ($articeItem['article_id'] == $article->id) {
                                    if (isset($articleGroup['items'][$index + 1])) {
                                        $articleGroup['next'] = collect($articleGroup['items'][$index + 1])->only(['name', 'url']);
                                    }
                                    if ($index + 1 == count($articleGroup['items'])) {
                                        $articleGroup['next'] = null;
                                    }
                                }

                                break;
                            }
                        }
                    }

                }
            }

        } else {
            $articleGroupArticle = $articleGroupArticleModel::whereArticleId($article->id)->get()->first();

            if ($articleGroupArticle) {

                $articleGroup = $articleGroupArticle->article_group->makeHidden(['article']);

                $articleGroup = $articleGroup->toArray();

                $articleGroupArticles = $articleGroup['items'];
                $articlesCount = count($articleGroupArticles);

                if (in_array($articlesCount, [1, 2])) {
                    $articleGroup['prev'] = collect($articleGroup['items'][0])->only(['name', 'url']);
                } else {
                    $currentArticleIndex = 0;

                    for ($i = 0; $i < $articleGroupArticles; $i++) {
                        if ($articleGroupArticles[$i]['article_id'] == $article->id) {
                            $currentArticleIndex = $i;
                            break;
                        }
                    }

                    foreach ($articleGroup['items'] as $index => $item) {
                        if ($item['article_id'] == $articleGroup['article_id']) {
                            $articleGroup['items'][$index]['main'] = true;
                            break;
                        }
                    }

                    if ($currentArticleIndex == 0) {
                        $articleGroup['prev'] = collect($articleGroup)->only(['name', 'url']);
                        $articleGroup['next'] = null;

                    } else {
                        if (count($articleGroupArticles) == $currentArticleIndex + 1) {

                            $articleGroup['prev'] = collect($articleGroupArticles[$currentArticleIndex - 1])
                                ->only(['name', 'url']);

                            if ($articleGroupArticles[$currentArticleIndex]['article_id'] == $article->id) {

                                $next = collect($articleGroupArticles)
                                    ->where('sort_order', 0)->first();
                                $next = collect($next)->only(['name', 'url']);
                            } else {
                                $next = collect(collect($articleGroupArticles)
                                    ->where('sort_order', 0)->first())->only(['name', 'url']);
                            }

                            $articleGroup['next'] = $next;

                        } else {

                            $articleGroup['prev'] = collect($articleGroupArticles[$currentArticleIndex - 1])
                                ->only(['name', 'url']);
                            $articleGroup['next'] = collect($articleGroupArticles[$currentArticleIndex + 1])
                                ->only(['name', 'url']);
                        }
                    }
                }
            }
        }

        if (empty($articleGroup)) {
            $articleGroup = null;
        }

        return $articleGroup;
    }

    public function getArticle($title, $id, $articleModel, $articleRevisionModel,
                               $commentArchiveModel, $commentModel, $articleGroupModel,
                               $articleGroupArticleModel, $siteModel = Site::class,
                               $sectionModel = Section::class, $increment = true)
    {
        $user = Auth::user();
        $site = $this->getSiteByModel($siteModel);

        if (!$site) {
            return $this->error('Сайт не найден');
        }

        $article = $articleModel::with(['author'])
            ->without(['tagged'])->whereId($id)->bySite($site->id);

        if (!$user) {
            $article = $article->active();
        }

        if (static::$increments == true) {
            $article->increment('views_cnt');
        }

        $article = $article->first();

        if (!$article) {
            return $this->error('Статья не найдена (ID)', null, 404);
        }

        if ($user && $article->author_id != $user->id && !$user->can('article_view', $article)) {
            if ($article->isDraft() || (strtotime($article->published_at) > strtotime('now'))) {
                return $this->error('Статья не опубликована либо находится в черновиках...');
            }
        }

        if ($user && !$user->can('article_view', $article)) {
            return $this->error('Вы не можете просматривать статьи');
        }

        if ($article->status == $articleModel::STATUS_ON_MODERATION &&
            (Auth::guest() || ($user && !$user->can('article_status_premoderate', $article)))
        ) {
            return $this->error('Статья на модерации...');
        }

        $comments = [];
        $commentsPinned = [];
        $commentArchive = null;

        if (($user && $user->can('comment_view', $article)) || (Auth::guest() && self::canAnon('comment_view'))) {
            if (isset($article->settings['allow_comments']) && (int)$article->settings['allow_comments'] == 1) {
                $commentsArray = $this->loadComments($article, $articleModel, $commentArchiveModel, $commentModel);
                $comments = $commentsArray['comments'];
                $commentsPinned = $commentsArray['commentsPinned'];
                $commentArchive = $article->commentArchive;
            }
        } else {
            if ($user && $article->author_id == $user->id) {
                $commentsArray = $this->loadOwnComments($article, $articleModel,
                    $commentArchiveModel, $commentModel);

                $comments = $commentsArray['comments'];
            }
        }

        $articleModelClass = !is_string($articleModel) ?
            get_class($articleModel) : $articleModel;

        $moderationAnswer = ModerationAnswer::query()->where(['object' => $articleModelClass,
            'object_id' => $article->id, 'confirmed_at' => '0000-00-00 00:00:00'])->get()->first();

        $complain = Complain::query()->where(['object' => $articleModelClass, 'object_id' => $article->id])->first();

        $complainOptions = remember('complain.options', function () {
            return ComplainOption::getTree();
        });

        $revisions = null;

        if (Auth::user() && Auth::user()->can('article_edit', $article) && Auth::user()->id == $article->author_id) {
            $revisions = $articleRevisionModel::where(['article_id' => $article->id, 'author_id' => $article->author_id])->get();
        }

        $rootSection = $this->getRootSection($sectionModel, $site);

        $breadcrumbs = [
            ['Главная' => route('home', [], false)]
        ];

        if ($rootSection) {
            $breadcrumbs[] = [$rootSection->title => route('section.index', [], false)];
        }

        if ($article->section && $article->section->parent_id != null) {

            foreach ($article->section->getAncestorsAndSelf() as $item) {
                if ($item->parent_id != null) {
                    $breadcrumbs[] = [$item->title => route_to_section($item, true)];
                }
            }

            $setting = $article->section->sectionSetting;

            if ($setting && $setting->hide_article_author_inside != null) {
                $article->hide_author = $setting->hide_article_author_inside;
            }
        }

        $articleTitle = $article->title;

        if (!empty($article->seo_breadcrumbs)) {
            $articleTitle = $article->seo_breadcrumbs;
        }

        $breadcrumbs[] = [$articleTitle => route_to_article($article, true)];

        $articleArray = $article->toArray();

        $articleArray['article_group'] = $this->setArticleGroup($article, $articleGroupModel, $articleGroupArticleModel);

        $multiLanguage = LanguageObject::whereObjectId($article->id)->with(['language'])
            ->whereObjectType(\App\Models\Article::class)->get();

        return $this->success([
            'moderationAnswer' => $moderationAnswer,
            'article' => $articleArray,
            'comments' => $comments,
            'commentsPinned' => $commentsPinned,
            'commentsSort' => $articleModel::$sortComments,
            'commentArchive' => $commentArchive,
            'user' => $user,
            'breadcrumbs' => $breadcrumbs,
            'complain' => $complain,
            'complainOptions' => $complainOptions,
            'revisions' => $revisions,
            'multilanguage' => $multiLanguage->toArray(),
            'announcements' => $article->announcements
        ]);
    }

    protected function loadComments($oObject, $articleModel, $commentArchive, $commentModel)
    {
        $comments = [];

        $sortOrder = $oObject->sort_comments;

        $alias = $articleModel::$sortComments[2]['alias'];

        $sort = request('sort', $articleModel::COMMENTS_SORT_BY_DATE);

        if (in_array($sortOrder, array_keys($articleModel::$sortComments))) {
            $alias = $articleModel::$sortComments[$sortOrder]['alias'];
        }

        $commentArchive = $commentArchive::where('article_id', $oObject->id)->first();

        foreach (['comments', 'modifiedComments'] as $paginations) {
            $$paginations = $commentModel::with(['author', 'announces'])
                ->where('object', '=', get_class($oObject))
                ->where('object_id', '=', $oObject->id);

            if ($commentArchive) {
                $$paginations = $$paginations->where('created_at', '>', $commentArchive->from_date);
            }

            $object = $$paginations;

            if (isset($oObject->settings['moderate_comments']) &&
                (int)$oObject->settings['moderate_comments'] == 1) {
                $object->where('status', '=', $commentModel::STATUS_APPROVED);
                $$paginations = $object;
            }

            $$paginations = $$paginations->whereNull('pinned')
                ->orderBy($alias, 'ASC')
                ->paginate(10)->appends([
                    'sort' => $sort
                ]);

            $$paginations = Utils::transformUrl($$paginations);
        }

        $commentsPinned = $commentModel::where('object', '=', get_class($oObject))
            ->where('object_id', '=', $oObject->id)
            ->where('pinned', 1)->get();

        return compact('comments', 'commentsPinned');
    }

    protected function loadOwnComments($oObject, $articleModel, $commentArchive, $commentModel)
    {
        $comments = [];

        $sortOrder = $oObject->sort_comments;

        $alias = $articleModel::$sortComments[2]['alias'];

        $sort = request('sort', $articleModel::COMMENTS_SORT_BY_DATE);

        if (in_array($sortOrder, array_keys($articleModel::$sortComments))) {
            $alias = $articleModel::$sortComments[$sortOrder]['alias'];
        }

        $commentArchive = $commentArchive::where('article_id', $oObject->id)->first();

        foreach (['comments', 'modifiedComments'] as $paginations) {
            $$paginations = $commentModel::with('author')
                ->where('object', '=', get_class($oObject))
                ->where('object_id', '=', $oObject->id)
                ->where('author_id', Auth::user()->id);

            if ($commentArchive) {
                $$paginations = $$paginations->where('created_at', '>', $commentArchive->from_date);
            }

            $object = $$paginations;

            if (isset($oObject->settings['moderate_comments']) &&
                (int)$oObject->settings['moderate_comments'] == 1) {
                $object->where('status', '=', $commentModel::STATUS_APPROVED);
                $$paginations = $object;
            }

            $$paginations = $$paginations->whereNull('pinned')
                ->orderBy($alias, 'ASC')
                ->paginate(10)->appends([
                    'sort' => $sort
                ]);
            $$paginations = Utils::transformUrl($$paginations);
        }

        return compact('comments');
    }

    public function getIndex($request, $articleModel, $siteModel = Site::class): JsonResponse
    {
        $site = $this->getSiteByModel($siteModel);
        $data = [];

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $defaults = [
            'field' => $site->filter_articles_sort,
            'order' => $site->filter_articles_sort_direction,
            'page' => 1,
            'term' => '',
        ];

        $field = $request->get('field', $defaults['field']);
        $order = $request->get('order', $defaults['order']);
        $term = $request->get('term', $defaults['term']);
        $sectionId = $request->get('section_id', null);
        $limit = $site->articles_limit;

        $qb = $articleModel::query();

        if (!Auth::user()) {
            $qb = $qb->active();
        } else {
            $qb = self::articleFilter($articleModel, $site);
        }


        if ($term) {
            $qb->where('title', 'like', "%$term%");
        }

        if (Session::get('siteAsSection') && $request->ajax()) {
            $site = Session::get('siteAsSection')->site;
            $sectionId = null;
        }

        if ($sectionId) {
            $qb->where('section_id', $sectionId);
        }

        $articles = $qb->remember(config('app.remember_time'))
            ->paginate($limit, ['*'], 'page');
        $articles = Utils::transformUrl($articles);

        $articles->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term
        ]);

        $articleItems = $articles->items();
        if (count($articleItems) > 0) {
            foreach ($articleItems as &$item) {
                if ($site->show_article_author == 0) {
                    $item->hide_author = 1;
                }
            }
        }

        $data['articles'] = $articles->toArray();

        $data['breadcrumbs'] = [
            ['Главная' => route('home', [], false)],
            ['Статьи' => route('article.index', [], false)]
        ];

        $data['settings'] = $site->siteSettings();
        $data['articlesFilter'] = $defaults;
        $data['articlesSortOptions'] = $articleModel::$sortOptions;

        return $this->success($data);
    }

    public function getShowRevision($request, $articleRevisionModel)
    {
        $id = $request->get('id');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $articleRevision = $articleRevisionModel::find($id);

        if (!$articleRevision) {
            return $this->error('Ревизия статьи не найдена');
        }

        $articleRevision->makeHidden(['article_id', 'content']);

        return $this->success($articleRevision);
    }

    /**
     * @param $data
     * @param $article
     * @param Model $articleImageModel
     * @throws Exception
     */
    protected function processSlides($data, $article, $articleImageModel)
    {
        $imagesData = [];

        foreach ($data['slides'] as $index => &$image) {

            if (is_string($image) && strstr($image, 'data:')) {
                $imageData = $this->saveBase64Data($image, 'article_slider',
                    Auth::user());
                $imagesData[$index] = $imageData;
            }

            if (is_array($image)) {
                $imageName = current(array_keys($image));
                $imageOptions = current(array_values($image));

                if ($imageOptions == 'delete') {
                    $this->deleteImages($imageName, 'article_slider');
                    $imageToDelete = $articleImageModel::where('image', $imageName)
                        ->where('article_id', $article->id)->first();

                    $imageToDelete?->delete();
                }

                if (strstr($imageOptions, 'data:')) {

                    $this->deleteImages($imageName, 'article_slider');

                    $imageData = $this->saveBase64Data($imageOptions, 'article_slider',
                        Auth::user());

                    $imageUpdate = $articleImageModel::where('image', $imageName)
                        ->where('article_id', $article->id)->first();

                    if ($imageUpdate) {
                        $imageUpdate->update([
                            'image' => $imageData['filename'],
                            'title' => $article->title
                        ]);
                    }
                }
            }
        }

        $imagesData = array_values($imagesData);

        if (!empty($imagesData) && !empty($imagesData[0])) {

            $article->images()->saveMany(array_map(function ($image) use ($article) {
                return new ArticleImage([
                    'article_id' => $article->id,
                    'image' => $image['filename'],
                    'title' => null,
                    'description' => null
                ]);
            }, $imagesData));
        }
    }

    public function deleteImages($imageName, $folder)
    {
        $path = public_path(config('netgamer.upload_dir') . DS . 'storage' . DS . $folder . DS);
        $imagePath = $path . $imageName;

        $fs = new Filesystem();

        if (file_exists($imagePath)) {
            $fs->delete($imagePath);
        }

        foreach (config('image.thumb.' . $folder) as $item) {
            $imagePath = $path . 'thumbs' . DS . $item['size'][0] . 'x' . $item['size'][1] . DS . $imageName;
            if (file_exists($imagePath)) {
                $fs->delete($imagePath);
            }
        }
    }

    public function getUrlAttribute()
    {
        $article = $this->article()->get()->first();
        if ($article) {
            return route_to_article($article, true);
        }

        return null;
    }
}
