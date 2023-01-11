<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class YandexController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.yandex');
    }

    public function getProvider()
    {
        return 'yandex';
    }

    public function getScopes()
    {
        return [];
    }
}
