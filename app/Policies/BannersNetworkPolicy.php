<?php namespace App\Policies;
use App\Models\User;
use JetBrains\PhpStorm\Pure;

/**
 * Class BannersNetworkPolicy
 */
class BannersNetworkPolicy extends CommonPolicy
{
    #[Pure] public function getting_ranking(): bool
    {
        return parent::check();
    }
}