<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserStatusEmotion
 *
 * @property int $id
 * @property string $name
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\UserStatusEmotion newModelQuery()
 * @method static Builder|\App\Models\UserStatusEmotion newQuery()
 * @method static Builder|\App\Models\UserStatusEmotion query()
 * @method static Builder|\App\Models\UserStatusEmotion whereId($value)
 * @method static Builder|\App\Models\UserStatusEmotion whereName($value)
 * @mixin Eloquent
 */
class UserStatusEmotion extends Model
{
    public $timestamps = false;
    protected $table = 'user_status_emotion';
    protected $connection = 'mysqlu';

    protected $fillable = ['name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}