<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingSubscriptionService;
use App\Models\User;
use App\Traits\Activity;
use Illuminate\Http\Request;

class MyServicesController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(BillingSubscriptionService::class);
        $this->setUserActivity();
    }

    /**
     * @api {GET} /api/profile/services Подписки сервисов
     * @apiGroup Billing services
     *
     * @apiParam token Token пользователя
     *
     * @apiParam field Сортировка по полю (0 - сайт, 1 - название,
     * 2 - дата начала сервиса, 3 - дата следующего списания, 4 - дата окончания)
     *
     * @apiParam order Направление сортировки (0 - по возрастанию, 1 - по убыванию)
     * @apiParam token Token пользователя
     *
     * @param Request $request
     * @return JSON
     */
    public function index(Request $request)
    {
        $user = \Auth::user();

        $services = BillingSubscriptionService::query()->with(['site' => function ($query) {
            return $query->select(['id', 'domain']);
        }])->whereUserId($user->id)->get();

        if (count($services) == 0) {
            return $this->error('Подписок пока не найдено');
        }

        $field = $request->get('field');
        $order = $request->get('order');

        if (isset($field) && isset(BillingSubscriptionService::$orderFields[$field])) {
            if (isset($order) && isset(BillingSubscriptionService::$orderDirection[$order])) {
                $services = collect($services->toArray());
                $services = ((int)$order == 0 ?
                    $services->sortBy(BillingSubscriptionService::$orderFields[$field]) :
                    $services->sortByDesc(BillingSubscriptionService::$orderFields[$field]));

                $services = $services->values();
            }
        }

        return $this->success($services);
    }
}
