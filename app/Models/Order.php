<?php namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Order
 *
 * @package App\Models
 * @property string $items
 * @property float $total_price
 * @property float $total_discount
 * @property string $name
 * @property string $email
 * @property string phone
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $delivery_address
 * @property string|null $delivery_time
 * @property int $site_id
 * @property int $user_id
 * @property-read Collection|OrderStatus[] $statuses
 * @property-read Site $site
 * @property-read User $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDeliveryAddress($value)
 * @method static Builder|Order whereDeliveryTime($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereItems($value)
 * @method static Builder|Order whereName($value)
 * @method static Builder|Order wherePhone($value)
 * @method static Builder|Order whereSiteId($value)
 * @method static Builder|Order whereTotalDiscount($value)
 * @method static Builder|Order whereTotalPrice($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 * @property-read int|null $statuses_count
 * @property string $phone
 */
class Order extends Model
{
    public $appends = [
        'statuses'
    ];
    protected $fillable = [
        'name',
        'email',
        'phone',
        'delivery_address',
        'delivery_time',
        'user_id',
    ];

    public static function searchable(): array
    {
        return [
            'name',
            'email',
            'phone',
            'delivery_address',
            'delivery_time',
            'create_at',
        ];
    }

    public static function orderable(): array
    {
        return [
            'id',
            'delivery_time',
            'created_at',
        ];
    }

    public function getStatusesAttribute(): array
    {
        return $this->statuses()->get()->toArray();
    }

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_to_order', 'order_id', 'status_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function site(): HasOne
    {
        return $this->hasOne(Site::class, 'id', 'site_id');
    }
}