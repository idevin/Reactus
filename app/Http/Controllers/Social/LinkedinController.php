<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class LinkedinController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.linkedin');
    }

    public function getProvider()
    {
        return 'linkedin';
    }

    public function getScopes()
    {
        return [];
    }
}
