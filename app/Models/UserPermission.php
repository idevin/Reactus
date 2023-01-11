<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserPermission
 *
 * @property int $user_id
 * @property int $permission_id
 * @property int|null $own
 * @property int $other
 * @property-read \App\Models\Permission $permission
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\UserPermission whereOther($value)
 * @method static Builder|\App\Models\UserPermission whereOwn($value)
 * @method static Builder|\App\Models\UserPermission wherePermissionId($value)
 * @method static Builder|\App\Models\UserPermission whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\UserPermission newModelQuery()
 * @method static Builder|\App\Models\UserPermission newQuery()
 * @method static Builder|\App\Models\UserPermission query()
 */
class UserPermission extends Model
{
    public $timestamps = false;
    protected $connection = 'mysqlu';
    protected $table = 'user_permission';
    protected $fillable = [
        'user_id',
        'permission_id',
        'own',
        'other'
    ];

    /**
     * A role may be given various permissions.
     *
     * @return BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * A role may be assigned to various users.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPermissionAttribute()
    {
        return $this->permission;
    }

    public function getUserAttribute()
    {
        return $this->user;
    }
}
