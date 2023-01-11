<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Article as ArticleModel;
use App\Models\ArticleGroup;
use App\Models\ArticleGroupArticle;
use App\Models\Comment;
use App\Models\Domain;
use App\Models\ModerationAnswer;
use App\Models\ModuleSettings;
use App\Models\ModuleSlide;
use App\Models\Page;
use App\Models\PageRevision;
use App\Models\Rating;
use App\Models\Section;
use App\Models\SectionUser;
use App\Models\Site;
use App\Models\SiteRole;
use App\Models\SiteUser;
use App\Models\User;
use App\Traits\Activity;
use Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ExportController extends Controller
{
    use  ValidatesRequests, Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Site::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
    }

    /**
     * @param Request $request
     * @return array|false|JsonResponse|string
     * @api {POST} /api/export/site Экспорт сайта
     * @apiGroup Import Export
     *
     * @apiParam {integer} site_id siteId
     * @apiParam {string} domain (or domainName)
     *
     * @apiParam {string} token AuthKey
     *
     */
    public function site(Request $request)
    {
        $user = Auth::user();

        if ($domainName = $request->get('domain')) {
            if (!$domain = Domain::whereName($domainName)->first()) {
                return $this->error("Domain ($domainName) not found");
            }
            if (!$site = Site::whereDomain($domain->name)->with('setting')->first()) {
                return $this->error("Site for given domain ({$domain->name}) not found");
            }
            $siteId = $site->id;

        } else {
            $siteId = (int)$request->get('site_id');

            if (!$siteId) {
                return $this->error('Не задан параметр site_id');
            }

            $site = Site::query()->whereId($siteId)->with('setting')->first();

            if (!$site) {
                return $this->error("Сайт не найден");
            }
        }

        $articleGroups = ArticleGroup::whereSiteId($siteId)->get();
        foreach ($articleGroups as $articleGroup) {
            $articleGroup->article_group_articles = ArticleGroupArticle::query()
                ->whereArticleGroupId($articleGroup->id)->get();
        }

        $articles = Article::query()->with('commentArchive')->byUser($user->id)->bySite($siteId)->get()->toArray();
        $announces = Announcement::whereSiteId($siteId)->get();
        $comments = Comment::bySite($siteId)->whereObject(ArticleModel::class)->get();
        $articleGroups = ArticleGroup::whereSiteId($siteId)->get();
        $sections = Section::query()->with('setting', 'sectionRoles')->whereUserId($user->id)
            ->whereSiteId($siteId)->get()->toHierarchy()->toArray();

        $answers = ModerationAnswer::query()->whereAuthorId($user->id)->get();

        $pages = Page::query()->with(['header', 'footer', 'content'])
            ->whereSiteId($site->id)->whereUserId($user->id)->get();

        $pageIds = $pages->pluck('id')->toArray();

        $pageRevisions = PageRevision::query()->whereIn('page_id', $pageIds)->get();
        $rating = Rating::query()->whereUserId($user->id)->get();
        $sectionUsers = SectionUser::query()->whereUserId($user->id)->get();
        $siteRoles = SiteRole::query()->whereUserId($user->id)->whereSiteId($site->id)->get();
        $siteUsers = SiteUser::query()->whereUserId($user->id)->whereSiteId($site->id)->get();

        $data = [
            'site' => $site,
            'user' => $user,
            'articles' => $articles,
            'announces' => $announces,
            'comments' => $comments,
            'article_groups' => $articleGroups,
            'sections' => $sections,
            'moderation_answers' => $answers,
            'pages' => $pages,
            'page_revisions' => $pageRevisions,
            'rating' => $rating,
            'section_users' => $sectionUsers,
            'site_roles' => $siteRoles,
            'site_users' => $siteUsers,
        ];

        $data['article_group_article'] = [];

        foreach ($data['article_groups'] as $articleGroup) {
            $newArticleGroup = ArticleGroupArticle::whereArticleGroupId($articleGroup->id)->get()->toArray();
            $data['article_group_article'] = array_merge($data['article_group_article'], $newArticleGroup);
        }

        $json_data = json_encode(compact('data'));

        $appStoragePath = storage_path() . '/app';
        $fileName = $site->domain . '-' . $user->id;

        if (!file_put_contents($appStoragePath . '/' . $fileName . '.json', encrypt($json_data, false))) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars("Невозможно создать файл: {$appStoragePath}");
            }

            return $this->error('Невозможно создать файл');
        }

        return $this->success();
    }
}
