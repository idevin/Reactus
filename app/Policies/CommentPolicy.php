<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class CommentPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    #[Pure] public function comment_create(User $user): bool
    {
        return parent::check();
    }

    #[Pure] public function comment_delete(User $user, Comment $comment): bool
    {
        return self::checkUser($user, $comment);
    }

    public static function checkUser(User $user, Comment|Article $o): bool
    {
        $editOwn = $o->author_id == $user->id && self::$permission->pivot->own == 1;
        $editOwnReversed = $user->id != $o->author_id && self::$permission->pivot->other == 1;

        if ($editOwn || $editOwnReversed) {
            return true;
        }
    }

    #[Pure] public function comment_edit(User $user, Comment $comment): bool
    {
        return self::checkUser($user, $comment);
    }

    #[Pure] public function article_comment_archive_manage(User $user, Article $article): bool
    {
        return self::checkUser($user, $article);
    }

    #[Pure] public function moderpool_comment_access(User $user, Comment $comment): bool
    {
        return parent::check();
    }
}
