<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class VkController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.vkontakte');
    }

    public function getProvider()
    {
        return 'vkontakte';
    }

    public function getScopes()
    {
        return ['offline', 'email'];
    }
}
