<?php

namespace App\Policies;

use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class SitePolicy extends CommonPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    #[Pure] public function site_create(User $user, Site $site): bool
    {
        $ownSite = false;

        if ($site->user_id == $user->id) {
            $ownSite = true;
        } else {
            foreach ($site->siteUsers as $siteUser) {
                if ($user->id == $siteUser->user_id) {
                    $ownSite = true;
                    break;
                }
            }
        }

        $editOwn = self::$permission['own'] == 1 && $ownSite == true;
        $editOwnReversed = self::$permission['other'] == 1 && $ownSite == false;

        if ($editOwn || $editOwnReversed) {
            return true;
        }
    }

    public static function checkSite(User $user, Site $site): bool
    {
        $ownSite = false;

        if ($site->user_id == $user->id) {
            $ownSite = true;
        } else {
            foreach ($site->siteUsers as $siteUser) {
                if ($user->id == $siteUser->user_id) {
                    $ownSite = true;
                    break;
                }
            }
        }

        if(!is_array(self::$permission)) {
            $editOwn = self::$permission->pivot->own == 1 && $ownSite == true;
            $editOwnReversed = self::$permission->pivot->other == 1 && $ownSite == false;
        } else {
            $editOwn = self::$permission['own'] == 1 && $ownSite == true;
            $editOwnReversed = self::$permission['other'] == 1 && $ownSite == false;
        }

        if ($editOwn || $editOwnReversed) {
            return true;
        }

        return false;
    }

    public function site_access(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_contact_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_view(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_look_background_image_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_settings_access(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_slogan_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_name_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_look_logo_image_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_menu_horizontal_manage(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_layout_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_lines_manage(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_look_edit(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function content_tag_manage(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }

    public function site_feedback_get(User $user, Site $site): bool
    {
        return self::checkSite($user, $site);
    }
}
