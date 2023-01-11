<?php

namespace App\Models;

use App\Traits\BillingCodes;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BillingService
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $pay_once
 * @property float $points
 * @property-read Collection|\App\Models\BillingDiscount[] $discounts
 * @property-read mixed $payment_info
 * @property-read Collection|\App\Models\Permission[] $permissions
 * @property-read Collection|\App\Models\BillingService[] $services
 * @property-read Collection|\App\Models\BillingTariff[] $tariffs
 * @method static Builder|\App\Models\BillingService newModelQuery()
 * @method static Builder|\App\Models\BillingService newQuery()
 * @method static Builder|\App\Models\BillingService query()
 * @method static Builder|\App\Models\BillingService whereCreatedAt($value)
 * @method static Builder|\App\Models\BillingService whereDescription($value)
 * @method static Builder|\App\Models\BillingService whereId($value)
 * @method static Builder|\App\Models\BillingService whereName($value)
 * @method static Builder|\App\Models\BillingService wherePayOnce($value)
 * @method static Builder|\App\Models\BillingService wherePoints($value)
 * @method static Builder|\App\Models\BillingService whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $discounts_count
 * @property-read int|null $permissions_count
 * @property-read int|null $services_count
 * @property-read int|null $tariffs_count
 * @property float $price
 * @property int $period
 * @property int $period_amount
 * @property-read Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|\App\Models\BillingService wherePeriod($value)
 * @method static Builder|\App\Models\BillingService wherePeriodAmount($value)
 * @method static Builder|\App\Models\BillingService wherePrice($value)
 * @property int|null $free_period_amount
 * @property int|null $free_period
 * @property-read Collection|\App\Models\BillingServiceOptions[] $options
 * @property-read int|null $options_count
 * @method static Builder|BillingService whereFreePeriod($value)
 * @method static Builder|BillingService whereFreePeriodAmount($value)
 */
class BillingService extends Model
{

    use BillingCodes;

    public $timestamps = true;
    protected $connection = 'mysqlu';
    protected $table = 'billing_service';

    protected $fillable = [
        'name', 'description', 'pay_once', 'price', 'period', 'period_amount', 'free_period',
        'free_period_amount'
    ];

    const MONTHLY = 1;
    const DAILY = 2;

    public static array $periods = [
        self::MONTHLY => 'Месяцев',
        self::DAILY => 'Дней'
    ];

    public function tariffs(): BelongsToMany
    {
        return $this->belongsToMany(BillingTariff::class, 'billing_service_to_tariff');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'billing_service_to_role');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(BillingService::class, 'billing_service_to_tariff');
    }

    public function options(): HasMany
    {
        return $this->hasMany(BillingServiceOptions::class);
    }

    public function endsAt($startDate = null)
    {
        if (!$startDate) {
            $startDate = Carbon::now();
        }

        $date = null;

        $periodAmount = $this->period_amount;
        $period = $this->period;

        return $this->{"endsAt" . $period}($periodAmount, $startDate);
    }

    public function endsAt1($periodAmount, $startDate): Carbon
    {
        return (new Carbon($startDate))->addMonths($periodAmount);
    }

    public function endsAt2($periodAmount, $startDate): Carbon
    {
        return (new Carbon($startDate))->addDays($periodAmount);
    }

    public function getNextWriteOff($days)
    {
        $period = $this->period;
        $date = null;
        if (in_array($period, array_keys(self::$periods))) {
            return $this->{"nextWriteOff" . $period}($days);
        }

        return null;
    }

    public function getFreePeriodInDays(): int
    {
        $date = null;
        $days = 0;

        if ($this->free_period && $this->free_period_amount > 0) {
            switch ($this->free_period) {
                case self::MONTHLY:
                    $date = Carbon::now()->addMonths($this->free_period_amount);
                    break;
                case self::DAILY:
                    $date = Carbon::now()->addDays($this->free_period_amount);
                    break;
            }
        }

        if ($date) {
            $days = $date->diffInDays(Carbon::now());
        }

        return $days;
    }

    public function nextWriteOff1($days): Carbon
    {
        return $this->writeOff($days);
    }

    public function nextWriteOff2($days): Carbon
    {
        return $this->writeOff($days);
    }

    public function totalPriceInDays($daysNum = null): float
    {
        $total = 0;
        $totalDays = Carbon::now()->addMonth()->daysInMonth;

        if ($this->price > 0) {
            $total += $this->price / $totalDays;
            if ($daysNum) {
                $total = $total * $daysNum;
            }

            if (count($this->options) > 0) {
                foreach ($this->options as $option) {
                    $total += $option->price;
                }
            }
        }

        return round($total);
    }

    public function totalPrice($options = []): float
    {
        $total = $this->price;

        if (count($this->options) > 0) {
            foreach ($this->options as $option) {
                if (!empty($options)) {
                    foreach ($options as $optionData) {
                        if ($optionData['id'] == $option->id) {
                            $total += $option->price * $optionData['count'];
                        }
                    }
                } else {
                    $total += $option->price;
                }
            }
        }

        return round($total);
    }

    public function writeOff($days): Carbon
    {
        $date = Carbon::now()->addDays($days)->endOfDay();
        $freePeriodDays = $this->getFreePeriodInDays();

        if ($freePeriodDays > 0) {
            $date = $date->addDays($freePeriodDays);
        }

        return $date;
    }
}