<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserRole
 *
 * @property int $role_id
 * @property int $user_id
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\UserRole newModelQuery()
 * @method static Builder|\App\Models\UserRole newQuery()
 * @method static Builder|\App\Models\UserRole query()
 * @method static Builder|\App\Models\UserRole whereRoleId($value)
 * @method static Builder|\App\Models\UserRole whereUserId($value)
 * @mixin Eloquent
 */
class UserRole extends Model
{
    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'user_role';
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
