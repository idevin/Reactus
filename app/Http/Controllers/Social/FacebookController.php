<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class FacebookController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.facebook');
    }

    public function getProvider()
    {
        return 'facebook';
    }

    public function getScopes()
    {
        return ['email'];
    }
}
