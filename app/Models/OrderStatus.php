<?php namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Class OrderStatus
 *
 * @package App\Models
 * @property int $id
 * @property string $action
 * @property string $name
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\Order[] $orders
 * @method static Builder|\App\Models\OrderStatus byAction($sStatusAction = null)
 * @method static Builder|\App\Models\OrderStatus newModelQuery()
 * @method static Builder|\App\Models\OrderStatus newQuery()
 * @method static Builder|\App\Models\OrderStatus query()
 * @method static Builder|\App\Models\OrderStatus whereAction($value)
 * @method static Builder|\App\Models\OrderStatus whereCreatedAt($value)
 * @method static Builder|\App\Models\OrderStatus whereDescription($value)
 * @method static Builder|\App\Models\OrderStatus whereId($value)
 * @method static Builder|\App\Models\OrderStatus whereName($value)
 * @method static Builder|\App\Models\OrderStatus whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $orders_count
 */
class OrderStatus extends Model
{
    const STATUS_PROCESSED = 'status.processed';
    const STATUS_SHIPPED = 'status.shipped';
    const STATUS_LIST = [
        self::STATUS_PROCESSED,
        self::STATUS_SHIPPED,
    ];
    public $fillable = [
        'name',
        'description',
        'action',
    ];
    public $connection = "mysql";
    protected $table = 'order_status';

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_status_to_order', 'status_id', 'order_id');
    }

    public function scopeByAction($obQuery, $sStatusAction = null)
    {
        if (empty($sStatusAction)) {
            return $obQuery;
        }

        return $obQuery->where('action', $sStatusAction);
    }

    public function toArray()
    {
        $this->makeHidden(['created_at', 'updated_at', 'pivot']);
        return $this->getArrayableAttributes();
    }
}