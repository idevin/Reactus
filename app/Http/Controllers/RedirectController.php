<?php

namespace App\Http\Controllers;

use App\Traits\Activity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends BaseController
{
    use DispatchesJobs, ValidatesRequests, Activity;

    public function __construct()
    {
        $this->setSiteUserActivity();
    }

    public function index(Request $request): bool|Redirector|RedirectResponse|Application
    {
        $url = $request->get('url');

        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return redirect($url, 301);
        } else {
            return false;
        }
    }
}
