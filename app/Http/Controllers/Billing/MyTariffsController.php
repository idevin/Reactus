<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingSubscription;
use App\Traits\Activity;
use Auth;
use Illuminate\Http\JsonResponse;

class MyTariffsController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setBillingActivity();
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/profile/tariffs Тарифы и сервисы, заказы
     * @apiGroup Billing tariffs
     *
     */
    public function index()
    {
        $user = Auth::user();

        $tariffs = BillingSubscription::query()->byUser($user)->with(['site', 'services'])->get();

        if (empty($tariffs)) {
            return $this->error('Тарифов пока не найдено');
        }

        return $this->success(compact('tariffs'));
    }
}
