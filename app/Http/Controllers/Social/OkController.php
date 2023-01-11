<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;

class OkController extends Controller implements Social
{
    use Site;
    use Socials;

    public function getConfig()
    {
        return config('services.odnoklassniki');
    }

    public function getProvider()
    {
        return 'odnoklassniki';
    }

    public function getScopes()
    {
        return ['VALUABLE_ACCESS', 'PHOTO_CONTENT', 'GET_EMAIL'];
    }
}
