<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BillingServiceTariff
 *
 * @property int $id
 * @property int $billing_tariff_id
 * @property int $billing_service_id
 * @property-read \App\Models\BillingService $service
 * @property-read \App\Models\BillingTariff $tariff
 * @method static Builder|\App\Models\BillingServiceTariff newModelQuery()
 * @method static Builder|\App\Models\BillingServiceTariff newQuery()
 * @method static Builder|\App\Models\BillingServiceTariff query()
 * @method static Builder|\App\Models\BillingServiceTariff whereBillingServiceId($value)
 * @method static Builder|\App\Models\BillingServiceTariff whereBillingTariffId($value)
 * @method static Builder|\App\Models\BillingServiceTariff whereId($value)
 * @mixin Eloquent
 */
class BillingServiceTariff extends Model
{
    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'billing_service_to_tariff';


    protected $fillable = [
        'billing_tariff_id', 'billing_service_id'
    ];

    public function tariff()
    {
        return $this->belongsTo(BillingTariff::class, 'billing_tariff_id');
    }

    public function service()
    {
        return $this->belongsTo(BillingService::class, 'billing_service_id');
    }
}