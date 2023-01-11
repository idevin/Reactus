<?php

namespace App\Models;

use App\Exceptions\RoleDoesNotExist;
use App\Traits\HasPermissions;
use App\Traits\SyncUserPermissions;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_default
 * @property int|null $for_registered
 * @property-read Collection|Permission[] $permissions
 * @property-read Collection|User[] $users
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereForRegistered($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereIsDefault($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int|null $is_anon
 * @property int $is_root
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereIsAnon($value)
 * @method static Builder|Role whereIsRoot($value)
 * @property-read int|null $permissions_count
 * @property-read int|null $users_count
 */
class Role extends Model
{
    use HasPermissions;

    public $guarded = ['id'];

    protected $connection = 'mysqlu';

    protected $fillable = [
        'name', 'description', 'is_default', 'for_registered', 'is_anon', 'is_root'
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('permission.table_names.roles'));
    }

    /**
     * Find a role by its name.
     *
     * @param string $name
     *
     * @return Role
     * @throws RoleDoesNotExist
     *
     */
    public static function findByName($name): Role
    {
        $role = static::whereName($name)->first();

        if (!$role) {
            throw new RoleDoesNotExist();
        }

        return $role;
    }

    public static function selectOptions($notId = null, $empty = false): array
    {
        $data = self::orderBy('description', 'ASC');

        if ($notId) {
            $data = $data->whereNotIn('id', [$notId]);
        }

        $data = $data->get();

        if ($empty == true) {
            $allData = [null => 'Выберите роль...'];
        } else {
            $allData = [];
        }

        foreach ($data as $object) {
            $allData[$object->id] = $object->description;
        }

        return $allData;
    }

    /**
     * A role may be assigned to various users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            config('auth.model') ?: config('auth.providers.users.model'),
            config('permission.table_names.user_has_roles')
        );
    }

    /**
     * @param string|Permission $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::findByName($permission);
        }

        return $this->permissions->contains('id', $permission->id);
    }

    public function syncPermissions($permissionIds)
    {
        $this->permissions()->sync($permissionIds);
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions')
        )->withPivot(['own', 'other']);
    }
}
