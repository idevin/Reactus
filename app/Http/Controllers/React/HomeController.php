<?php

namespace App\Http\Controllers\React;

use App\Http\Controllers\Controller;
use App\Models\Community;

class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $site = $this->getSite(env('DOMAIN'));

        if (\Auth::user()) {
            return redirect(route('home'));
        }

        return view(theme('react.layout'), ['permissions' => permissions()]);
    }
}
