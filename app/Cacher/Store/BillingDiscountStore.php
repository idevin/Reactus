<?php namespace App\Cacher\Store;

use App\Cacher\Classes\Base\BaseStore;
use App\Models\BillingDiscount;
use App\Models\BillingDiscountToService;
use App\Models\BillingDiscountToTariff;

/**
 * Class BillingDiscountStore
 * @package App\Cacher\Store
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class BillingDiscountStore extends BaseStore
{
    const ALL_KEY_STORE = self::class.'all_records_key';
    const BY_TARIFF_ID = self::class.'by_tariff_id';
    const BY_SERVICE_ID = self::class.'by_service_id';

    protected static $instance;

    public function getAll() : array
    {
        $arIDList = \Cache::get(self::ALL_KEY_STORE);
        if (!empty($arIDList)) {
            return $arIDList;
        }

        $arIDList = BillingDiscount::all()->pluck('id')->toArray();
        if (empty($arIDList)) {
            return $arIDList;
        }

        \Cache::forever(self::ALL_KEY_STORE, $arIDList);
        return $arIDList;
    }

    public function clearAll()
    {
        \Cache::forget(self::ALL_KEY_STORE);
    }

    public function byTariff($iTariffID) : array
    {
        if (empty($iTariffID)) {
            return [];
        }

        $sKey = self::BY_TARIFF_ID.$iTariffID;
        $arIDList = \Cache::get($sKey);
        if (!empty($arIDList)) {
            return $arIDList;
        }

        $arIDList = BillingDiscountToTariff::where('tariff_id', $iTariffID)->pluck('discount_id')->toArray();
        if (empty($arIDList)) {
            return [];
        }

        \Cache::forever($sKey, $arIDList);
        return $arIDList;
    }

    public function clearByTariff($iTariffID)
    {
        if (empty($iTariffID)) {
            return;
        }

        \Cache::forget(self::BY_TARIFF_ID.$iTariffID);
    }

    public function byService($iServiceID) : array
    {
        if (empty($iServiceID)) {
            return [];
        }

        $sKey = self::BY_SERVICE_ID.$iServiceID;
        $arIDList = \Cache::get($sKey);
        if (!empty($arIDList)) {
            return $arIDList;
        }

        $arIDList = BillingDiscountToService::query()->where('service_id', $iServiceID)->pluck('discount_id')->toArray();
        if (!empty($arIDList)) {
            \Cache::forever($sKey, $arIDList);
        }

        return $arIDList;
    }

    public function clearByService($iServiceID)
    {
        if (empty($iServiceID)) {
            return;
        }

        \Cache::forget(self::BY_SERVICE_ID.$iServiceID);
    }
}