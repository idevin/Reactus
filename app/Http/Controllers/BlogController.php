<?php

namespace App\Http\Controllers;

use App\Models\BlogSite;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Site;
use App\Traits\Site as SiteTrait;

class BlogController extends Controller
{
    use SiteTrait;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(BlogSite::class);
    }

    public function articles()
    {
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('ssr'));
    }

    public function articleShow($user, $title, $id)
    {
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('ssr'));
    }

    public function sectionShow($user, $title, $id)
    {
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('ssr'));
    }

    public function sections()
    {
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('ssr'));
    }
}