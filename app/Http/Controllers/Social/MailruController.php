<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class MailruController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.mailru');
    }

    public function getProvider()
    {
        return 'mailru';
    }

    public function getScopes()
    {
        return [];
    }
}
