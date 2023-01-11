<?php

namespace App\Contracts;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Comment;
use App\Models\ProfileModuleInformation;
use App\Models\ProfileStatus;
use App\Traits\Activity as ActivityTrait;
use App\Traits\Article as ArticleTrait;
use App\Traits\Site;

class ProfileModuleObserver
{
    public $module = null;
    public static $user = null;

    use Site;
    use ArticleTrait;
    use ActivityTrait;

    public function __construct($module)
    {
        $this->module = $module;

        if (!self::$user) {
            self::$user = \Auth::user();
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $methodNames = preg_split('#\\\#', $this->module->class);
        $methodName = null;

        if (!empty($methodNames)) {
            $methodName = last($methodNames);
            $methodName = lcfirst($methodName);
        }

        return $this->{$methodName}();
    }

    public function profileModuleBlog()
    {

    }

    public function profileModuleArticle()
    {
        $site = $this->getSite(env('DOMAIN'));
        $articles = Article::where('author_id', self::$user->id);

        $filter = [
            'field' => $site->filter_articles_sort,
            'order' => $site->filter_articles_sort_direction,
            'page' => 1,
            'term' => '',
            'view' => $site->filter_articles_view
        ];

        $field = request()->get('field', $filter['field']);
        $order = request()->get('order', $filter['order']);
        $term = request()->get('term', $filter['term']);
        $view = request()->get('view', $filter['view']);

        if ($term) {
            $articles->where('title', 'like', "%" . $term . "%");
        }

        $articles->sort($field, $order);

        $limit = $site->articles_limit;

        $articles = $articles->paginate($limit, ['*'], 'article_page');

        $articles->appends([
            'field' => $field,
            'order' => $order,
            'term' => $term,
            'view' => $view,
            'limit' => $limit
        ]);

        return $articles->toArray();
    }

    public function profileModuleStatistics()
    {
        $articlesCount = Article::where('author_id', self::$user->id)->count();
        $commentsCount = Comment::where('author_id', self::$user->id)->count();

        return [
            'articles_count' => $articlesCount,
            'comments_count' => $commentsCount
        ];
    }

    public function profileModuleActivity()
    {
        $data = [];
        $activities = Activity::where('user_id', self::$user->id)->orderBy('created_at', 'DESC')->get();

        foreach ($activities as $activity) {
            $data[] = $this->getActivity($activity);
        }

        return $data;
    }

    public function profileModuleStatus()
    {
        $site = $this->getSite(env('DOMAIN'));
        $statuses = ProfileStatus::byUser(self::$user->id)->bySite($site->id)->orderBy('created_at', 'desc')->get()->makeHidden(['site_id', 'updated_at', 'user_id']);

        return $statuses;
    }

    public function profileModuleInformation()
    {
        $information = ProfileModuleInformation::where('user_id', self::$user->id)->first();

        return $information;
    }

    public function getActivity($activity)
    {
        $fromUser = $activity->fromUser()->get()->first();
        $user = $activity->user()->get()->first();
        $fieldUser = null;
        $status = null;

        if ($fromUser->id != $user->id) {
            $articleWithComment = username($fromUser) . ' оставил комментарий';
            $commentWithComment = username($fromUser) . ' ответил на комментарий';
        } else {
            $articleWithComment = 'Вы оставили комментарий';
            $commentWithComment = 'Вы ответили на свой комментарий';
        }

        if ($activity->object() && $activity->object()->multi_field == 0) {
            $groupUser = 'Вы обновили профиль';
        } else {
            $groupUser = 'Выдобавили данные в профиль';
        }

        if (isset($activity->params['deleted']) && $activity->params['deleted'] == true) {
            $fieldUser = 'Вы удалили данные профиля';
        }

        if (!isset($activity->params['image'])) {
            $avatar = 'Вы обновили основные данные профиля';
        } else {
            $avatar = 'Вы обновили аватар';
        }

        if (!empty($activity->params['status'])) {
            $status = 'Вы обновили статус';
        }

        $title = [
            'article-with-article' => ' Вы написали статью',
            'article-with-comment' => $articleWithComment,
            'article-with-user' => 'Вы отредактировали статью',
            'comment-with-article' => $articleWithComment,
            'comment-with-comment' => $commentWithComment,
            'default-activity' => 'Активность',
            'fieldgroup-with-user' => $groupUser,
            'fieldusergroup-with-user' => $fieldUser,
            'user-with-user' => $avatar,
            'user-with-user-status' => $status
        ];

        $template = get_activity_template($activity);

        $data = [];
        if (isset($title[$template])) {
            $data['title'] = $title[$template];
        }
        $action = lcfirst(str_replace('-', '', ucwords($template, '-')));
        $data['data'] = $this->{$action}($activity);

        return $data;
    }
}