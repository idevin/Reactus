<?php

use App\Models\Menu;
use App\Models\Slider;

return [
    'entities' => [
        'slider' => Slider::class, // for simple sorting (entityName => entityModel) or
        'menu' => Menu::class
    ],
];
