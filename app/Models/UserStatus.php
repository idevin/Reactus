<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserStatus
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $user_status_emotion_id
 * @property-read mixed $created_at_formated
 * @property-read \App\Models\User $user
 * @property-read \App\Models\UserStatusEmotion|null $userStatusEmotion
 * @method static Builder|\App\Models\UserStatus newModelQuery()
 * @method static Builder|\App\Models\UserStatus newQuery()
 * @method static Builder|\App\Models\UserStatus query()
 * @method static Builder|\App\Models\UserStatus whereCreatedAt($value)
 * @method static Builder|\App\Models\UserStatus whereId($value)
 * @method static Builder|\App\Models\UserStatus whereStatus($value)
 * @method static Builder|\App\Models\UserStatus whereUpdatedAt($value)
 * @method static Builder|\App\Models\UserStatus whereUserId($value)
 * @method static Builder|\App\Models\UserStatus whereUserStatusEmotionId($value)
 * @mixin Eloquent
 */
class UserStatus extends Model
{
    public $timestamps = true;
    public $hidden = [
        'updated_at'
    ];
    protected $table = 'user_status';
    protected $connection = 'mysqlu';
    protected $fillable = ['user_id', 'status', 'user_status_emotion_id'];
    protected $appends = [
        'created_at_formated'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userStatusEmotion(): BelongsTo
    {
        return $this->belongsTo(UserStatusEmotion::class);
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }
}