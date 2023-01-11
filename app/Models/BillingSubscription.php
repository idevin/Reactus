<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\BillingSubscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property string|null $trial_ends_at
 * @property string|null $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $billing_tariff_id
 * @property int $autorenew
 * @property int|null $billing_discount_id
 * @property string|null $deleted_at
 * @property string|null $mail_daily_sent
 * @property string|null $mail_weekly_sent
 * @property-read \App\Models\BillingDiscount|null $billingDiscount
 * @property-read \App\Models\BillingTariff $billingTariff
 * @property-read mixed $human_ends_at
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static Builder|\App\Models\BillingSubscription newModelQuery()
 * @method static Builder|\App\Models\BillingSubscription newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BillingSubscription onlyTrashed()
 * @method static Builder|\App\Models\BillingSubscription query()
 * @method static bool|null restore()
 * @method static Builder|\App\Models\BillingSubscription trial($user)
 * @method static Builder|\App\Models\BillingSubscription whereAutorenew($value)
 * @method static Builder|\App\Models\BillingSubscription whereBillingDiscountId($value)
 * @method static Builder|\App\Models\BillingSubscription whereBillingTariffId($value)
 * @method static Builder|\App\Models\BillingSubscription whereCreatedAt($value)
 * @method static Builder|\App\Models\BillingSubscription whereDeletedAt($value)
 * @method static Builder|\App\Models\BillingSubscription whereEndsAt($value)
 * @method static Builder|\App\Models\BillingSubscription whereId($value)
 * @method static Builder|\App\Models\BillingSubscription whereMailDailySent($value)
 * @method static Builder|\App\Models\BillingSubscription whereMailWeeklySent($value)
 * @method static Builder|\App\Models\BillingSubscription whereSiteId($value)
 * @method static Builder|\App\Models\BillingSubscription whereTrialEndsAt($value)
 * @method static Builder|\App\Models\BillingSubscription whereUpdatedAt($value)
 * @method static Builder|\App\Models\BillingSubscription whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BillingSubscription withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BillingSubscription withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $human_starts_at
 * @property float $price
 * @property-read Collection|\App\Models\BillingSubscriptionService[] $services
 * @property-read int|null $services_count
 * @method static Builder|\App\Models\BillingSubscription bySite($siteId)
 * @method static Builder|\App\Models\BillingSubscription wherePrice($value)
 * @property int $billing_service_id
 * @property-read string|null $human_next_write_off
 * @property-read mixed $next_write_off
 * @method static Builder|BillingSubscription byUser($user)
 * @method static Builder|BillingSubscription whereBillingServiceId($value)
 */
class BillingSubscription extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        'user_id', 'trial_ends_at', 'ends_at', 'site_id', 'autorenew', 'billing_tariff_id',
        'deleted_at', 'mail_daily_sent', 'mail_weekly_sent', 'created_at', 'price', 'deleted_at'
    ];

    protected $table = 'billing_subscription';
    protected $connection = 'mysqlu';
    protected $appends = ['human_ends_at', 'human_starts_at', 'next_write_off', 'human_next_write_off'];

    public function user()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }

    public function tariff()
    {
        $this->setConnection('mysqlu');
        return $this->billingTariff();
    }

    public function billingTariff()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(BillingTariff::class);
    }

    public function services()
    {
        $this->setConnection('mysqlu');
        return $this->hasMany(BillingSubscriptionService::class);
    }

    public function getHumanEndsAtAttribute(): string|null
    {
        return datetime_format($this->ends_at);
    }

    public function getHumanStartsAtAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }

    public function scopeTrial($query, $user)
    {
        if (!$user) {
            return $query;
        }
        return $query->whereUserId($user->id)
            ->whereNotNull('trial_ends_at');
    }

    public function scopeByUser($query, $user)
    {
        if (!$user) {
            return $query;
        }
        return $query->whereUserId($user->id);
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->whereSiteId($siteId);
    }

    public static function endsAt($tariff)
    {
        $dates = [];

        foreach ($tariff->services as $service) {
            $dates[] = $service->endsAt()->toDateTimeString();
        }

        return max($dates);
    }

    public function getNextWriteOffAttribute()
    {
        $dates = [];
        $minDates = null;
        foreach ($this->services as $service) {
            $dates[] = $service->next_write_off;
        }

        if (!empty($dates)) {
            $minDates = min($dates);
        }

        return $minDates;
    }

    public function getHumanNextWriteOffAttribute(): string|null
    {
        $date = $this->getNextWriteOffAttribute();

        return datetime_format($date);
    }
}
