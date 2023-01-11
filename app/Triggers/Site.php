<?php

namespace App\Triggers;


use JetBrains\PhpStorm\NoReturn;

class Site
{
    /**
     * @param $user
     */
    #[NoReturn] public function create($user)
    {
        /**
         * @todo need to refactor sync of permissions
         */
//        $permissions = $user->permissions->keyBy('name')->forget('site_create');
//        $user->permissions()->sync($permissions);
    }
}