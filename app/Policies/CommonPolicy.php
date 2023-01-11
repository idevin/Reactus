<?php

namespace App\Policies;

use App\Models\Model;
use App\Models\User;
use App\Traits\Site;

class CommonPolicy
{
    use Site;

    public static string|null $ability = null;
    public static array|null|Model $permission = null;

    public static function check(): bool
    {
        $editOwn = self::$permission->pivot->own == 1;
        $editOwnReversed = self::$permission->pivot->other == 1;

        if ($editOwn || $editOwnReversed) {
            return true;
        }

        return false;
    }

    public function before(User $user, string $ability)
    {
        $this->setAbility($ability);
        $this->setPermission($user, self::$ability);

        $siteUser = null;

        if ($user->superadmin == 1) {
            return true;
        }

        if (!empty($site)) {
            if (count($site->siteUsers) > 0) {
                $siteUser = $site->siteUsers->filter(function ($siteUser) use ($user) {
                    return $siteUser->user_id === $user->id;
                })->first();
            }

            if ($siteUser) {
                return true;
            }

            if ($site->user_id === $user->id) {
                return true;
            }
        }
    }

    public function setAbility(string $ability)
    {
        self::$ability = $ability;
    }

    /**
     * @param User $user
     * @param $ability
     */
    public function setPermission(User $user, $ability)
    {
        self::$permission = $user->hasPermission($ability);
    }
}