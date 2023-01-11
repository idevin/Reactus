<?php

namespace App\Http\Controllers;

use App\Models\NeoCard;
use App\Models\NeoUserCatalog;
use App\Traits\Activity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ObjectsController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function catalog(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function catalogs(): View|Factory|Redirector|RedirectResponse|Application
    {
        $user = \Auth::user();

        if (!$user) {
            return redirect('/403', 403);
        }

        $permission = $user->hasPermission('catalog_view');

        if (!$permission) {
            return redirect('/404', 404);
        }

        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function catalogFrontView($url = null, $id = null): View|Factory|Redirector|RedirectResponse|Application
    {
        $catalog = NeoUserCatalog::whereAlias($url)->whereId($id)->first();

        if (!$catalog) {
            return redirect('/');
        }

        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function catalogView($url = null, $id = null): View|Factory|Redirector|RedirectResponse|Application
    {
        if (!\Auth::user()) {
            return redirect('/');
        }
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function card(string $alias = null, int $id = null): View|Factory|Redirector|RedirectResponse|Application
    {
        $card = NeoCard::query()->whereSeoSlug($alias)->whereId($id)->first();

        if (!$card) {
            return redirect('/404');
        }

        $this->getMeta(__METHOD__, $card);

        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function cards()
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
