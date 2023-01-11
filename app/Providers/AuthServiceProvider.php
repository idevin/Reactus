<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\BlogArticle;
use App\Models\BlogSection;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Complain;
use App\Models\Modules\ModuleCompetitiveAdvantages;
use App\Models\Modules\ModuleSlider;
use App\Models\NeoCard;
use App\Models\Section;
use App\Models\Site;
use App\Models\Slider;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\BlogArticlePolicy;
use App\Policies\BlogSectionPolicy;
use App\Policies\CardsPolicy;
use App\Policies\CommentPolicy;
use App\Policies\CommunityPolicy;
use App\Policies\CompetitiveAdvantagesPolicy;
use App\Policies\ComplainPolicyy;
use App\Policies\GalleryPolicy;
use App\Policies\SectionPolicy;
use App\Policies\SitePolicy;
use App\Policies\SliderPolicy;
use App\Policies\UserPolicy;
use App\Traits\Site as SiteTrait;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    use SiteTrait;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Comment::class => CommentPolicy::class,
        Complain::class => ComplainPolicyy::class,
        Section::class => SectionPolicy::class,
        Slider::class => SliderPolicy::class,
        Site::class => SitePolicy::class,
        User::class => UserPolicy::class,
        BlogArticle::class => BlogArticlePolicy::class,
        BlogSection::class => BlogSectionPolicy::class,
        ModuleCompetitiveAdvantages::class => CompetitiveAdvantagesPolicy::class,
        NeoCard::class => CardsPolicy::class,
        ModuleSlider::class => GalleryPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     * @return void
     */
    public function boot()
    {
        Auth::provider('eloquent', function () {
            return resolve(CacheUserProvider::class);
        });

        $this->registerPolicies();
    }
}
