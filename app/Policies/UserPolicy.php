<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class UserPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    #[Pure] public function profile_access(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_avatar_edit(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_birthday_edit(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_name_edit(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_password_edit(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_email_edit(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_tel_edit(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function profile_view(User $user): bool
    {
        return self::check();
    }

    #[Pure] public function catalog_view(User $user): bool
    {
        return self::check();
    }
}
