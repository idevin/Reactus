<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\UserSocial
 *
 * @property int $id
 * @property string|null $uid
 * @property int $user_id
 * @property string $token
 * @property int|null $expires
 * @property string|null $refresh_token
 * @property string|null $name
 * @property string|null $email
 * @property string|null $nickname
 * @property string $provider
 * @property string|null $first_name
 * @property string|null $last_name
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\UserSocial whereEmail($value)
 * @method static Builder|\App\Models\UserSocial whereExpires($value)
 * @method static Builder|\App\Models\UserSocial whereFirstName($value)
 * @method static Builder|\App\Models\UserSocial whereId($value)
 * @method static Builder|\App\Models\UserSocial whereLastName($value)
 * @method static Builder|\App\Models\UserSocial whereName($value)
 * @method static Builder|\App\Models\UserSocial whereNickname($value)
 * @method static Builder|\App\Models\UserSocial whereProvider($value)
 * @method static Builder|\App\Models\UserSocial whereRefreshToken($value)
 * @method static Builder|\App\Models\UserSocial whereToken($value)
 * @method static Builder|\App\Models\UserSocial whereUid($value)
 * @method static Builder|\App\Models\UserSocial whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\UserSocial newModelQuery()
 * @method static Builder|\App\Models\UserSocial newQuery()
 * @method static Builder|\App\Models\UserSocial query()
 */
class UserSocial extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'uid', 'user_id', 'token', 'expires', 'email', 'refresh_token', 'name',
        'nickname', 'provider', 'first_name', 'last_name'
    ];

    protected $table = 'user_social';
    protected $connection = 'mysqlu';

    public static function getProvider($userId, $provider)
    {
        return self::where('user_id', $userId)->where('provider', $provider)->first();
    }

    public static function byUid($uid, $provider)
    {
        return self::where('uid', $uid)->where('provider', $provider)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
