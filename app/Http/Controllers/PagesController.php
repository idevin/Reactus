<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Traits\Activity;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class PagesController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Page::class);
        $this->setUserActivity();
    }

    public function index(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $this->getMeta(__METHOD__, get_site());

        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    /**
     * @param $slug
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show($slug, $id): Factory|Redirector|View|RedirectResponse
    {
        $page = Page::whereSlug($slug)->whereId($id)->first();

        if (!$page) {
            return redirect('/404');
        }

        $this->getMeta(__METHOD__, $page);

        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
