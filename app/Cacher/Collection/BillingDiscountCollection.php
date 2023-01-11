<?php namespace App\Cacher\Collection;

use App\Cacher\Classes\Base\BaseCollection;
use App\Cacher\Item\BillingDiscountItem;
use App\Cacher\Store\BillingDiscountStore;

/**
 * Class BillingDiscountCollection
 * @package App\Cacher\Collection
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class BillingDiscountCollection extends BaseCollection
{
    protected static function getItemClass(): string
    {
        return BillingDiscountItem::class;
    }

    public function allRecord(): BillingDiscountCollection
    {
        $arIDList = BillingDiscountStore::getInstance()->getAll();
        $this->intersect($arIDList);

        return $this->returnThis();
    }

    public function tariff($iTariffID)
    {
        $arIDList = BillingDiscountStore::getInstance()->byTariff($iTariffID);
        $this->intersect($arIDList);

        return $this->returnThis();
    }

    public function service($iServiceID)
    {
        $arIDList = BillingDiscountStore::getInstance()->byService($iServiceID);
        $this->intersect($arIDList);

        return $this->returnThis();
    }
}