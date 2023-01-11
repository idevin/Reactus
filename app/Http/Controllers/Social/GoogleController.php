<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class GoogleController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.google');
    }

    public function getProvider()
    {
        return 'google';
    }

    public function getScopes()
    {
        return ['profile', 'email'];
    }
}
