<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\PasswordHistory
 *
 * @property integer $id
 * @property string $created_at
 * @property string $password_hash
 * @property boolean $reset_via
 * @property integer $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PasswordHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PasswordHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PasswordHistory wherePasswordHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PasswordHistory whereResetVia($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PasswordHistory whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\PasswordHistory newModelQuery()
 * @method static Builder|\App\Models\PasswordHistory newQuery()
 * @method static Builder|\App\Models\PasswordHistory query()
 */
class PasswordHistory extends Model
{
    const RESET_PSW_VIA_EMAIL = 0;
    const RESET_PSW_VIA_SMS = 1;
    public $timestamps = false;
    protected $table = 'password_history';
    protected $connection = 'mysqlu';
    protected $fillable = ['reset_via', 'password_hash'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
