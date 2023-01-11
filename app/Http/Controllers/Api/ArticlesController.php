<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleGroup;
use App\Models\ArticleGroupArticle;
use App\Models\ArticleRevision;
use App\Models\ArticleStorageImage;
use App\Models\Comment;
use App\Models\CommentArchive;
use App\Models\LanguageObject;
use App\Models\Section;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Article as ArticleTrait;
use App\Traits\Media;
use App\Traits\Section as SectionTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    /**
     * @activity done
     */
    public static User|null $user = null;

    use Activity;
    use ArticleTrait;
    use Media;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Article::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['create', 'delete', 'massDelete', 'update', 'cancel', 'autoSave']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/articles Список статей с фильтром
     * @apiGroup Articles
     *
     * @apiParam {string} [field="rating"] Поле сортировки для статей (доступные значения: , "comments", "rating", 
     * "views", "commented_at", "published_at", "created_at", "deleted_at")
     * @apiParam {string} [order="asc"] Направление сортировки
     * @apiParam {integer} section_id ID раздела для фильтра
     * @apiParam {string} [term] Строка для поиска по заголовку статьи
     * @apiParam {string} [page] номер страницы
     *
     * @internal param Request $request
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getIndex($request, Article::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/articles/sort Сортировка статей
     * @apiGroup Articles
     *
     * @apiParam {integer} section_id Id раздела
     * @apiParam {string} term Поиск по статьям
     * @apiParam {integer} page Страница для пагинатора
     * @apiParam {string} field Поле для сортировки
     * @apiParam {string} order Сортировка по возрастанию, по убыванию
     * @apiParam {string} view Вывод списком или сеткой (1 - сетка, 0 - список)
     *
     */
    public function sort(Request $request): JsonResponse
    {
        return $this->sortArticles($request, Section::class, Article::class);
    }

    /**
     * @param $title
     * @param $id
     * @return JsonResponse
     * @api {GET} /api/article/{alias}-{id}.html Просмотр статьи
     * @apiGroup Articles
     *
     * @internal param Request $request
     */
    public function show($title, $id): JsonResponse
    {
        if (Auth::guest() && !self::canAnon('article_view')) {
            return $this->error('Вы не можете просматривать статью');
        }

        return $this->getArticle($title, $id, Article::class, ArticleRevision::class, CommentArchive::class,
            Comment::class, ArticleGroup::class, ArticleGroupArticle::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/articles/form Форма статьи
     * @apiGroup Articles
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} article_id ID статьи
     * @apiParam {string} author_id ID для смены пользователя (необязательно)
     *
     */
    public function form(Request $request): JsonResponse
    {
        return $this->getForm($request, Article::class, Section::class, ArticleGroup::class, ArticleGroupArticle::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @internal param Request $request
     * @api {POST} /api/articles/create Создание статьи
     * @apiGroup Articles
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} title Название статьи
     * @apiParam {string} content Тело статьи
     * @apiParam {JSON} react_data Данные редактора
     * @apiParam {integer} section_id ID раздела
     * @apiParam {integer} [author_id] ID автора
     * @apiParam {Boolean} [active] активная статья или нет
     * @apiParam {string} [slug] alias для статьи
     * @apiParam {string} [seo_title] СЕО название для статьи
     * @apiParam {string} [seo_description] СЕО описание для статьи
     * @apiParam {string} [seo_h1] СЕО h1 для статьи
     * @apiParam {string} [seo_breadcrumbs] СЕО хлебные крошки для статьи
     * @apiParam {date} [published_at] Дата публикации статьи
     * @apiParam {date} [unpublished_at] Дата снятия с публикации
     * @apiParam {Boolean} [allow_comments] Разрешить коментарии или нет для статьи
     * @apiParam {Boolean} [moderate_comments] Модерировать комментарии или нет
     * @apiParam {Boolean} [draft] Статья черновик или нет
     * @apiParam {string} [tags] Тэги для статьи (через запятую)
     * @apiParam {string} [images] Картинки
     * @apiParam {string} [slides[]] Картинки для слайдера
     * @apiParam {array} [article_group] Группы статей
     * @apiParam {string} [content_short] краткое описание
     * @apiParam {Boolean} [hide_author] скрыть автора статьи
     * @apiParam {Boolean} [show_article_rating] Показывать рейтинг
     * @apiParam {Boolean} [show_background] Показывать картинку на заднем фоне
     *
     */
    public function create(Request $request): JsonResponse
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->createArticle($request, Article::class, Section::class,
            ArticleRevision::class, ArticleGroupArticle::class,
            ArticleGroup::class, ArticleStorageImage::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @internal param Request $request
     * @api {POST} /api/articles/update Обновление статьи
     * @apiGroup Articles
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} title Название статьи
     * @apiParam {string} content Тело статьи
     * @apiParam {JSON} react_data Данные редактора
     * @apiParam {integer} section_id ID раздела
     * @apiParam {Boolean} [active] активная статья или нет
     * @apiParam {string} [slug] alias для статьи
     * @apiParam {string} [seo_title] СЕО название для статьи
     * @apiParam {string} [seo_description] СЕО описание для статьи
     * @apiParam {string} [seo_h1] СЕО h1 для статьи
     * @apiParam {string} [seo_breadcrumbs] СЕО хлебные крошки для статьи
     * @apiParam {integer} author_id - ID автора
     * @apiParam {date} [published_at] Дата публикации статьи
     * @apiParam {Boolean} [allow_comments] Разрешить коментарии или нет для статьи
     * @apiParam {Boolean} [moderate_comments] Модерировать комментарии или нет
     * @apiParam {Boolean} [draft] Статья черновик или нет
     * @apiParam {string} [tags] Тэги для статьи (через запятую)
     * @apiParam {string} [images[]] Картинки
     * @apiParam {string} [slides[]] Картинки для слайдера
     * @apiParam {array} article_group группа статей article_group[name: "...", article_id, items: [[article_id: 1, name: "name", sort_o rder: 1]]]
     * @apiParam {string} other_section_id Перенос статьи в другой раздел и на другой сайт
     * @apiParam {array} language_articles связка языковых статей [language_id => ...,article_id => ... (nullable),title => ...,slug => ...]
     * @apiParam {array} [article_group] Группы статей
     * @apiParam {string} [content_short] краткое описание
     * @apiParam {Boolean} [hide_author] скрыть автора статьи
     * @apiParam {Boolean} [show_article_rating] Показывать рейтинг
     * @apiParam {Boolean} [show_background] Показывать картинку на заднем фоне
     *
     */
    public function update(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->updateArticle($request, Article::class, Section::class,
            ArticleRevision::class, ArticleGroupArticle::class, ArticleGroup::class,
            ArticleStorageImage::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/articles/delete Удаление статьи
     * @apiGroup Articles
     *
     * @apiParam {integer} id ID статьи
     *
     * @internal param Request $request
     */
    public function delete(Request $request): JsonResponse
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();
        return $this->deleteArticle($request, Article::class, ArticleGroupArticle::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/articles/mass_delete Массовое удаление статьи
     * @apiGroup Articles
     *
     * @apiParam {array} ids[] ID статей
     *
     * @internal param Request $request
     */
    public function massDelete(Request $request): JsonResponse
    {
        $this->setIsSystem(false);
        $this->setParams($request->toArray());
        $this->createActivity();
        return $this->massDeleteArticle($request, Article::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {GET} /api/articles/section Получение всех статей в разделе
     * @apiGroup Articles
     *
     * @apiParam {integer} id ID раздела
     *
     * @internal param Request $request
     */
    public function section(Request $request): JsonResponse
    {
        $id = $request->get('id', null);
        $site = get_site();

        if (!empty($id)) {
            $section = Section::query()->bySite($site->id)->find($id);

            if (!$section) {
                return $this->error('Раздел не найден');
            }

            if (count($section->articles) > 0) {
                $ids = $section->articles->map(function ($article) {
                    return $article->id;
                });
            } else {
                $ids = [];
            }

        } else {
            return $this->error('На задан параметр ID');
        }

        return $this->success(['articles' => $ids]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/articles/delete_article_group_article Удаление статьи из группы статей
     * @apiGroup Articles
     * @apiParam {integer} id ID статьи
     * @apiParam {integer} article_group_id ID группы статей
     *
     * @internal param Request $request
     */
    public function deleteArticleFromGroup(Request $request): JsonResponse
    {
        return $this->deleteArticle($request, Article::class, ArticleGroupArticle::class, true);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/articles/revisions Ревизии статьи
     * @apiGroup Articles
     *
     * @apiParam {integer} id ID статьи
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} [field] поле сортировки
     * @apiParam {string} [order] направление сортировки
     *
     */
    public function revisions(Request $request): bool|JsonResponse|string
    {
        return $this->getRevisions($request, Article::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/articles/show_revision Просмотр ревизии статьи
     * @apiGroup Articles
     *
     * @apiParam {integer} id ID ревизии
     * @apiParam {string} token Ключ пользователя
     *
     * @internal param Request $request
     */
    public function showRevision(Request $request): JsonResponse
    {
        return $this->getShowRevision($request, ArticleRevision::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/articles/slug Генерация статьи (slug)
     * @apiGroup Articles
     *
     * @apiParam {string} term символы для алиаса
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} article_id ID статьи (необязательное поле)
     * @internal param Request $request
     */
    public function slug(Request $request): JsonResponse
    {
        return $this->getSlug($request, Article::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/articles/auto_save Автосохранение статьи
     * @apiGroup Articles
     *
     * @apiParam {string} token - Токен ключ пользователя
     * @apiParam {integer} id - ID статьи (если статья автоматически сохранена)
     * @apiParam {string} title - название статьи
     * @apiParam {integer} section_id - ID раздела
     * @apiParam {string} content - контент статьи
     * @apiParam {string} react_data - данные для reactjs
     *
     * @internal param Request $request
     */
    public function autoSave(Request $request): JsonResponse
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();
        return $this->getAutoSave($request, Article::class, ArticleRevision::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/articles/cancel Отмена статьи и помещение в черновик
     * @apiGroup Articles
     *
     * @apiParam {string} token - Токен ключ пользователя
     * @apiParam {integer} id - ID статьи
     *
     * @internal param Request $request
     */
    public function cancel(Request $request): JsonResponse
    {
        $id = $request->get('id');

        if ($id) {
            $site = get_site();
            $article = Article::bySite($site->id)->byUser(Auth::user()->id)->find($id);

            if (!$article) {
                return $this->error('Статья не найдена');
            }

            $article->update([
                'status' => Article::STATUS_DRAFT
            ]);
        } else {
            return $this->error('неверный параметр ID');
        }

        $this->setIsSystem(false);
        $this->setParams($article->toArray());
        $this->createActivity();

        return $this->success('Статья помещена в черновик');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/articles/delete_language Удаление языка для статьи
     * @apiGroup Articles
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID удаляемого языка
     * @apiParam {integer} object_id ID обьекта
     * @apiParam {string} object_type Тип обьекта (app\Models\Article, app\Models\Section...)
     */

    public function deleteLanguage(Request $request): JsonResponse
    {

        $id = $request->get('id');
        $type = $request->get('object_type');
        $objectId = $request->get('object_id');

        if (!$type) {
            return $this->error('Не задан тип обьекта');
        }

        if (!$objectId) {
            return $this->error('Не задач ID обьекта');
        }

        if (!$id) {
            return $this->error('Не задан ID');
        }

        $languageObject = LanguageObject::where('object_id', $objectId)
            ->where('object_type', $type)->first();

        if (!$languageObject) {
            return $this->error('Обьект не найден');
        }

        $language = $languageObject->languageObjectGroups->where('id', $id)->first();

        if (!$language) {
            return $this->error('Статья не найдена');
        }

        $language->delete();

        return $this->success();
    }
}
