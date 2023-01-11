<?php

namespace App\Http\Controllers;

use App\Traits\Activity;

class AboutController extends Controller
{
    use \App\Traits\Site;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function index()
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}