<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Traits\Activity;

class ModerateController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function index()
    {
        \Breadcrumbs::register('moderate.index', function ($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Пул администраторов', route('moderate.index'));
        });

        return view(theme('moderate.index'));
    }

}