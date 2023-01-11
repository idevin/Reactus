<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\PasswordReset
 *
 * @property string|null $email
 * @property string $token
 * @property string $created_at
 * @property int $user_id
 * @property int $id
 * @property string|null $phone
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\PasswordReset whereCreatedAt($value)
 * @method static Builder|\App\Models\PasswordReset whereEmail($value)
 * @method static Builder|\App\Models\PasswordReset whereId($value)
 * @method static Builder|\App\Models\PasswordReset wherePhone($value)
 * @method static Builder|\App\Models\PasswordReset whereToken($value)
 * @method static Builder|\App\Models\PasswordReset whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\PasswordReset newModelQuery()
 * @method static Builder|\App\Models\PasswordReset newQuery()
 * @method static Builder|\App\Models\PasswordReset query()
 */
class PasswordReset extends Model
{
    public $timestamps = false;
    protected $table = 'password_reset';
    protected $connection = 'mysqlu';
    protected $fillable = ['user_id', 'email', 'token', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
