<?php namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

/**
 * Class CatalogPolicy
 * @package App\Policies
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class CatalogPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    public function section_add_catalog()
    {
        return parent::check();
    }

    #[Pure]
    public static function check(): bool
    {
        return parent::check();
    }

    public function mainpage_add_catalog()
    {
        return parent::check();
    }
}