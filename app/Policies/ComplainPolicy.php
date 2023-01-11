<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ComplainPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function __construct()
    {
        //
    }
}
