<?php namespace App\Cacher\Event;

/**
 * Class Subscription
 * @package App\Cacher\Event
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class Subscription
{
    public static function subscribe() : array
    {
        return [
            BillingDiscountHandler::class,
            BillingTariffHandler::class,
        ];
    }
}