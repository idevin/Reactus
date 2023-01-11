<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Section;
use App\Models\SubscribeArticle;
use App\Models\SubscribeSection;
use App\Models\SubscribeUser;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    /**
     * @activity done
     */
    public static User|null $user = null;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(SubscribeSection::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['unsubscribeArticle', 'unsubscribeSection', 'unsubscribeUser',
            'article', 'section', 'user']);
    }

    public static function getUser(Request $request): array|JsonResponse|string|null
    {
        $toUserId = $request->get('on_user_id');

        $onUser = User::query()->find($toUserId);

        if (!$onUser) {
            return Response::response()->error('Такой пользователь не найден');
        }

        $subscribeUser = SubscribeUser::query()->where('subscribed_user_id', Auth::user()->id)
            ->where('on_user_id', $toUserId)->first();

        return compact('subscribeUser', 'onUser');
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string|array
     * @api {POST} /api/subscribe/section Подписка на разделы
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} section_id ID раздела
     *
     * @internal param Request $request
     */
    public function section(Request $request): JsonResponse|bool|string|array
    {
        $result = self::getSection($request);

        if (!is_array($result)) {
            return $result;
        }

        if ($result['subscribeSection']) {
            return $this->error('Вы уже подписаны на раздел');
        } else {
            $subscribeSection = SubscribeSection::create([
                'user_id' => Auth::user()->id,
                'section_id' => $result['sectionId']
            ]);
        }

        $this->setIsSystem(false);
        $this->setParams($subscribeSection->toArray());
        $this->createActivity();

        return $this->success();
    }

    public static function getSection($request): array|JsonResponse|string
    {
        $sectionId = $request->get('section_id');

        $section = Section::query()->find($sectionId);

        if (!$section) {
            return Response::response()->error('Раздел не найден');
        }

        $subscribeSection = SubscribeSection::query()->where('user_id', Auth::user()->id)
            ->where('section_id', $sectionId)->first();

        return compact('subscribeSection', 'sectionId');

    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string
     * @api {POST} /api/subscribe/article Подписка на статьи
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} article_id ID статьи
     *
     * @internal param Request $request
     */
    public function article(Request $request): JsonResponse|bool|string
    {
        $result = self::getArticle($request);

        if (!is_array($result)) {
            return $result;
        }

        if ($result['subscribeArticle']) {
            return $this->error('Вы уже подписаны на статью');
        } else {
            $subscribeArticle = SubscribeArticle::query()->create([
                'user_id' => Auth::user()->id,
                'article_id' => $result['articleId']
            ]);
        }

        $this->setIsSystem(false);
        $this->setParams($subscribeArticle->toArray());
        $this->createActivity();

        return $this->success();
    }

    public static function getArticle($request): array|JsonResponse|string
    {
        $articleId = $request->get('article_id');

        $article = Article::query()->find($articleId);

        if (!$article) {
            return Response::response()->error('Статья не найдена');
        }

        $subscribeArticle = SubscribeArticle::query()->where('user_id', Auth::user()->id)
            ->where('article_id', $articleId)->first();

        return compact('subscribeArticle', 'articleId');
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/subscribe/user Подписка на пользователя
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} on_user_id ID пользователя, на которого подписываются
     *
     * @internal param Request $request
     */
    public function user(Request $request): JsonResponse|bool|string
    {
        $result = self::getUser($request);

        if (!is_array($result)) {
            return $result;
        }

        if ($result['subscribeUser']) {
            return $this->error('Вы уже подписаны на пользователя');
        }

        if ($result['onUser']->id == Auth::user()->id) {
            return $this->error('Вы не можете подписаться на себя');
        } else {
            $subscribeUser = SubscribeUser::query()->create([
                'subscribed_user_id' => Auth::user()->id,
                'on_user_id' => $result['onUser']->id
            ]);
        }

        $this->setIsSystem(false);
        $this->setParams($subscribeUser->toArray());
        $this->createActivity();

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {POST} /api/subscriptions Список подписок пользователя
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {Text} field поле сортировки
     * @apiParam {Text} order направление сортировки
     * @apiParam {integer} page номер страницы
     * @apiParam {Text} term Условие поиска
     *
     * @internal param Request $request
     */
    public function index(Request $request)
    {
        $users = SubscribeUser::where('subscribed_user_id', Auth::user()->id)->with(['onUser']);
        $sections = SubscribeSection::where('user_id', Auth::user()->id)->with(['section']);
        $articles = SubscribeArticle::where('user_id', Auth::user()->id)->with(['article']);

        $field = $request->get('field', 'created_at');
        $order = $request->get('order', 'desc');
        $term = $request->get('term');
        $page = $request->get('page', 1);
        $limit = 10;

        if (empty($field)) {
            $field = 'created_at';
        }

        foreach (['users', 'sections', 'articles'] as $i => $o) {
            $$o = $$o->orderBy($field, $order)->get();
        }

        if ($term) {

            $getContentFilter = function ($query, $term) {
                return $query->orWhere('title', 'like', '%' . $term . '%')
                    ->orWhere('content', 'like', '%' . $term . '%')
                    ->orWhere('content_short', 'like', '%' . $term . '%');
            };

            foreach (['users', 'sections', 'articles'] as $i => $o) {
                switch ($o) {
                    case 'users':

                        $$o = $users->filter(function ($user) use ($term) {
                            $found = $user->onUser()->where(function ($query) use ($term) {
                                $query->orWhere('username', 'like', '%' . $term . '%')
                                    ->orWhere('first_name', 'like', '%' . $term . '%')
                                    ->orWhere('last_name', 'like', '%' . $term . '%')
                                    ->orWhere('email', 'like', '%' . $term . '%')
                                    ->orWhere('middle_name', 'like', '%' . $term . '%');
                            })->first();

                            if (count($found) > 0) {
                                return true;
                            }

                            return false;
                        });
                        break;

                    case 'sections':
                        $$o = $sections->filter(function ($section) use ($term, $getContentFilter) {
                            $found = $section->section()->where(function ($query) use ($term, $getContentFilter) {

                                $getContentFilter($query, $term);

                                $query->orWhere('slug', 'like', '%' . $term . '%')
                                    ->orWhere('path', 'like', '%' . $term . '%');
                            })->first();

                            if (count($found) > 0) {
                                return true;
                            }

                            return false;
                        });

                        break;
                    case 'articles':

                        $$o = $articles->filter(function ($article) use ($term, $getContentFilter) {
                            $found = $article->article()->where(function ($query) use ($term, $getContentFilter) {
                                $getContentFilter($query, $term);
                            })->first();

                            if (count($found) > 0) {
                                return true;
                            }

                            return false;
                        });

                        break;
                }
            }
        }

        $hideObjects = function ($o) {
            $o->makeHidden('site');
            $o->makeHidden('tagged');
            return $o;
        };

        $allUsersArray = $users->map(function ($user) use ($hideObjects) {

            return [
                'type' => User::class,
                'id' => $user->id,
                'comments' => $user->onUser->comments()->limit(3)->orderBy('id', 'desc')->get(),
                'sections' => $user->onUser->sections()->limit(3)->orderBy('id', 'desc')->get()
                    ->map(function ($section) use ($hideObjects) {
                        return $hideObjects($section);
                    }),
                'articles' => $user->onUser->articles()->with(['author'])->limit(3)->orderBy('id', 'desc')->get()
                    ->map(function ($article) use ($hideObjects) {
                        return $hideObjects($article);
                    })
            ];
        });

        $allSectionsArray = $sections->map(function ($section) use ($hideObjects) {
            return [
                'type' => Section::class,
                'id' => $section->id,
                'sections' => $section->section->children()->limit(3)->orderBy('id', 'desc')->get()
                    ->map(function ($section) use ($hideObjects) {
                        return $hideObjects($section);
                    }),
                'articles' => $section->section->articles()->limit(3)->orderBy('id', 'desc')->get()
                    ->map(function ($article) use ($hideObjects) {
                        return $hideObjects($article);
                    })

            ];
        });

        $allArticlesArray = $articles->map(function ($article) {
            return [
                'type' => Article::class,
                'id' => $article->id,
                'comments' => $article->article->comments()->limit(3)->orderBy('id', 'desc')->get(),
            ];
        });

        $allData = collect()->merge($allUsersArray)->merge($allSectionsArray)->merge($allArticlesArray);

        $allData = new LengthAwarePaginator($allData, $allData->count(), $limit, $page,
            ['path' => $request->url(), 'query' => $request->query()]);

        $allData->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'page' => $page
        ]);

        return $this->success($allData);
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string|array
     * @api {POST} /api/unsubscribe/section Отписка от разделов
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} section_id ID раздела
     *
     * @internal param Request $request
     */
    public function unsubscribeSection(Request $request): JsonResponse|bool|string|array
    {
        $result = self::getSection($request);

        if (!is_array($result)) {
            return $result;
        }

        $subscribeSection = SubscribeSection::query()->where('user_id', Auth::user()->id)
            ->where('section_id', $result['sectionId'])->first();

        if ($subscribeSection) {
            $this->setIsSystem(false);
            $this->setParams($result['subscribeSection']->toArray());
            $this->createActivity();

            $subscribeSection->delete();
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/unsubscribe/article Отписка от статей
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} article_id ID статьи
     *
     * @internal param Request $request
     */
    public function unsubscribeArticle(Request $request): JsonResponse|bool|string
    {
        $result = self::getArticle($request);

        if (!is_array($result)) {
            return $result;
        }

        if ($result['subscribeArticle']) {
            $this->setIsSystem(false);
            $this->setParams($result['subscribeArticle']->toArray());
            $this->createActivity();

            $result['subscribeArticle']->delete();
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/unsubscribe/user Отписка от пользователя
     * @apiGroup Subscribe
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} on_user_id ID пользователя, на которого подписываются
     *
     * @internal param Request $request
     */
    public function unsubscribeUser(Request $request): JsonResponse|bool|string
    {
        $result = self::getUser($request);

        if (!is_array($result)) {
            return $result;
        }

        if ($result['subscribeUser']) {
            $this->setIsSystem(false);
            $this->setParams($result['subscribeUser']->toArray());
            $this->createActivity();

            $result['subscribeUser']->delete();
        }

        return $this->success();
    }

}