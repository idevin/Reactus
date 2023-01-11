<?php namespace App\Cacher\Event;

use App\Cacher\Classes\Base\ModelHandler;
use App\Cacher\Item\BillingTariffItem;
use App\Cacher\Store\BillingDiscountStore;
use App\Cacher\Store\BillingTariffStore;

/**
 * Class BillingTariffHandler
 * @package App\Cacher\Event
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class BillingTariffHandler extends ModelHandler
{
    public function getItemClass(): string
    {
        return BillingTariffItem::class;
    }

    public function afterCreate()
    {
        BillingTariffStore::getInstance()->clearAll();
    }

    public function afterDelete()
    {
        BillingTariffStore::getInstance()->clearAll();
        BillingDiscountStore::getInstance()->clearByTariff($this->obElement->id);
    }

    public function afterUpdate()
    {
        if ($this->isFieldChange('id')) {
            BillingDiscountStore::getInstance()->clearByTariff($this->obElement->id);
            BillingDiscountStore::getInstance()->clearByTariff($this->obElement->getOriginal('id'));
        }
    }
}