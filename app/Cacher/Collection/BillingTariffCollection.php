<?php namespace App\Cacher\Collection;

use App\Cacher\Classes\Base\BaseCollection;
use App\Cacher\Item\BillingTariffItem;
use App\Cacher\Store\BillingTariffStore;

/**
 * Class BillingTariffCollection
 * @package App\Cacher\Collection
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class BillingTariffCollection extends BaseCollection
{
    protected static function getItemClass(): string
    {
        return BillingTariffItem::class;
    }

    public function allRecord()
    {
        $arIDList = BillingTariffStore::getInstance()->getAll();
        $this->intersect($arIDList);

        return $this->returnThis();
    }
}