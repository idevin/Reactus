<?php

namespace App\Http\Controllers\Api\ProfileModules;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\BlogArticle;
use App\Models\BlogSite;
use App\Models\User as UserModel;
use App\Traits\Activity;
use App\Traits\User;
use App\Traits\Utils;
use Auth;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller
{
    use Activity;
    use User;
    use Utils;

    public static UserModel|null $user = null;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        $this->setObject(BlogArticle::class);
        $this->setFromObject(UserModel::class);
        $this->setFromObjectId(self::$user?->id);
        $this->setIsApi(true);
        $this->setIsSystem(true);
    }

    /**
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/profile/my-articles/sort Сортировка моих статей
     * @apiGroup Profile articles
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} field сортировка по полю
     * @apiParam {string} order направление сортировки
     * @apiParam {string} limit ограничение
     * @apiParam {string} view Вид - список 0, сетка 1
     * @apiParam {string} page Номер страницы
     *
     */
    public function sort(Request $request): bool|JsonResponse|string|JSON
    {
        return $this->getArticles($request);
    }

    private function getArticles(Request $request): JsonResponse|bool|string
    {
        $user = $this->publicUser();

        if (!$user) {
            return $this->error('Пользователь не найден');
        }

        $site = $this->getSite(env('DOMAIN'), BlogSite::class);
        $articles = Article::withTrashed()->whereAuthorId($user->id);

        $filter = [
            'field' => $site->filter_articles_sort,
            'order' => $site->filter_articles_sort_direction,
            'page' => 1,
            'term' => null,
            'view' => $site->filter_articles_view
        ];

        $field = $request->get('field', $filter['field']);
        $order = $request->get('order', $filter['order']);
        $term = $request->get('term', $filter['term']);
        $view = $request->get('view', $filter['view']);

        if ($term) {
            $articles->where('title', 'like', "%" . $term . "%");
        }

        $articles->sort($field, $order);

        $limit = $site->articles_limit;

        $articles = $articles->paginate($limit, ['*']);
        $articles = Utils::transformUrl($articles);

        $articles->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'view' => $view,
            'limit' => $limit
        ]);

        $sortOptions = Article::$sortOptions;

        return $this->success([
            'articles' => $articles,
            'sort_options' => $sortOptions,
            'articles_filter' => $filter
        ]);
    }

    /**
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/profile/my-articles Список моих статей
     * @apiGroup Profile articles
     *
     * @apiParam {string} token ключ пользователя
     *
     */

    public function myArticles(Request $request): JsonResponse|bool|string|JSON
    {
        return $this->getArticles($request);
    }
}