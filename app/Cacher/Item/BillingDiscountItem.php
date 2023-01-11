<?php namespace App\Cacher\Item;

use App\Cacher\Classes\Base\BaseItem;
use App\Models\BillingDiscount;
use App\Utils\BillingDiscountAttributes;

/**
 * Class BillingDiscountItem
 * @package App\Cacher\Item
 * @author  Ilya Beltyukov, 968597@gmail.com
 *
 * @property int $id
 * @property int $period
 * @property float $amount
 * @property string $name
 * @property int $period_amount
 * @property float $ball_discount
 * @property float $price
 * @property float $price_discount
 * @property int $price_interest
 * @property int $ball_interest
 * @property int $ball
 *
 * @property float $day_discount
 * @property int $days
 */
class BillingDiscountItem extends BaseItem
{
    use BillingDiscountAttributes;

    protected static function getElement(string $sModelClass, $iElementID)
    {
        return BillingDiscount::where('id', $iElementID)->first();
    }

    public static function getModelClass(): string
    {
        return BillingDiscount::class;
    }
}