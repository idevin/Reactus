<?php namespace App\Policies;

use JetBrains\PhpStorm\Pure;

/**
 * Class ProfilePolicy
 * @package App\Policies
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class ProfilePolicy extends CommonPolicy
{
    #[Pure] public function disk_space_add(): bool
    {
        return parent::check();
    }

    #[Pure] public static function check(): bool
    {
        return parent::check();
    }
}