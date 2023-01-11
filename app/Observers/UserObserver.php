<?php

namespace App\Observers;

//use Illuminate\Foundation\Auth\User;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

/**
 * User observer
 */
class UserObserver
{
    /**
     * @param User $user
     */
    public function saved(User $user)
    {
        $this->deleted($user);

        Cache::remember("user.{$user->id}", 360, function () use ($user) {
            return $user;
        });
    }

    /**
     * @param User $user
     */
    public function deleted(User $user)
    {
        Cache::forget("user.{$user->id}");
    }

    /**
     * @param User $user
     */
    public function restored(User $user)
    {
        Cache::put("user.{$user->id}", $user, 360);
    }

    /**
     * @param User $user
     */
    public function retrieved(User $user)
    {
        Cache::add("user.{$user->id}", $user, 360);
    }
}