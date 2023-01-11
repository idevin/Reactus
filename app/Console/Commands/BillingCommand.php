<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\ApiNotificationsController;
use App\Http\Controllers\WebSocketPusherController;
use App\Models\BillingService;
use App\Models\BillingSubscription;
use App\Models\BillingSubscriptionService;
use App\Models\UserOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class BillingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check bills';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        if (config('billing.enabled') == true) {
            $dailyRange = [
                Carbon::now()->addDay()->startOfDay()->toDateTimeString(),
                Carbon::now()->addDay()->endOfDay()->toDateTimeString()
            ];

            $weeklyRange = [
                Carbon::now()->addDays(7)->startOfDay()->toDateTimeString(),
                Carbon::now()->addDays(7)->endOfDay()->toDateTimeString()
            ];

            /**
             * UPDATE OLD BILLS AND SERVICES
             */

            $this->updateBills();

            /**
             * DAILY BILLS
             */
            $this->notifyDaily($dailyRange);

            /**
             * WEEKLY BILLS
             */
            $this->notifyWeekly($weeklyRange);

        }

        return true;
    }

    public function updateBills()
    {
        $subscriptions = BillingSubscription::query()->orderBy('created_at', 'asc')->get();
        $nowDate = Carbon::now();

        if (!empty($subscriptions)) {

            $subscriptions->map(function ($subscription) use ($nowDate) {
                $disabledSubscription = $nowDate->gt($subscription->ends_at);

                if ($disabledSubscription) {
                    $user = $subscription->user;
                    $site = $subscription->site;
                    $subject = "У вас окончилась подписка на тариф '" . $subscription->tariff->name . "'";

                    if (!empty($user->email)) {

                        sendEmail($user->email, $subject, compact('subscription'),
                            'send-canceled-tariff-notification', [], $site->domain);

                    } else if (!empty($user->phone)) {
                        send_sms($user->phone, $subject);
                    }

                    $subscription->update(['deleted_at' => $nowDate]);
                }

                if (count($subscription->services) > 0) {

                    /** @var BillingSubscriptionService $service */

                    foreach ($subscription->services as $service) {
                        $nextWriteOff = new Carbon($service->next_write_off);
                        /**
                         * Сервис для списывания денег
                         */
                        $payNow = $nextWriteOff->toDateString() == $nowDate->toDateString();
                        $disabledService = $nextWriteOff->gt($service->ends_at);

                        if ($disabledService) {
                            $service->update(['deleted_at' => $nowDate]);
                            $this->sendDisabledServiceNotification($service);
                        }

                        if ($payNow == true && !$service->trashed()) {
                            $futureNextWriteOff = null;

                            $periodAmount = $service->period_amount;
                            $period = $service->period;

                            $futureNextWriteOff = match ($period) {
                                BillingService::MONTHLY => (new Carbon($service->next_write_off))
                                    ->addMonths($periodAmount),
                                BillingService::DAILY => (new Carbon($service->next_write_off))
                                    ->addDays($periodAmount),
                            };

                            $billService = BillingService::query()->find($service->billing_service_id);

                            if ($billService) {
                                $description = 'Оплата сервиса ' . $service->name;

                                $service->update([
                                    'next_write_off' => $futureNextWriteOff
                                ]);

                                $price = $billService->totalPrice($service->options);
                                $price = round($price);

                                UserOrder::query()->firstOrCreate([
                                    'user_id' => $service->user_id,
                                    'internal_order_id' => $service->id,
                                    'merchant_order_id' => $service->id,
                                    'price' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_PAY_SERVICE] . $price,
                                    'points' => UserOrder::TYPE_SIGNS[UserOrder::TYPE_PAY_SERVICE] . $price,
                                    'description' => $description,
                                    'payment_type' => UserOrder::TYPE_PAY_SERVICE,
                                    'site_id' => $service->site_id
                                ]);

                                $service->user->balance -= $price;
                            }
                        }
                    }
                }
            });
        }

    }

    public function sendDisabledServiceNotification(BillingSubscriptionService $service)
    {
        $subject = 'У вас окончилась оплата тарифа на сайте ' . $service->site->domain;

        if (!empty($service->user->email)) {

            sendEmail($service->user->email, $subject,
                ['bill' => $service] + $service->toArray(), 'send-canceled-bill-notification', [], $service->site->domain);

        } else if (!empty($service->user->phone)) {
            send_sms($service->user->phone, $subject);
        }
    }

    public function notifyDaily($dates)
    {
        $this->notify($dates, 'daily');
    }

    public function notify($dates, $period)
    {
        $f = 'whereMail' . ucfirst($period) . 'Sent';

        $services = BillingSubscriptionService::query()->whereBetween('ends_at', $dates)->$f(null)->get();

        $dataForMail = [];

        if (count($services) > 0) {
            foreach ($services as $service) {
                $dataForMail[$service->user_id][$service->site_id]['user'] = $service->user;
                $dataForMail[$service->user_id][$service->site_id]['site'] = $service->site;
                $dataForMail[$service->user_id][$service->site_id]['services'][] = $service;
            }
        }

        if (!empty($dataForMail)) {
            foreach ($dataForMail as $userId => $servicesData) {
                foreach ($servicesData as $siteId => $allData) {
                    $domain = $allData['site']->domain;
                    $subject = 'Оканчивается срок действия сервисов на сайте ' . $domain;

                    $serviceIds = collect($allData['services'])->pluck('id');
                    if (!empty($serviceIds)) {
                        (new BillingSubscriptionService)->whereIn('id', $serviceIds)->update([
                            'mail_' . $period . '_sent' => Carbon::now()
                        ]);
                    }

                    if (!empty($allData['user']->email)) {
                        sendEmail($allData['user']->email, $subject,
                            $allData, 'send-' . $period . '-service-notification', [], $domain);

                    } else if (!empty($allData['user']->phone)) {
                        send_sms($allData['user']->phone, $subject);
                    }
                }
            }
        }

        if (env('APP_DEBUG_VARS') == true) {
            debugvars(strtoupper($period) . ' SERVICES: ' . count($services) . ' SERVICE DATES:', $dates);
        }
    }

    public function notifyWeekly($dates)
    {
        $this->notify($dates, 'weekly');
    }
}
