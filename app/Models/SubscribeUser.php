<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SubscribeUser
 *
 * @property int $id
 * @property int $subscribed_user_id
 * @property int $on_user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $onUser
 * @property-read \App\Models\User $subscribedUser
 * @method static Builder|\App\Models\SubscribeUser whereCreatedAt($value)
 * @method static Builder|\App\Models\SubscribeUser whereId($value)
 * @method static Builder|\App\Models\SubscribeUser whereOnUserId($value)
 * @method static Builder|\App\Models\SubscribeUser whereSubscribedUserId($value)
 * @method static Builder|\App\Models\SubscribeUser whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\SubscribeUser newModelQuery()
 * @method static Builder|\App\Models\SubscribeUser newQuery()
 * @method static Builder|\App\Models\SubscribeUser query()
 */
class SubscribeUser extends Model
{
    protected $connection = 'mysql';
    protected $table = 'subscribe_users';
    protected $fillable = [
        'subscribed_user_id', 'on_user_id'
    ];

    public function subscribedUser()
    {
        return $this->belongsTo(User::class, 'subscribed_user_id');
    }

    public function onUser()
    {
        return $this->belongsTo(User::class, 'on_user_id');
    }
}