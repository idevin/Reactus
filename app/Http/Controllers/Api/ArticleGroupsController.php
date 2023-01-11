<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleGroup;
use App\Models\ArticleGroupArticle;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Article as ArticleTrait;
use App\Traits\Media;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleGroupsController extends Controller
{
    /**
     * @activity done
     */
    public static User|null $user = null;

    use ArticleTrait;
    use Media;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(ArticleGroup::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['create', 'createArticle', 'delete', 'deleteArticle']);
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/article_groups/delete Удаление группы статей
     * @apiGroup Article Groups
     *
     * @apiParam {integer} id ID группы статей
     * @apiParam {integer} token Токен пользователя
     *
     */
    public function delete(Request $request): JsonResponse|bool|string
    {
        $id = $request->get('id');
        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $site = $this->getSite(env('DOMAIN'));

        $group = ArticleGroup::bySite($site->id)->byUser(Auth::user()->id)->find($id);

        if (!$group) {
            return $this->error('Группа статей не найдена');
        }

        $this->setIsSystem(false);
        $this->setParams($group->toArray());
        $this->createActivity();

        $group->delete();

        return $this->success(['group' => $group]);
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string
     * @api {POST} /api/article_groups/create Создание группы статей
     * @apiGroup Article Groups
     *
     * @apiParam {integer} article_id ID статьи к которой при крепляется группа статей
     * @apiParam {string} name название группы статей
     * @apiParam {integer} token Токен пользователя
     *
     */
    public function create(Request $request): JsonResponse|bool|string
    {
        $name = $request->get('name');
        $articleId = $request->get('article_id');

        $site = $this->getSite(env('DOMAIN'));

        if (!$name) {
            return $this->error('Не задан параметр name');
        }
        if (!$articleId) {
            return $this->error('Не задан параметр article_id');
        }

        $article = Article::bySite($site->id)->byUser(Auth::user()->id)->find($articleId);

        if (!$article) {
            return $this->error('Статья не найдена');
        }

        $modelData = [
            'name' => $name,
            'article_id' => $articleId,
            'user_id' => Auth::user()->id,
            'site_id' => $site->id
        ];

        $articleGroup = ArticleGroup::query()->firstOrCreate($modelData);

        $this->setIsSystem(false);
        $this->setParams($articleGroup->toArray());
        $this->createActivity();

        return $this->success(['article_group' => $articleGroup]);
    }

    public function addArticle(Request $request)
    {

    }

    public function deleteArticle(Request $request): JsonResponse|bool|string
    {
        $id = $request->get('id');
        $groupId = $request->get('group_id');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $site = $this->getSite(env('DOMAIN'));

        $group = ArticleGroup::bySite($site->id)->find($groupId);

        if (!$group) {
            return $this->error(' группа статей не найдена');
        }

        $article = ArticleGroupArticle::query()->where([
            'article_id' => $id,
            'article_group_id' => $group->id
        ])->get()->first();

        if (!$article) {
            return $this->error('Статья не найдена');
        }

        $this->setIsSystem(false);
        $this->setParams($article->toArray());
        $this->createActivity();

        $article->delete();

        $data['articles_count'] = $group->articles->count();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/article_groups/search_group Поиск по группе статей
     * @apiGroup Article Groups
     *
     * @apiParam {string} term Cимволы для поиска
     * @apiParam {string} token Токен ключ пользователя
     * @internal param Request $request
     */
    public function searchGroup(Request $request): JsonResponse
    {
        $term = $request->get('term');
        $site = $this->getSite(env('DOMAIN'));

        if (!$term) {
            return $this->success('Не задан параметр term');
        }

        $articleGroups = ArticleGroup::bySite($site->id)
            ->where('name', 'like', '%' . $term . '%')
            ->with(['articles'])->orderBy('name')->get();

        return $this->success($articleGroups->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/article_groups/search_article Поиск по статье для группы статей
     * @apiGroup Article Groups
     *
     * @apiParam {string} term символы для поиска
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} current_article_id  ID статьи, к которой прикрепляется группа
     * @apiParam {array} current_article_group_ids Массив текущих статей в группе
     *
     * @internal param Request $request
     */
    public function searchArticle(Request $request): JsonResponse
    {
        $site = $this->getSite(env('DOMAIN'));

        $currentArticleGroupIds = json_decode($request->get('current_article_group_ids'));

        $term = $request->get('term');

        $currentArticleId = $request->get('current_article_id');

        if (!$term) {
            return $this->success('Не задан параметр term');
        }

        $articles = Article::published()->bySite($site->id)->where('title', 'like', '%' . $term . '%')
            ->orderBy('title');

        if ($currentArticleId) {
            $articles = $articles->whereNotIn('id', [$currentArticleId]);
        }

        $articles = $articles->get()->makeHidden(['last_comment', 'site', 'attached', 'settings',
            'content_short', 'name', 'created_at_formated', 'updated_at_formated']);


        $articleGroups = ArticleGroup::bySite($site->id)->byUser(Auth::user()->id)->get();

        if (count($articleGroups) > 0) {

            $filteredArticles = [];

            foreach ($articles as $article) {
                foreach ($articleGroups as $articleGroup) {
                    foreach ($articleGroup->items as $item) {
                        if ($article->id == $item->article_id) {
                            $filteredArticles[] = $article->id;
                            break;
                        }
                    }
                }
            }

            if (!empty($filteredArticles)) {
                $articles = $articles->except($currentArticleGroupIds);
            }
        }

        $articles->map(function ($article) {
            $article->makeHidden(['active', 'author_id', 'comments_cnt', 'content', 'created_at',
                'deleted_at', 'draft', 'hide_author', 'id', 'image', 'images', 'last_comment_at',
                'last_comment_author', 'last_comment_id', 'last_comment_url', 'likes_cnt',
                'on_main', 'on_main_head', 'origin', 'published_at', 'rating', 'react_data',
                'section_id', 'settings', 'site_id', 'slug', 'sort_comments', 'sort_order', 'status', 'tagged',
                'tags', 'transfer_to_section', 'transfered', 'unpublished_at',
                'updated_at', 'views_cnt', 'voted']);
        });

        return $this->success($articles->toArray());
    }


    public function createArticle(Request $request): JsonResponse|bool|string
    {
        $articleId = $request->get('article_id');

        if (!$articleId) {
            return $this->error('Не задан параметр article_id');
        }

        $articleGroupId = $request->get('article_group_id');
        if (!$articleGroupId) {
            return $this->error('Не задан параметр article_group_id');
        }

        $article = Article::byUser(Auth::user()->id)->find($articleId);
        if (!$article) {
            return $this->error('Статья не найдена');
        }

        $articleGroup = ArticleGroup::byUser(Auth::user()->id)->find($articleGroupId);

        if (!$articleGroup) {
            return $this->error('Прошивка не найдена');
        }

        $articleGroupArticle = ArticleGroupArticle::query()->create([
            'article_id' => $articleId,
            'article_group_id' => $articleGroupId
        ]);

        $this->setIsSystem(false);
        $this->setParams($articleGroupArticle->toArray());
        $this->createActivity();

        return $this->success(['article_group' => $articleGroupArticle]);
    }

}