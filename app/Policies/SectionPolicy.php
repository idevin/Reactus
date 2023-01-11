<?php

namespace App\Policies;

use App\Models\BlogSection;
use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class SectionPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function __construct()
    {

    }

    #[Pure]
    public function section_edit(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    public static function checkSection($user, $section): bool
    {
        $editOwn = ($user->id == $section->user_id && self::$permission->pivot->own == 1);
        $editOwnReversed = ($user->id != $section->user_id && self::$permission->pivot->other == 1);

        if ($editOwn || $editOwnReversed) {
            return true;
        }

        return false;
    }

    #[Pure] public function section_delete(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure] public function section_hide(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure] public function section_move(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure] public function section_view(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure] public function section_list_article_author_hide(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure]
    public function section_tag_hide(User $user, Section $section): bool
    {
        return self::defaultPolicy($user, $section);
    }

    public static function defaultPolicy(User $user, Section|BlogSection $section): bool
    {
        $editOwn = $user->id && self::$permission->pivot->own == 1;
        $editOwnReversed = $user->id && self::$permission->pivot->other == 1;

        if ($editOwn || $editOwnReversed) {
            return true;
        }

        return false;
    }

    #[Pure]
    public function section_list_section_sort(): bool
    {
        return parent::check();
    }

    #[Pure] public function section_rating_hide(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure] public function content_tag_manage(User $user, Section $section): bool
    {
        return self::checkSection($user, $section);
    }

    #[Pure] public function trash_access(): bool
    {
        return parent::check();
    }

    #[Pure]
    public function section_create(User $user, Section $section): bool
    {
        return self::defaultPolicy($user, $section);
    }
}
