<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\BillingSubscriptionService
 *
 * @property int $site_id
 * @property int $user_id
 * @property int $billing_service_id
 * @property int|null $autorenew
 * @property string|null $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $pay_once
 * @property float $points
 * @property int $id
 * @property string|null $deleted_at
 * @property string|null $mail_daily_sent
 * @property string|null $mail_weekly_sent
 * @property-read \App\Models\BillingService $billingService
 * @property-read mixed $human_ends_at
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\BillingSubscriptionService newModelQuery()
 * @method static Builder|\App\Models\BillingSubscriptionService newQuery()
 * @method static Builder|\App\Models\BillingSubscriptionService query()
 * @method static Builder|\App\Models\BillingSubscriptionService whereAutorenew($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereBillingServiceId($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereCreatedAt($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereDeletedAt($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereEndsAt($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereId($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereMailDailySent($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereMailWeeklySent($value)
 * @method static Builder|\App\Models\BillingSubscriptionService wherePayOnce($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereSiteId($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereUpdatedAt($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereUserId($value)
 * @mixin Eloquent
 * @property int|null $billing_subscription_id
 * @property string $next_write_off
 * @property-read \App\Models\BillingSubscription|null $billingSubscription
 * @property-read mixed $description
 * @property-read mixed $human_next_write_off
 * @property-read mixed $period_amount
 * @property-read mixed $period
 * @property-read mixed $price
 * @property-read mixed $title
 * @method static Builder|\App\Models\BillingSubscriptionService whereBillingSubscriptionId($value)
 * @method static Builder|\App\Models\BillingSubscriptionService whereNextWriteOff($value)
 * @property int $detached
 * @property array|null $options
 * @method static Builder|BillingSubscriptionService byUser($user)
 * @method static \Illuminate\Database\Query\Builder|BillingSubscriptionService onlyTrashed()
 * @method static Builder|BillingSubscriptionService whereDetached($value)
 * @method static Builder|BillingSubscriptionService whereOptions($value)
 * @method static \Illuminate\Database\Query\Builder|BillingSubscriptionService withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BillingSubscriptionService withoutTrashed()
 */
class BillingSubscriptionService extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'ends_at', 'site_id', 'autorenew', 'billing_service_id', 'pay_once',
        'deleted_at', 'mail_daily_sent', 'mail_weekly_sent', 'next_write_off', 'billing_subscription_id',
        'detached', 'options'
    ];

    protected $casts = [
        'options' => 'json'
    ];

    protected $table = 'billing_subscription_service';
    protected $connection = 'mysqlu';

    protected $appends = [
        'human_ends_at', 'title', 'description', 'period', 'price', 'human_next_write_off', 'period_amount'
    ];

    public static $orderFields = ['site_id', 'title', 'created_at', 'next_write_off', 'ends_at'];

    public static $orderDirection = ['asc', 'desc'];

    public function site()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, $user)
    {
        return $query->whereUserId($user->id);
    }

    public function getHumanEndsAtAttribute(): string|null
    {
        return datetime_format($this->ends_at);
    }

    public function getHumanNextWriteOffAttribute(): string|null
    {
        return datetime_format($this->next_write_off);
    }

    public function getTitleAttribute()
    {
        return BillingService::find($this->billing_service_id)->name;
    }

    public function getDescriptionAttribute()
    {
        return BillingService::find($this->billing_service_id)->description;
    }

    public function getPeriodAttribute()
    {
        return BillingService::find($this->billing_service_id)->period;
    }

    public function getPeriodAmountAttribute()
    {
        return BillingService::find($this->billing_service_id)->period_amount;
    }

    public function getPriceAttribute()
    {
        $billingService = BillingService::find($this->billing_service_id);

        return $billingService->totalPrice($this->options);
    }

    public function service()
    {
        return $this->billingService();
    }

    public function subscription()
    {
        return $this->billingSubscription();
    }

    public function billingService()
    {
        return $this->belongsTo(BillingService::class, 'billing_service_id');
    }

    public function billingSubscription()
    {
        return $this->belongsTo(BillingSubscription::class, 'billing_subscription_id');
    }

    public static function cleanOptions($options = [])
    {
        $cleanOptions = null;
        foreach ($options as $option) {
            if (isset($option['id']) && isset($option['count'])) {
                $serviceOption = BillingServiceOptions::find($option['id']);
                if ($serviceOption) {
                    $cleanOptions[] = ['id' => $serviceOption->id, 'count' => $option['count']];
                }
            }
        }
        return $cleanOptions;
    }
}
