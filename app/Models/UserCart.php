<?php

namespace App\Models;

use App\Traits\NeoObject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * App\Models\UserCart
 *
 * @property int $user_id
 * @property int $id
 * @property int $object_id
 * @property string $price
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static Builder|UserCart byUser(int $id)
 * @method static Builder|UserCart newModelQuery()
 * @method static Builder|UserCart newQuery()
 * @method static Builder|UserCart query()
 * @method static Builder|UserCart whereCount($value)
 * @method static Builder|UserCart whereCreatedAt($value)
 * @method static Builder|UserCart whereId($value)
 * @method static Builder|UserCart whereObjectId($value)
 * @method static Builder|UserCart wherePrice($value)
 * @method static Builder|UserCart whereUpdatedAt($value)
 * @method static Builder|UserCart whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null $object
 */
class UserCart extends Model
{
    use NeoObject;

    public $timestamps = true;
    protected $connection = 'mysqlu';
    protected $table = 'user_cart';
    protected $fillable = ['user_id', 'object_id', 'price', 'count'];
    protected $appends = ['object'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getObjectAttribute(): Model|Collection|Builder|array|null
    {
        $card = self::getCard(['id' => $this->object_id]);

        if ($card instanceof JsonResponse) {
            return null;
        }

        return $card;
    }

    public function scopeByUser(Builder $query, int $id): Builder
    {
        return $query->where([
            'user_id' => $id
        ]);
    }
}
