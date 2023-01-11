<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\BillingConstructor
 *
 * @property-read Collection|\App\Models\BillingServiceTariff[] $serviceTariffs
 * @method static Builder|\App\Models\BillingConstructor newModelQuery()
 * @method static Builder|\App\Models\BillingConstructor newQuery()
 * @method static Builder|\App\Models\BillingConstructor query()
 * @mixin Eloquent
 * @property-read int|null $service_tariffs_count
 */
class BillingConstructor extends Model
{
    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'billing_constructor';

    protected $fillable = [
        'name'
    ];

    public function serviceTariffs()
    {
        return $this->hasMany(BillingServiceTariff::class);
    }
}