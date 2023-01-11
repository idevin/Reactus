<?php namespace App\Policies;

use JetBrains\PhpStorm\Pure;

/**
 * Class GaleryPolicy
 * @package App\Policies
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class GalleryPolicy extends CommonPolicy
{
    #[Pure]
    public function filemanager_access(): bool
    {
        return parent::check();
    }


    public function cropper_edit()
    {
        return parent::check();
    }
}