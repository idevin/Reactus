<?php namespace App\Policies;

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

/**
 * Class BlogArticlePolicy
 * @package App\Policies
 */
class BlogArticlePolicy extends CommentPolicy
{
    use HandlesAuthorization;

    #[Pure]
    public function article_edit(User $user, BlogArticle $article): bool
    {
        return ArticlePolicy::checkArticle($user, $article);
    }


    #[Pure]
    public function article_delete(User $user, BlogArticle $article): bool
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_status_publish(User $user, BlogArticle $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_transfer(User $user, BlogArticle $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_rating_show(User $user, BlogArticle $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_update(User $user, $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_title_edit(User $user, $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_author_edit(User $user, $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_book_manage(User $user, $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function article_author_panel_hide(User $user, $article)
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    public function section_list_article_sort()
    {
        $editOwn = self::$permission->pivot->own == 1;
        $editOwnReversed = self::$permission->pivot->other == 1;

        if (($editOwn || $editOwnReversed)) {
            return true;
        }

        return false;
    }

    #[Pure] public function article_publish_time(User $user, $article): bool
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    #[Pure] public function article_history_manage(User $user, $article): bool
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    #[Pure]
    public function content_tag_manage(User|null $user, BlogArticle $article): bool
    {
        return ArticlePolicy::defaultPolicy($user, $article);
    }

    #[Pure] public function section_list_article_bind(User|null $user, BlogArticle $article): bool
    {
        return ArticlePolicy::defaultPolicy($user, $article);
    }

    #[Pure] public function comment_view(User $user, BlogArticle $article): bool
    {
        return ArticlePolicy::defaultPolicy($user, $article);
    }

    #[Pure] public function article_create(User $user, BlogArticle $article): bool
    {
        return ArticlePolicy::defaultPolicy($user, $article);
    }

    #[Pure]
    public function article_status_premoderate(User $user, BlogArticle $article): bool
    {
        return ArticlePolicy::checkArticle($user, $article);
    }

    #[Pure]
    public function article_view(User $user, BlogArticle $article): bool
    {
        return ArticlePolicy::checkArticle($user, $article);
    }
}