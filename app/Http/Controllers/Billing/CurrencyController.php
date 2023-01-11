<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingDiscount;
use App\Models\Currency;
use App\Models\User;
use App\Traits\Activity;
use Auth;
use Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class CurrencyController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Currency::class);
        $this->setUserActivity();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/currency/get_discounts Конвертирование валюты
     * @apiGroup Billing currency
     *
     * @apiParam {string} iso_code код валюты
     * @apiParam token Ключ пользователя
     */
    public function getDiscounts(Request $request)
    {
        $isoCode = $request->get('iso_code');
        if (!$isoCode) {
            return $this->error('Валюта не задана');
        }

        $currency = Currency::whereIsoCode($isoCode)->first();

        if (!$currency) {
            return $this->error('Валюта не найдена');
        }

        $discounts = $currency->discounts;

        if (count($discounts) > 0) {
            $discounts = $discounts->toArray();
            foreach ($discounts as &$discount) {
                $discount['points'] = $discount['points'] * $currency->points_value;
            }
        }

        return $this->success($discounts);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/currency/convert Конвертирование валюты
     * @apiGroup Billing currency
     *
     * @apiParam {string} from С какой валюты конвертировать (международный код)
     * @apiParam {Float} amount кол-во валюты
     * @apiParam token Ключ пользователя
     */
    public function convert(Request $request): JsonResponse
    {
        $from = $request->get('from');
        $amount = $request->get('amount');
        $currencyKey = 'currency_daily';

        $currencyDaily = Cache::get($currencyKey);

        if (!$currencyDaily || Redis::ttl('laravel:' . $currencyKey) < time() - 3600) {
            if ($jsonDaily = file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js')) {
                $jsonDaily = json_decode($jsonDaily, true);
                Cache::set($currencyKey, $jsonDaily, 3600);
            }
        } else {
            $jsonDaily = $currencyDaily;
        }

        if (!isset($jsonDaily['Valute'][$from])) {
            return $this->error('Такой валюты нет');
        }

        $rub = $jsonDaily['Valute'][$from]['Value'];
        $total = (int)$amount * $rub;

        $data = [
            'curency' => $jsonDaily['Valute'][$from],
            'amount' => $total
        ];

        return $this->success($data);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/currency/form Форма пополнения баланса
     * @apiGroup Billing currency
     */
    public function form()
    {
        $discounts = BillingDiscount::query()->orderBy('amount', 'asc')->get();
        $currencies = Currency::query()->orderBy('iso_code')->get();

        return $this->success(compact('discounts', 'currencies'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/currency/convert_to_points Конвертирование рублей и баллов
     * @apiGroup Billing currency
     *
     * @apiParam {Float} amount кол-во валюты или баллов
     * @apiParam {integer} from из баллов в поинты и наоборот (1 - из валюты в баллы, 2 - из баллов в валюту)
     * @apiParam {String} iso_code ISO код валюты
     */
    public function convertToPoints(Request $request): JsonResponse
    {
        $amount = $request->get('amount');
        $from = $request->get('from', 1);
        $isoCode = $request->get('iso_code');

        if (!$amount) {
            return $this->error('Кол-во рублей не задано');
        }

        if (!$isoCode) {
            return $this->error('Не задан ISO код валюты');
        }

        $currency = Currency::query()->whereIsoCode($isoCode)->first();

        if (!$currency) {
            return $this->error('Валюта не найдена');
        }

        $amountPercent = 0;

        $billingDiscount = BillingDiscount::where('amount', '<=', $amount)->whereCurrencyId($currency->id)
            ->orderBy('amount', 'desc')->first();

        if ($billingDiscount) {
            if ($from == 1) {
                $amountPercent = $amount / 100 * $billingDiscount->percent;
            } else {
                $amountPercent = (1 + $billingDiscount->percent / 100);
            }
        }

        if ($from == 1) {
            $result = round(($amount + $amountPercent) * $currency->points_value);
        } else {
            if (!$billingDiscount) {
                $amountPercent = 1;
            }
            $result = round(round($amount / $amountPercent) / $currency->points_value);
        }

        $data = [
            'amount' => $amount,
            'result' => $result,
            'from' => $from,
            'discount' => $billingDiscount
        ];

        return $this->success($data);
    }
}
