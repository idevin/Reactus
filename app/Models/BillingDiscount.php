<?php

namespace App\Models;

use App\Cacher\Classes\Base\Cacheble;
use App\Utils\BillingDiscountAttributes;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BillingDiscount
 *
 * @package App\Models
 * @property int $price_type
 * @property float $amount
 * @property string $name
 * @property string $description
 * @property int $id
 * @property int $period_amount
 * @property int $period
 * @property float|null $ball_discount
 * @property float $price
 * @property float $ball
 * @property-read mixed $discount_price
 * @property-read Collection|\App\Models\UserOrder[] $orders
 * @property-read Collection|\App\Models\BillingTariff[] $tariffs
 * @method static Builder|\App\Models\BillingDiscount newModelQuery()
 * @method static Builder|\App\Models\BillingDiscount newQuery()
 * @method static Builder|\App\Models\BillingDiscount query()
 * @method static Builder|\App\Models\BillingDiscount whereAmount($value)
 * @method static Builder|\App\Models\BillingDiscount whereBall($value)
 * @method static Builder|\App\Models\BillingDiscount whereBallDiscount($value)
 * @method static Builder|\App\Models\BillingDiscount whereDescription($value)
 * @method static Builder|\App\Models\BillingDiscount whereId($value)
 * @method static Builder|\App\Models\BillingDiscount whereName($value)
 * @method static Builder|\App\Models\BillingDiscount wherePeriod($value)
 * @method static Builder|\App\Models\BillingDiscount wherePeriodAmount($value)
 * @method static Builder|\App\Models\BillingDiscount wherePrice($value)
 * @method static Builder|\App\Models\BillingDiscount wherePriceType($value)
 * @mixin Eloquent
 * @property-read int|null $orders_count
 * @property-read int|null $tariffs_count
 * @property float $percent
 * @method static Builder|\App\Models\BillingDiscount wherePercent($value)
 * @property int|null $currency_id
 * @property-read \App\Models\Currency|null $currency
 * @property-read mixed $points
 * @method static Builder|BillingDiscount whereCurrencyId($value)
 */
class BillingDiscount extends Model
{
    use Cacheble;
    use BillingDiscountAttributes;

    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'billing_discount';
    protected $fillable = ['amount', 'percent', 'name', 'currency_id'];
    protected $appends = ['points'];

    public function cached(): array
    {
        return [
            'amount',
            'name',
            'percent',
            'id',
            'currency_id'
        ];
    }

    public function getPointsAttribute()
    {
        $amountPercent = $this->amount / 100 * $this->percent;
        return round(($this->amount + $amountPercent) / config('billing.currency.point'));
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}