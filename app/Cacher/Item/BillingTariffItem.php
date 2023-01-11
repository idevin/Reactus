<?php namespace App\Cacher\Item;

use App\Cacher\Classes\Base\BaseItem;
use App\Cacher\Collection\BillingDiscountCollection;
use App\Models\BillingService;
use App\Models\BillingTariff;

/**
 * Class BillingTariffItem
 * @package App\Cacher\Item
 * @author  Ilya Beltyukov, 968597@gmail.com
 *
 * @property int $id
 *
 * @property BillingDiscountCollection $discount
 * @property BillingService[] $services
 */
class BillingTariffItem extends BaseItem
{

    protected static function getElement(string $sModelClass, $iElementID)
    {
        return BillingTariff::where('id', $iElementID)->first();
    }

    public static function getModelClass(): string
    {
        return BillingTariff::class;
    }

    public function applyDiscount()
    {
        $obDiscountCollection = $this->discount;
        if (empty($obDiscountCollection)) {
            return;
        }

        /** @var BillingDiscountItem $obDiscountItem */
        foreach ($obDiscountCollection as $obDiscountItem) {
            $fDiscount = (float)$this->price - (float)$obDiscountItem->amount;
            if ($fDiscount < 0) {
                $fDiscount = 0;
            }

            $this->price = round($fDiscount, 2);

            $fBallDiscount = (float)$this->ball_price - (float)$obDiscountItem->ball_discount;
            if ($fBallDiscount < 0) {
                $fBallDiscount = 0;
            }
            $this->ball_price = round($fBallDiscount, 2);
        }
    }

    /**
     * @return array
     */
    public function getServicesAttribute(): array
    {
        $obTariff = BillingTariff::where('id', $this->id)->first();
        if (empty($obTariff)) {
            $this->setAttribute('services', []);
            return [];
        }

        $obServiceList = $obTariff->services()->get();
        if ($obServiceList->count() <= 0) {
            $this->setAttribute('services', []);
            return [];
        }

        $arResult = [];
        /** @var BillingService $obService */
        foreach ($obServiceList as $obService) {
            $obService->makeHidden(['pivot']);
            $arServiceData = $obService->toArray();
            $arServiceData['permissions'] = $obService->permissions()->get()->makeHidden(['pivot'])->toArray();
            $arResult[] = $arServiceData;
        }

        $this->setAttribute('services', $arResult);
        return $arResult;
    }

    public function getDiscountAttribute()
    {
        $obDiscountCollection = BillingDiscountCollection::make()->tariff($this->id);
        if ($obDiscountCollection->isEmpty()) {
            $this->setAttribute('discount', []);
            return [];
        }

        $arResult = [];

        /** @var BillingDiscountItem $obDiscount */
        foreach ($obDiscountCollection as $obDiscount) {
            $obDiscount->with(['discount_price', 'discount_ball', 'price_interest', 'ball_interest']);
            $arResult[] = $obDiscount->toArray();
        }

        $this->setAttribute('discount', $arResult);
        return $arResult;
    }
}