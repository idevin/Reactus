<?php

namespace App\Models;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserOrder
 *
 * @property int $id
 * @property int|null $user_id
 * @property float $amount
 * @property string $internal_order_id
 * @property string $merchant_order_id
 * @property int $paid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array|null $options
 * @property string|null $description
 * @property float $points
 * @property int|null $billing_tariff_id
 * @property int|null $billing_discount_id
 * @property int|null $billing_service_id
 * @property-read \App\Models\BillingDiscount $discount
 * @property-read \App\Models\BillingService $service
 * @property-read \App\Models\BillingTariff $tariff
 * @property-read \App\Models\User|null $user
 * @method static Builder|UserOrder getOrder($merchantOrderId, $internalOrderId)
 * @method static Builder|UserOrder newModelQuery()
 * @method static Builder|UserOrder newQuery()
 * @method static Builder|UserOrder query()
 * @method static Builder|UserOrder whereAmount($value)
 * @method static Builder|UserOrder whereBillingDiscountId($value)
 * @method static Builder|UserOrder whereBillingServiceId($value)
 * @method static Builder|UserOrder whereBillingTariffId($value)
 * @method static Builder|UserOrder whereCreatedAt($value)
 * @method static Builder|UserOrder whereDescription($value)
 * @method static Builder|UserOrder whereId($value)
 * @method static Builder|UserOrder whereInternalOrderId($value)
 * @method static Builder|UserOrder whereMerchantOrderId($value)
 * @method static Builder|UserOrder whereOptions($value)
 * @method static Builder|UserOrder wherePaid($value)
 * @method static Builder|UserOrder wherePoints($value)
 * @method static Builder|UserOrder whereUpdatedAt($value)
 * @method static Builder|UserOrder whereUserId($value)
 * @mixin Eloquent
 * @property int|null $site_id
 * @property float $price
 * @property-read mixed $created_at_formated
 * @property-read \App\Models\Site|null $site
 * @method static Builder|\App\Models\UserOrder bySite($siteId)
 * @method static Builder|\App\Models\UserOrder sites($userId)
 * @method static Builder|\App\Models\UserOrder wherePrice($value)
 * @method static Builder|\App\Models\UserOrder whereSiteId($value)
 * @property int $payment_type
 * @method static Builder|UserOrder wherePaymentType($value)
 */
class UserOrder extends Model
{

    const SORT_OPTIONS = [
        'id' => 'ID',
        'created_at' => 'Дата'
    ];

    const SORT_DIRECTIONS = [
        'asc', 'desc'
    ];

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'merchant_order_id', 'internal_order_id', 'paid', 'price', 'site_id',
        'description', 'billing_discount_id', 'points'
    ];
    protected $table = 'user_order';
    protected $connection = 'mysqlu';

    protected $appends = [
        'created_at_formated'
    ];

    const SBERBANK_ORDER_SUCCESS = 2;

    const SBERBANK_ORDER_STATUSES = [
        0 => 'Заказ зарегистрирован, но не оплачен',
        1 => 'Предавторизованная сумма захолдирована (для двухстадийных платежей)',
        self::SBERBANK_ORDER_SUCCESS => 'Проведена полная авторизация суммы заказа',
        3 => 'Авторизация отменена',
        4 => 'По транзакции была проведена операция возврата',
        5 => 'Инициирована авторизация через ACS банка-эмитента',
        6 => 'Авторизация отклонена'
    ];

    const TYPE_ADD_AMOUNT = 1;
    const TYPE_PAY_TARIFF = 2;
    const TYPE_PAY_SERVICE = 3;

    const TYPES = [
        'Пополнение баланса' => self::TYPE_ADD_AMOUNT,
        'Оплата тарифа' => self::TYPE_PAY_TARIFF,
        'Оплата сервиса' => self::TYPE_PAY_SERVICE
    ];

    const TYPE_SIGNS = [
        self::TYPE_ADD_AMOUNT => "+",
        self::TYPE_PAY_TARIFF => "-",
        self::TYPE_PAY_SERVICE => "-"
    ];

    public static $limits = [3, 10, 20, 50];

    public static function totalAmount($userId)
    {
        $totalAmount = static::query()->whereUserId($userId)->wherePaid(1)->sum('price');

        return (float)$totalAmount;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }

    public function tariff()
    {
        return $this->belongsTo(BillingTariff::class);
    }

    public function service()
    {
        return $this->belongsTo(BillingService::class);
    }

    public function discount()
    {
        return $this->belongsTo(BillingDiscount::class);
    }

    public function scopeGetOrder($query, $merchantOrderId, $internalOrderId)
    {
        return $query->whereMerchantOrderId($merchantOrderId)
            ->whereUserId(Auth::user()->id)
            ->whereInternalOrderId($internalOrderId)
            ->wherePaid(0);
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }

    public function scopeSites($query, $userId)
    {
        return $query->whereUserId($userId)->with(['site' => function ($query) {
            $query->orderBy('site.domain', 'desc');
        }])->whereNotNull('site_id')->groupBy('site_id')
            ->select('site_id')->get()->pluck('site.domain', 'site.id');
    }

    public function scopeBySite($query, $siteId)
    {
        $site = Site::find($siteId);
        if ($site) {
            $query->whereSiteId($siteId);
        }

        return $query;
    }
}