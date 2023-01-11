<?php namespace App\Policies;
use App\Models\User;
use JetBrains\PhpStorm\Pure;

/**
 * Class AnnouncementPolicy
 */
class AnnouncementPolicy extends CommonPolicy
{
    #[Pure] public function announcement_create(): bool
    {
        return parent::check();
    }
}