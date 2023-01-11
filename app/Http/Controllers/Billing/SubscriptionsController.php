<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingSubscription;
use App\Traits\Activity;
use App\Traits\TariffAndService;
use Auth;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionsController extends Controller
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
     * @api {POST} /api/subscriptions/delete Удаление подписки с сервисами
     * @apiGroup Billing subscriptions
     * @apiParam {integer} id ID подписки
     * @apiParam {integer} delete_forever  Мягкое удаление - 0, полное удаление - 1
     * @apiParam {string} token Token пользователя
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->get('id');
        $deleteForever = $request->get('delete_forever');

        if (!$id) {
            return $this->error('Подписка не найдена');
        }

        if (!isset($deleteForever) || !in_array((int)$deleteForever, [0, 1])) {
            return $this->error('Флаг удаления не найден');
        }

        $subscription = BillingSubscription::query()->withTrashed()->find($id);

        if (!$subscription) {
            return $this->error("Подписка не найдена");
        }

        $this->deleteSubscription($deleteForever, $subscription);

        return $this->success();
    }
}
