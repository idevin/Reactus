<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingService;
use App\Models\BillingSubscriptionService;
use App\Models\User;
use App\Models\UserOrder;
use App\Traits\Activity;
use App\Traits\TariffAndService;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Webpatser\Uuid\Uuid;

class ServicesController extends Controller
{
    use TariffAndService;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(BillingService::class);
        $this->setUserActivity();
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/services Данные для сервисов
     * @apiGroup Billing services
     *
     */
    public function index(): JsonResponse
    {
        $services = BillingService::query()->orderBy('name', 'asc')->get();

        return $this->success($services);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/services/info Инфо о сервисе перед оплатой
     * @apiGroup Billing
     * @apiParam {integer} service_id  ID сервиса
     * @apiParam {json} options опции сервиса [{id: N, count: M}]
     */
    public function info(Request $request): JsonResponse
    {
        $serviceId = $request->get('service_id');
        $options = $request->get('options');

        if (!$serviceId) {
            return $this->error('Сервис не найден', ['code' => BillingService::$serviceNotFound]);
        }

        $service = BillingService::query()->find($serviceId);

        if (!$service) {
            return $this->error("Сервис не найден", ['code' => BillingService::$serviceNotFound]);
        }

        if (!empty($options)) {
            $options = BillingSubscriptionService::cleanOptions($options);
        }

        $dateStart = Carbon::now();
        $dateEnd = Carbon::now()->endOfMonth();
        $diffDays = $dateEnd->diffInDays($dateStart);

        if ($diffDays == 0) {
            $diffDays = 1;
        }

        $totalPriceInDays = $service->totalPriceInDays($diffDays);

        return $this->success([
            'service' => $service,
            'date_start' => $dateStart->toDateTimeString(),
            'date_end' => $dateEnd->toDateTimeString(),
            'days_end_month' => $diffDays,
            'total_price_days' => $totalPriceInDays,
            'total_price' => $service->totalPrice($options),
            'first_date_monthly' => $dateEnd->addDay()->startOfDay()->toDateTimeString(),
            'options' => $service->options
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/services/pay Оплата сервиса
     * @apiGroup Billing
     *
     * @apiParam {integer} service_id  ID сервиса
     * @apiParam {json} options опции сервиса [{id: N, count: M}]
     * @apiParam {Boolean} autorenew автопродление сервиса
     * @apiParam {string} token Token пользователя
     *
     */
    public function pay(Request $request)
    {
        $serviceId = $request->get('service_id');
        $autorenew = $request->get('autorenew', 0);
        $options = $request->get('options');

        $site = get_site();
        $user = Auth::user();

        $exists = BillingSubscriptionService::whereSiteId($site->id)->whereUserId($user->id)->first();

        if ($exists) {
            return $this->error('Вы уже подключили сервис');
        }

        $options = json_decode($options, true);

        if (!empty($options)) {
            $options = BillingSubscriptionService::cleanOptions($options);
        }

        if (!$serviceId) {
            return $this->error('Не задан ID сервиса');
        }

        $service = BillingService::find($serviceId);

        if (!$service) {
            return $this->error("Сервис не найден", ['code' => BillingService::$serviceNotFound]);
        }

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('SERVICE PAY ONCE: ' . $service->pay_once);
        }

        $price = $service->totalPrice($options);
        $endsAt = $service->endsAt();

        if ($price > $user->balance) {
            return $this->error('Не достаточно баллов', ['code' => BillingService::$notEnoughBallance]);
        }

        $description = 'Оплата Сервиса "' . $service->name . '" на сайте ' . env('DOMAIN');
        $uuid = str_replace('-', '', Uuid::generate(5, time(), Uuid::NS_DNS)->string);

        $price = round($price);

        UserOrder::firstOrCreate([
            'site_id' => $site->id,
            'user_id' => $user->id,
            'internal_order_id' => $uuid,
            'merchant_order_id' => (int)time(),
            'price' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_PAY_SERVICE] . $price,
            'points' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_PAY_SERVICE] . $price,
            'description' => $description,
            'paid' => 1,
            'payment_type' => UserOrder::TYPE_PAY_SERVICE
        ]);

        $now = Carbon::now();

        $data = [
            'user_id' => $user->id,
            'autorenew' => $autorenew,
            'created_at' => $now,
            'ends_at' => $endsAt,
            'site_id' => $site->id,
            'billing_service_id' => $service->id,
            'pay_once' => $service->pay_once,
            'detached' => 1,
            'options' => $options,
            'next_write_off' => $now->addMonth()->startOfMonth()
        ];

        $subscription = BillingSubscriptionService::firstOrCreate($data);

        $user->balance -= $price;
        $user->save();

        self::syncServicePermissions($service->id, $user);

        return $this->success($subscription);
    }
}
