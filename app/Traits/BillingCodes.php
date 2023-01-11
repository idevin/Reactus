<?php


namespace App\Traits;


trait BillingCodes
{
    /**
     * 0XX - tariffs
     * 1XX - services
     * 2XX - custom codes
     */
    static $tariffNotFound = "001";

    static $notEnoughBallance = "202";

    static $serviceNotFound = "101";
}