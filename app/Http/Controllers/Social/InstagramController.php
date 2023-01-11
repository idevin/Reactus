<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class InstagramController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.instagram');
    }

    public function getProvider()
    {
        return 'instagram';
    }

    public function getScopes()
    {
        return [];
    }
}
