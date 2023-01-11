<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $iso_code
 * @property string $name
 * @property float $points_value
 * @property float $currency_value
 * @property int $is_default
 * @method static Builder|\App\Models\Currency newModelQuery()
 * @method static Builder|\App\Models\Currency newQuery()
 * @method static Builder|\App\Models\Currency query()
 * @method static Builder|\App\Models\Currency whereCurrencyValue($value)
 * @method static Builder|\App\Models\Currency whereId($value)
 * @method static Builder|\App\Models\Currency whereIsDefault($value)
 * @method static Builder|\App\Models\Currency whereIsoCode($value)
 * @method static Builder|\App\Models\Currency whereName($value)
 * @method static Builder|\App\Models\Currency wherePointsValue($value)
 * @mixin Eloquent
 * @property int $iso4217_code
 * @property string|null $sign
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillingDiscount[] $discounts
 * @property-read int|null $discounts_count
 * @method static Builder|Currency whereIso4217Code($value)
 * @method static Builder|Currency whereSign($value)
 */
class Currency extends Model
{
    protected $table = 'currency';
    protected $connection = 'mysqlu';
    public $timestamps = false;
    protected $fillable = [
        'iso_code', 'name', 'points_value', 'currency_value', 'id', 'sign', 'is_default', 'iso4217_code'
    ];

    public static function currencySelect($emptyValue = true, $field = 'code')
    {
        $allCurrencies = [];
        $codes = self::currencies();

        if (!empty($codes)) {
            $currencies = collect($codes)->pluck('currencies');
            foreach ($currencies as $currency) {
                foreach ($currency as $code) {
                    if (!empty($code['code']) && !in_array($code['code'], array_keys($allCurrencies))) {
                        $allCurrencies[$code[$field]] = $code['code'] . ' (' . $code['name'] . ')';
                    }
                }
            }
        }

        $allCurrencies = Arr::sort($allCurrencies);

        if ($emptyValue == true) {
            $allCurrencies = ['' => 'Выберите валюту...'] + $allCurrencies;
        }

        return $allCurrencies;
    }

    public static function currencies()
    {
        $codes = file_get_contents(config('currency.all_codes'));
        $codes = json_decode($codes, true);
        return $codes;
    }

    public function discounts()
    {
        return $this->hasMany(BillingDiscount::class, 'currency_id');
    }
}
