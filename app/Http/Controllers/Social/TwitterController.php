<?php

namespace App\Http\Controllers\Social;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Traits\Site;
use App\Traits\Socials;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class TwitterController extends Controller implements Social
{
    use Site;
    use Socials;

    /**
     * @return Repository|Application|mixed
     */
    public function getConfig()
    {
        return config('services.twitter');
    }

    public function getProvider(): string
    {
        return 'twitter';
    }

    public function getScopes(): array
    {
        return [];
    }
}
