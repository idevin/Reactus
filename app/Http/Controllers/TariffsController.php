<?php

namespace App\Http\Controllers;

use App\Models\BillingTariff;
use App\Traits\Activity;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TariffsController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(BillingTariff::class);
    }

    /**
     * @return Factory|View
     */
    public function subscribe()
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
