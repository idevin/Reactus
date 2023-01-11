<?php namespace App\Cacher\Event;

use App\Cacher\Classes\Base\ModelHandler;
use App\Cacher\Item\BillingDiscountItem;
use App\Cacher\Store\BillingDiscountStore;

/**
 * Class BillingDiscountHandler
 * @package App\Cacher\Event
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class BillingDiscountHandler extends ModelHandler
{
    public function getItemClass(): string
    {
        return BillingDiscountItem::class;
    }

    public function afterCreate()
    {
        BillingDiscountStore::getInstance()->clearAll();

    }

    public function afterDelete()
    {
        BillingDiscountStore::getInstance()->clearAll();
        BillingDiscountStore::getInstance()->clearByTariff($this->obElement->tariff_id);
    }

    public function afterUpdate()
    {
        if ($this->isFieldChange('tariff_id')) {
            BillingDiscountStore::getInstance()->clearByTariff($this->obElement->tariff_id);
            BillingDiscountStore::getInstance()->clearByTariff($this->obElement->getOriginal('tariff_id'));
        }
    }
}