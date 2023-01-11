<?php namespace App\Policies;

use JetBrains\PhpStorm\Pure;

/**
 * Class CompetitiveAdvantagesPolicy
 */
class CompetitiveAdvantagesPolicy extends CommonPolicy
{

    #[Pure] public function competitive_advantages_edit(): bool
    {
        return parent::check();
    }
}