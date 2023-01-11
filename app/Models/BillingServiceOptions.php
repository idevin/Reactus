<?php

namespace App\Models;

use App\Traits\BillingCodes;

/**
 * App\Models\BillingServiceOptions
 *
 * @property int $id
 * @property int|null $billing_service_id
 * @property string $name
 * @property string|null $increment_type
 * @property float $price
 * @property-read mixed $increment_name
 * @property-read \App\Models\BillingService|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions whereBillingServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions whereIncrementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingServiceOptions wherePrice($value)
 * @mixin \Eloquent
 */
class BillingServiceOptions extends Model
{
    use BillingCodes;

    const DISK_SPACE = 1;
    const CARDS_NUM = 2;

    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'billing_service_options';
    protected $fillable = ['billing_service_id', 'name', 'increment_type', 'price'];

    public static $types = [
        self::DISK_SPACE => 'Дисковое пространство',
        self::CARDS_NUM => 'Кол-во карточек магазина'
    ];

    protected $appends = [
        'increment_name'
    ];

    public function service()
    {
        return $this->belongsTo(BillingService::class, 'billing_service_id');
    }

    public function getIncrementNameAttribute()
    {
        return self::$types[$this->increment_type];
    }
}