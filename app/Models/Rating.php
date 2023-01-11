<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Rating
 *
 * @property int $id
 * @property int $user_id
 * @property int $object_id
 * @property string $object
 * @property int $rating_value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\Rating whereCreatedAt($value)
 * @method static Builder|\App\Models\Rating whereId($value)
 * @method static Builder|\App\Models\Rating whereObject($value)
 * @method static Builder|\App\Models\Rating whereObjectId($value)
 * @method static Builder|\App\Models\Rating whereRatingValue($value)
 * @method static Builder|\App\Models\Rating whereUpdatedAt($value)
 * @method static Builder|\App\Models\Rating whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\Rating newModelQuery()
 * @method static Builder|\App\Models\Rating newQuery()
 * @method static Builder|\App\Models\Rating query()
 */
class Rating extends Model
{
    protected $table = 'rating';

    protected $fillable = ['user_id', 'object', 'object_id', 'rating_value'];

    public static function getValue($o)
    {
        return Rating::where('object', get_class($o))
            ->where('object_id', $o->id)->sum('rating_value');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}