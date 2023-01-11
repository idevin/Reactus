<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $annotation
 * @property-read Collection|\App\Models\User[] $users
 * @property-read Collection|\App\Models\Role[] $roles
 * @method static Builder|\App\Models\Permission whereAnnotation($value)
 * @method static Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static Builder|\App\Models\Permission whereDescription($value)
 * @method static Builder|\App\Models\Permission whereId($value)
 * @method static Builder|\App\Models\Permission whereName($value)
 * @method static Builder|\App\Models\Permission whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\Permission newModelQuery()
 * @method static Builder|\App\Models\Permission newQuery()
 * @method static Builder|\App\Models\Permission query()
 * @property-read int|null $roles_count
 */
class Permission extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    protected $fillable = [
        'name',
        'description',
        'annotation'
    ];

    protected $connection = 'mysqlu';

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('permission.table_names.permissions'));
    }

    /**
     * Find a permission by its name.
     *
     * @param string $name
     *
     * @return Model|null|static
     */
    public static function findByName($name)
    {
        $permission = static::where('name', $name)->first();

        if (!$permission) {
            return null;
        }

        return $permission;
    }

    public static function getByName($permission, $strict = true)
    {

        if ($strict == true) {
            $query = self::where('name', $permission);
        } else {
            $query = self::where('name', 'like', '%' . $permission . '%');
        }

        $permission = $query->get()->first();

        if ($permission) {
            return $permission;
        }

        return null;
    }

    /**
     * A permission can be applied to roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.role_has_permissions')
        );
    }
}
