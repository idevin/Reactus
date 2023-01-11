<?php

namespace App\Utils;

use Illuminate\Support\Str;
use Route;

class SpoofRoute
{
    public static function action($name, $action, $noId = false, $method = 'post')
    {
        $className = Str::camel($name);

        if ($noId == false) {
            $string = '/{' . $name . '}/';
        } else {
            $string = '/';
        }

        return Route::$method($name . $string . $action, 'Cms\\' . ucfirst($className) . 'Controller@' . $action)
            ->name($name . '.' . $action);
    }
}