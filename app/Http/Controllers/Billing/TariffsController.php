<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingDiscount;
use App\Models\BillingService;
use App\Models\BillingServiceOptions;
use App\Models\BillingSubscription;
use App\Models\BillingSubscriptionService;
use App\Models\BillingTariff;
use App\Models\User;
use App\Models\UserOrder;
use App\Traits\Activity;
use App\Traits\TariffAndService;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TariffsController extends Controller
{
    use TariffAndService;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setBillingActivity();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/tariffs Данные для тарифов
     * @apiParam {string} token Token пользователя
     * @apiGroup Billing tariffs
     */
    public function index(Request $request)
    {
        $tariffs = BillingTariff::query()->with(['services' => function ($query) {
            $query->with('options');
        }])->orderBy('id', 'desc')->get();
        if ($tariffs->isEmpty()) {
            return $this->error("Тарифы на найдены", ['code' => BillingTariff::$tariffNotFound]);
        }

        $token = $request->get('token');
        $subscriptions = [];
        $subscriptionServices = [];

        $currentServices = [];
        $currentSubscriptions = [];

        $allServices = collect();
        $tariffs->map(function ($tariff) use (&$allServices) {
            foreach ($tariff->services as $service) {
                $allServices[$service->id] = $service;
            }
        });

        $allServices = $allServices->unique('id');

        if ($token) {
            $user = User::query()->whereAuthToken($token)->active()->first();
            if ($user) {
                $subscriptions = BillingSubscription::query()->with(['services', 'tariff' => function ($query) {
                    return $query->with(['services']);
                }])->byUser($user)->get();

                if (count($subscriptions) > 0) {
                    $totalPrice = 0;
                    $excepted = $subscriptions->map(function ($subscription) use (&$currentSubscriptions, &$totalPrice) {

                        $totalPrice += $subscription->price;
                        $currentSubscriptions['names'][] = $subscription->tariff->name;
                        $currentSubscriptions['ends_at'][] = $subscription->ends_at;

                        return $subscription['billing_tariff_id'];
                    });

                    $currentSubscriptions['ends_at'] = min($currentSubscriptions['ends_at']);
                    $currentSubscriptions['total_price'] = $totalPrice;

                    $tariffs = $tariffs->except($excepted->toArray());
                }

                $subscriptionServices = BillingSubscriptionService::query()->with('service')->byUser($user)->get();

                if (count($subscriptionServices) > 0) {
                    $totalPrice = 0;
                    $excepted = $subscriptionServices->map(function ($service) use (&$currentServices, &$totalPrice) {

                        $totalPrice += $service->price;
                        $currentServices['names'][] = $service->title;
                        $currentServices['ends_at'][] = $service->next_write_off;

                        return $service['billing_service_id'];
                    });

                    $currentServices['ends_at'] = min($currentServices['ends_at']);
                    $currentServices['total_price'] = $totalPrice;

                    $allServices = $allServices->except($excepted->toArray());
                }
            }
        }

        $allServices = $allServices->values();

        return $this->success([
            'tariffs' => $tariffs,
            'services' => $allServices,
            'subscriptions' => $subscriptions,
            'subscription_services' => $subscriptionServices,
            'current_subscriptions' => $currentSubscriptions,
            'current_services' => $currentServices,
            'increment_types' => BillingServiceOptions::$types
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {GET} /api/tariffs/info Инфо о тарифе перед оплатой
     * @apiGroup Billing tariffs
     * @apiParam {integer} tariff_id  ID тарифа
     * @apiParam {string} token Token пользователя
     *
     */
    public function info(Request $request)
    {
        $tariffId = $request->get('tariff_id');

        if (!$tariffId) {
            return $this->error('Тариф не найден', ['code' => BillingTariff::$tariffNotFound]);
        }

        $tariff = BillingTariff::query()->with(['services' => function ($query) {
            $query->with('options');
        }])->find($tariffId);

        if (!$tariff) {
            return $this->error("Тариф не найден", ['code' => BillingTariff::$tariffNotFound]);
        }

        if (count($tariff->services) == 0) {
            return $this->error("Сервисы не найдены", ['code' => BillingService::$serviceNotFound]);
        }

        $dateStart = Carbon::now();

        $endsAt = BillingSubscription::endsAt($tariff);
        $dateEnd = new Carbon($endsAt);

        $diffDays = $dateEnd->diffInDays($dateStart);

        if ($diffDays == 0) {
            $diffDays = 1;
        }

        $totalPriceInDays = $tariff->totalPriceInDays($diffDays);
        $totalPrice = $tariff->totalPrice();

        if (Auth::user()->balance < $totalPriceInDays) {
            return $this->error('У вас не достаточно средств для оплаты тарифа',
                ['code' => BillingService::$notEnoughBallance]);
        }

        return $this->success([
            'tariff' => $tariff,
            'date_start' => $dateStart->toDateTimeString(),
            'date_end' => $dateEnd->toDateTimeString(),
            'days_end_month' => $diffDays,
            'total_price_days' => $totalPriceInDays,
            'total_price' => $totalPrice,
            'first_date_monthly' => $dateEnd->addDay()->startOfDay()->toDateTimeString()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/tariffs/pay Оплата тарифа
     * @apiGroup Billing tariffs
     * @apiParam {integer} tariff_id  ID тарифа
     * @apiParam {Boolean} autorenew автопродление тарифа
     * @apiParam {string} token Token пользователя
     */
    public function pay(Request $request)
    {
        $tariffId = $request->get('tariff_id');
        $autorenew = $request->get('autorenew', 0);
        $site = $this->getSite(env('DOMAIN'));
        $user = Auth::user();

        if (!$tariffId) {
            return $this->error('Не задан тариф');
        }

        $tariff = BillingTariff::query()->with('services')->find($tariffId);

        if (!$tariff) {
            return $this->error("Тариф не найден", ['code' => BillingTariff::$tariffNotFound]);
        }

        $subscription = BillingSubscription::query()->byUser($user)->bySite($site->id)
            ->whereBillingTariffId($tariff->id)->first();

        if ($subscription) {
            return $this->error('Вы уже подписаны на этот тариф');
        }

        if (count($tariff->services) == 0) {
            return $this->error("Сервисы не найдены", ['code' => BillingService::$serviceNotFound]);
        }

        $dateStart = Carbon::now();

        $endsAt = BillingSubscription::endsAt($tariff);

        $dateEnd = new Carbon($endsAt);

        $diffDays = $dateEnd->diffInDays($dateStart);
        $totalPriceInDays = $tariff->totalPriceInDays($diffDays);
        $totalPrice = $tariff->totalPrice();

        if (Auth::user()->balance < $totalPriceInDays) {
            return $this->error('У вас не достаточно средств', ['code' => BillingService::$notEnoughBallance]);
        }

        $trial = null;

        /**
         * @todo pay_once учитывать при подсчете суммы
         */
        $data = [
            'autorenew' => $autorenew,
            'created_at' => Carbon::now(),
            'trial_ends_at' => $trial,
            'ends_at' => BillingSubscription::endsAt($tariff),
            'user_id' => $user->id,
            'site_id' => $site->id,
            'billing_tariff_id' => $tariff->id,
            'price' => $totalPrice
        ];

        $subscription = BillingSubscription::firstOrCreate($data);

        foreach ($tariff->services as $service) {
            $nextWriteOff = $service->getNextWriteOff($diffDays);

            if (!$nextWriteOff) {
                return $this->error('Невозможно определить период следующего списания');
            }

            $options = null;
            if (count($service->options) > 0) {
                foreach ($service->options as $option) {
                    $options[] = ['id' => $option->id, 'count' => 1];
                }
            }

            BillingSubscriptionService::query()->firstOrCreate([
                'user_id' => $user->id,
                'billing_service_id' => $service->id,
                'autorenew' => $autorenew,
                'ends_at' => $service->endsAt(),
                'pay_once' => $service->pay_once,
                'site_id' => $site->id,
                'billing_subscription_id' => $subscription->id,
                'next_write_off' => $nextWriteOff,
                'options' => $options
            ]);
        }

        $user->balance -= $totalPriceInDays;
        $user->save();

        /** @var \App\Models\User $user */
        self::syncTariffPermissions($tariff['id'], $user);

        $amountPercent = 0;

        $billingDiscount = BillingDiscount::where('amount', '<=', $totalPriceInDays)->orderBy('amount', 'desc')->first();

        if ($billingDiscount) {
            $amountPercent = $totalPriceInDays / 100 * $billingDiscount->percent;
        }

        $result = round(($totalPriceInDays + $amountPercent) / config('billing.currency.point'));

        UserOrder::query()->firstOrCreate([
            'internal_order_id' => $subscription->id,
            'merchant_order_id' => $subscription->id,
            'site_id' => $site->id,
            'user_id' => $user->id,
            'paid' => 1,
            'description' => 'Оплата пакета услуг' . ' "' . $tariff->name . '"',
            'price' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_PAY_TARIFF] . $totalPriceInDays,
            'points' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_PAY_TARIFF] . $result,
            'payment_type' => UserOrder::TYPE_PAY_TARIFF
        ]);

        return $this->success(compact('subscription'));
    }
}
