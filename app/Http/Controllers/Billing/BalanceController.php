<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingDiscount;
use App\Models\Currency;
use App\Models\UserOrder;
use App\Traits\Activity;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BalanceController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setBillingActivity(UserOrder::class);
        $this->setActionsExcluded(['add', 'update']);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @throws Exception
     * @api {POST} /api/balance/add Добавление баланса на счет пользователя
     * @apiGroup Billing balance
     *
     * @apiParam {Float} amount кол-во валюты
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} back_url URL успешной оплаты
     * @apiParam {string} iso_code Код валюты
     * @apiParam {Boolean} autorenew автоподписка на все сервисы и тарифы
     */
    public function add(Request $request)
    {
        $amount = $request->get('amount', 0);
        $autorenew = $request->get('autorenew', false);
        $backUrl = $request->get('back_url', route('balance.update'));
        $isoCode = $request->get('iso_code');
        $site = $this->getSite(main_domain(env('DOMAIN')));

        if (!$amount || (int)$amount <= 0) {
            return $this->error('Вы не ввели кол-во рублей либо сумма неверная');
        }

        if (!$isoCode) {
            return $this->error('Не задан ISO код валюты');
        }

        $description = 'Пополнение баланса на сайте ' . env('DOMAIN');

        $data = self::gatewaySberbank($amount, Auth::user(), $backUrl, $description, $isoCode);

        if (isset($data['errorMessage'])) {
            return $this->error($data['errorMessage']);
        } else {

            $currency = Currency::query()->whereIsoCode($isoCode)->first();

            if (!$currency) {
                return $this->error('Валюта не найдена');
            }

            $amountPercent = 0;

            $billingDiscount = BillingDiscount::query()->where('amount', '<=', $amount)->whereCurrencyId($currency->id)
                ->orderBy('amount', 'desc')->first();

            if ($billingDiscount) {
                $amountPercent = $amount / 100 * $billingDiscount->percent;
            }

            $points = round(($amount + $amountPercent) * $currency->points_value);

            $orderData = [
                'user_id' => Auth::user()->id,
                'internal_order_id' => $data['uuid'],
                'merchant_order_id' => $data['orderId'],
                'price' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_ADD_AMOUNT] . $amount,
                'points' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_ADD_AMOUNT] . $points
            ];

            $userOrder = UserOrder::query()->firstOrCreate($orderData,
                $orderData + [
                    'description' => $description,
                    'payment_type' => UserOrder::TYPE_ADD_AMOUNT,
                    'site_id' => $site->id,
                    'billing_disсount_id' => $billingDiscount?->id
                ]);

            Auth::user()->update(['autorenew' => $autorenew]);

            $this->setIsSystem(false);
            $this->setParams($userOrder->toArray());
            $this->createActivity();

            return $this->success($data);
        }
    }

    public function update(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
