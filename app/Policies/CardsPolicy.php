<?php namespace App\Policies;

use JetBrains\PhpStorm\Pure;

/**
 * Class CardsPolicy
 * @package App\Policies
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class CardsPolicy extends CommonPolicy
{
    #[Pure]
    public function card_create(): bool
    {
        return parent::check();
    }

    #[Pure]
    public static function check(): bool
    {
        return parent::check();
    }

    public function card_edit()
    {
        return parent::check();
    }
}