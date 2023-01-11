<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class ArticlePolicy extends CommonPolicy
{
    use HandlesAuthorization;

    #[Pure]
    public function article_edit(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure]
    public static function checkArticle(User $user, Article|BlogArticle $article): bool
    {
        return CommentPolicy::checkUser($user, $article);
    }

    #[Pure] public function article_delete(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_status_publish(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_transfer(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_rating_show(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_update(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_title_edit(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_author_edit(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_book_manage(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_author_panel_hide(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function section_list_article_sort(): bool
    {
        return parent::check();
    }

    #[Pure] public function article_publish_time(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function article_history_manage(User $user, $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure] public function content_tag_manage(User|null $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure]
    public function comment_view(User|null $user, Article $article): bool
    {
        return self::defaultPolicy($user, $article);
    }

    #[Pure] public static function defaultPolicy(User|null $user, Article $article): bool
    {
        return parent::check();
    }

    #[Pure] public function article_create(User|null $user, Article $article): bool
    {
        return self::defaultPolicy($user, $article);
    }

    #[Pure]
    public function article_status_premoderate(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }

    #[Pure]
    public function article_view(User $user, Article $article): bool
    {
        return self::checkArticle($user, $article);
    }
}
