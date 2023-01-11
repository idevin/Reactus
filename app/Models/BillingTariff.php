<?php

namespace App\Models;

use App\Traits\BillingCodes;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use JetBrains\PhpStorm\Pure;

/**
 * Class BillingTariff
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|\App\Models\BillingDiscount[] $discounts
 * @property-read mixed $paid
 * @property-read Collection|\App\Models\BillingService[] $services
 * @property-read \App\Models\UserOrder $userOrder
 * @method static Builder|\App\Models\BillingTariff newModelQuery()
 * @method static Builder|\App\Models\BillingTariff newQuery()
 * @method static Builder|\App\Models\BillingTariff query()
 * @method static Builder|\App\Models\BillingTariff whereCreatedAt($value)
 * @method static Builder|\App\Models\BillingTariff whereDescription($value)
 * @method static Builder|\App\Models\BillingTariff whereId($value)
 * @method static Builder|\App\Models\BillingTariff whereName($value)
 * @method static Builder|\App\Models\BillingTariff whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $discounts_count
 * @property-read int|null $services_count
 * @method static Builder|\App\Models\BillingTariff totalPrice()
 * @property string|null $end_date
 * @property-read mixed $price
 * @method static Builder|BillingTariff whereEndDate($value)
 */
class BillingTariff extends Model
{

    use BillingCodes;

    const MONTHLY = 1;
    const DAILY = 2;
    const ONETIME = 4;

    /** 1 - ежемесячно, 2 - каждый день, 3 - единовременно **/
    public static array $periods = [
        self::MONTHLY => 'Ежемесячно',
        self::DAILY => 'Ежедневно',
        self::ONETIME => 'Единовременно'
    ];
    public $timestamps = true;
    protected $connection = 'mysqlu';
    protected $table = 'billing_tariff';
    protected $fillable = [
        'name', 'description', 'end_date'
    ];

    protected $appends = [
        'price'
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(BillingService::class, 'billing_service_to_tariff');
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(BillingDiscount::class, 'billing_discount_to_tariff', 'tariff_id', 'discount_id');
    }

    public function userOrder(): BelongsTo
    {
        return $this->belongsTo(UserOrder::class);
    }

    public function totalPriceInDays($daysNum): float
    {
        $total = 0;

        $totalDays = Carbon::now()->daysInMonth;

        if (count($this->services) > 0) {
            foreach ($this->services as $service) {
                if ($service->price > 0) {
                    $total += $service->price / $totalDays * $daysNum;

                    $this->priceOptions($service, $total);
                }
            }
        }

        return round($total);
    }

    public function priceOptions($service, &$total)
    {
        if (count($service->options) > 0) {
            foreach ($service->options as $option) {
                $total += $option->price;
            }
        }
    }

    #[Pure]
    public function getPriceAttribute(): float
    {
        return $this->scopeTotalPrice();
    }

    public function scopeTotalPrice(): float
    {
        $total = 0;

        foreach ($this->services as $service) {
            $total += $service->price;

            $this->priceOptions($service, $total);
        }

        return round($total);
    }
}