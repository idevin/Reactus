<?php

namespace App\Http\Controllers;

use App\Models\BillingService;
use App\Traits\Activity;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

class BillingController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(BillingService::class);
    }

    /**
     * @return Factory|View
     */
    public function balance(): Factory|View
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function history(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function tariffs(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function services(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function projects(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function dashboard(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function updateBalance(Request $request): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
