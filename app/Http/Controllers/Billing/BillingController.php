<?php

namespace App\Http\Controllers\Billing;

use App\Cacher\Collection\BillingDiscountCollection;
use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use App\Traits\Activity;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setBillingActivity(UserOrder::class);
        $this->setIsSystem(true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/billing/history История оплат
     * @apiGroup Billing history
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} term Строка для поиска по описанию
     * @apiParam {integer} page Страница для пагинации
     * @apiParam {json} dates массив дат в json формате
     * @apiParam {string} field Сортировка по полю (из sort_options)
     * @apiParam {string} order Направление сортировки (из sort_directions)
     * @apiParam {integer} site_id Выборка по сайту (обьект sites)
     */
    public function history(Request $request): JsonResponse
    {
        $request = $request->all();
        $page = 1;
        $limit = 10;
        $term = null;
        $defaultField = array_keys(UserOrder::SORT_OPTIONS)[0];
        $defaultOrder = UserOrder::SORT_DIRECTIONS[1];
        $siteId = null;
        $defaultDates = "[]";

        $userOrders = UserOrder::query()->whereUserId(Auth::user()->id);

        if (isset($request['page'])) {
            $page = (int)$request['page'];
        }

        $dates = $defaultDates;
        if (isset($request['dates'])) {
            $dates = $request['dates'];
        }

        if (isset($request['site_id'])) {
            $siteId = (int)$request['site_id'];
            $userOrders = $userOrders->bySite($siteId);
        }

        $order = $defaultOrder;
        if (isset($request['order']) && in_array($request['order'], UserOrder::SORT_DIRECTIONS)) {
            $order = $request['order'];
        }

        $field = $defaultField;
        if (isset($request['field']) && in_array($request['field'], array_keys(UserOrder::SORT_OPTIONS))) {
            $field = $request['field'];
        }

        $userOrders = $userOrders->orderBy($field, $order);

        if (isset($request['limit']) && in_array((int)$request['limit'], UserOrder::$limits)) {
            $limit = (int)$request['limit'];
        }

        if (isset($request['term']) && mb_strlen($request['term']) >= 3) {
            $term = strip_tags($request['term']);
            $userOrders = $userOrders->where('description', 'LIKE', '%' . $term . '%');
        }

        $dateTo = null;
        $dateFrom = null;
        $dates = json_decode($dates);

        if (is_array($dates) && count($dates) == 2) {
            try {
                $dateFrom = new Carbon($dates[0]);
            } catch (Exception $e) {
                $dateFrom = null;
            }

            try {
                $dateTo = new Carbon($dates[1]);
            } catch (Exception $e) {
                $dateTo = null;
            }
        }

        if ($dateFrom && $dateTo) {
            $dates = [
                $dateFrom, $dateTo
            ];
        } else {
            $dates = [];
        }

        if (!empty($dates)) {
            $userOrders = $userOrders->whereBetween('created_at', $dates);
        }

        $userOrders = $userOrders->paginate($limit, ['*']);

        $userOrders->appends([
            'field' => $field,
            'order' => $order,
            'limit' => $limit,
            'term' => $term,
            'page' => $page,
            'site_id' => $siteId,
            'dates' => $dates
        ]);

        return $this->success([
            'orders' => $userOrders,
            'total_amount' => UserOrder::totalAmount(Auth::user()->id),
            'limits' => UserOrder::$limits,
            'sites' => UserOrder::query()->sites(Auth::user()->id),
            'sort_options' => UserOrder::SORT_OPTIONS,
            'sort_directions' => UserOrder::SORT_DIRECTIONS
        ]);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/discount Данные скидок
     * @apiGroup Billing dicounts
     */
    public function discount()
    {
        $obBillingDiscountCollection = BillingDiscountCollection::make()->allRecord();
        if ($obBillingDiscountCollection->isEmpty()) {
            return $this->error("Records not found");
        }

        return $this->success($obBillingDiscountCollection->forResponse());
    }

}
