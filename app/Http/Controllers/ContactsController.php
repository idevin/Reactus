<?php

namespace App\Http\Controllers;

use App\Traits\Activity;
use App\Traits\Site;
use Illuminate\Routing\Controller as BaseController;

class ContactsController extends BaseController
{
    use Site;
    use Activity;

    public function __construct()
    {
        $this->setSiteUserActivity(Site::class);
    }

    /**
     * @return string
     */
    public function index()
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}