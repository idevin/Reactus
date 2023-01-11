<?php namespace App\Cacher\Store;

use App\Cacher\Classes\Base\BaseStore;
use App\Models\BillingTariff;

/**
 * Class BillingTariffStore
 * @package App\Cacher\Store
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class BillingTariffStore extends BaseStore
{
    const ALL_KEY_STORE = self::class.'all_records_key';

    public function getAll() : array
    {
        $arIDList = \Cache::get(self::ALL_KEY_STORE);
        if (!empty($arIDList)) {
            return $arIDList;
        }

        $arIDList = BillingTariff::all()->pluck('id')->toArray();
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
}