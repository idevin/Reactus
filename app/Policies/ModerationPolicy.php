<?php namespace App\Policies;

use JetBrains\PhpStorm\Pure;

/**
 * Class ModerationPolicy
 */
class ModerationPolicy extends CommonPolicy
{
    #[Pure] public function mass_deleting(): bool
    {
        return parent::check();
    }
}