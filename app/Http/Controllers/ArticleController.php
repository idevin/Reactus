<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleGroup;
use App\Models\ArticleGroupArticle;
use App\Models\ArticleRevision;
use App\Models\Comment;
use App\Models\CommentArchive;
use App\Models\Complain;
use App\Models\ComplainOption;
use App\Models\ModerationAnswer;
use App\Models\Section;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Article as ArticleTrait;
use App\Traits\Section as SectionTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use ArticleTrait;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Article::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(false);
        $this->setIsSystem(true);
    }

    public function index()
    {
        $this->getMeta(__METHOD__, get_site());

        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    /**
     * @param $slug
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show($slug, $id): Factory|Redirector|View|RedirectResponse
    {
        static::$increments = false;

        $article = $this->getArticle($slug, $id, Article::class, ArticleRevision::class,
            CommentArchive::class, Comment::class, ArticleGroup::class, ArticleGroupArticle::class);

        if (!$article) {
            return redirect('/404');
        }

        $this->getMeta(__METHOD__, $article);

        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
