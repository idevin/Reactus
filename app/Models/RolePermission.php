<?php

namespace App\Models;

use App\Traits\SyncUserPermissions;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RolePermission
 *
 * @property int $permission_id
 * @property int $role_id
 * @property int|null $own
 * @property int $other
 * @property-read Permission $permission
 * @property-read Role $role
 * @method static Builder|RolePermission whereOther($value)
 * @method static Builder|RolePermission whereOwn($value)
 * @method static Builder|RolePermission wherePermissionId($value)
 * @method static Builder|RolePermission whereRoleId($value)
 * @mixin Eloquent
 * @method static Builder|RolePermission newModelQuery()
 * @method static Builder|RolePermission newQuery()
 * @method static Builder|RolePermission query()
 */
class RolePermission extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $timestamps = false;

    protected $connection = 'mysqlu';
    protected $table = 'role_permission';
    protected $fillable = [
        'role_id', 'permission_id', 'own', 'other'
    ];


    /**
     * A role may be given various permissions.
     *
     * @return BelongsTo
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * A role may be assigned to various users.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
