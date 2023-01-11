<?php

namespace App\Traits;


use App\Models\UserOrder;
use Exception;
use Omnipay\Omnipay;
use Webpatser\Uuid\Uuid;

trait Order
{
    /**
     * @param int $amount
     * @param $user
     * @param $returnUrl
     * @param null $description
     * @param null $isoCode
     * @return mixed
     * @throws Exception
     */
    public static function gatewaySberbank(int $amount, $user, $returnUrl, $description = null, $isoCode = null): mixed
    {
        $amount = preg_replace('#[^\d\.]+#', '', $amount);

        $gateway = Omnipay::create('Sberbank');

        $url = config('sberbank.testMode') == true ? config('sberbank.testUrl') : config('sberbank.url');

        $uuid = str_replace('-', '', Uuid::generate(5, time(), Uuid::NS_DNS)->string);
        $token = $user->auth_token;

        $parsedUrl = parse_url($returnUrl);

        $returnUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

        if (isset($parsedUrl['path'])) {
            $returnUrl .= $parsedUrl['path'];
        }

        $returnUrl .= '?' . http_build_query(['uuid' => $uuid, 'token' => $token]);

        if (isset($parsedUrl['query'])) {
            $returnUrl .= '&' . $parsedUrl['query'];
        }

        if (isset($parsedUrl['fragment'])) {
            $returnUrl .= '#' . $parsedUrl['fragment'];
        }

        $data = [
            'orderNumber' => $uuid,
            'amount' => $amount,
            'returnUrl' => $returnUrl,
            'description' => $description
        ];


        $request = $gateway->authorize($data)->setUserName(config('sberbank.login'))
            ->setPassword(config('sberbank.password'))
            ->setEndPoint($url)
            ->setTestMode(config('sberbank.testMode'))
            ->setLanguage(app()->getLocale());

        $response = $request->send();

        $data = $response->getData();
        $data['uuid'] = $uuid;

        return $data;
    }

    public static function process($orderId, $uuid, $withResponse = false)
    {
        $message = 'Заказ не найден либо уже баланс пополнен';

        $order = UserOrder::getOrder($orderId, $uuid)->first();

        if (!$order) {
            if ($withResponse === true) {
                return Response::response()->error($message);
            } else {
                return $message;
            }
        }

        $gatewayOrder = self::getOrderStatus($order->merchant_order_id);

        $paymentData = $gatewayOrder->getData();

        if (!empty($paymentData)) {
            if ($paymentData['orderStatus'] == UserOrder::SBERBANK_ORDER_SUCCESS) {
                $order->user->balance += (float)$order->points;
                $order->user->save();
                $data = ['paid' => true];
            } else {
                $data = ['description' => $paymentData['actionCodeDescription']];
            }

            $order->update($data);
        }

        if ($withResponse === true) {
            return Response::response()->success($order->user);
        } else {
            return $order->user;
        }
    }

    public static function getOrderStatus($orderId = null)
    {
        $gateway = Omnipay::create('Sberbank');

        $url = config('sberbank.testMode') == true ? config('sberbank.testUrl') : config('sberbank.url');

        return $gateway->extendedOrderStatus(['orderId' => $orderId])
            ->setUserName(config('sberbank.login'))
            ->setPassword(config('sberbank.password'))
            ->setTestMode(config('sberbank.testMode'))
            ->setEndPoint($url)
            ->setLanguage(\App::getLocale())->send();
    }
}