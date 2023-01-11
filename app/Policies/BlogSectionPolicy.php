<?php

namespace App\Policies;

use App\Models\BlogSection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class BlogSectionPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    #[Pure] public function section_edit(User $user, BlogSection $section): bool
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function section_delete(User $user, BlogSection $section): bool
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function section_hide(User $user, BlogSection $section): bool
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function section_move(User $user, BlogSection $section): bool
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function section_view(User $user, BlogSection $section)
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function section_list_article_author_hide(User $user, BlogSection $section)
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function section_tag_hide(User $user, BlogSection $section)
    {

        return SectionPolicy::defaultPolicy($user, $section);
    }

    #[Pure] public function section_list_section_sort(): bool
    {
        return parent::check();
    }

    #[Pure] public function section_rating_hide(User $user, BlogSection $section): bool
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function content_tag_manage(User $user, BlogSection $section): bool
    {
        return SectionPolicy::checkSection($user, $section);
    }

    #[Pure] public function trash_access(): bool
    {
        return parent::check();
    }

    #[Pure]
    public function section_create(User $user, BlogSection $section): bool
    {
        return SectionPolicy::defaultPolicy($user, $section);
    }
}
