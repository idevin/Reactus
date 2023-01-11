<?php namespace App\Policies;

use JetBrains\PhpStorm\Pure;

/**
 * Class GenealogicalTreePolicy
 */
class GenealogicalTreePolicy extends CommonPolicy
{
    #[Pure] public function treeview_card_manage(): bool
    {
        return parent::check();
    }
}