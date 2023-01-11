<?php

namespace App\Http\Controllers\Billing;

use App\Cacher\Collection\BillingTariffCollection;
use App\Cacher\Item\BillingTariffItem;
use App\Http\Controllers\Controller;
use App\Models\BillingDiscount;
use App\Models\BillingSubscription;
use App\Models\BillingSubscriptionService;
use App\Models\BillingTariff;
use App\Models\User;
use App\Models\UserOrder;
use App\Traits\Activity;
use App\Traits\TariffAndService;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Webpatser\Uuid\Uuid;

class SubscriptionServicesController extends Controller
{
    use TariffAndService;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setBillingActivity(BillingSubscription::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/subscription_services/delete Удаление сервиса
     * @apiGroup Billing subscriptions
     * @apiParam {integer} id ID сервиса
     * @apiParam {integer} delete_forever  Мягкое удаление - 0, полное удаление - 1
     * @apiParam {string} token Token пользователя
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->get('id');
        $deleteForever = $request->get('delete_forever');

        if (!$id) {
            return $this->error('Сервис не найден');
        }

        if (!isset($deleteForever) || !in_array((int)$deleteForever, [0, 1])) {
            return $this->error('Флаг удаления не найден');
        }

        $subscription = BillingSubscriptionService::query()->withTrashed()->find($id);

        if (!$subscription) {
            return $this->error("Сервис не найден");
        }

        $this->deleteSubscription($deleteForever, $subscription);

        return $this->success();
    }
}
