<?php

namespace App\Models;

use App\Traits\ObjectField;
use Baum\Node;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ObjectFieldGroup
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $multi_field 0-false, 1-true
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int $id
 * @property-read \Baum\Extensions\Eloquent\Collection|ObjectFieldGroup[] $children
 * @property-read Collection|ObjectField[] $fields
 * @property-read ObjectFieldGroup|null $parent
 * @method static Builder|Node limitDepth($limit)
 * @method static Builder|ObjectFieldGroup newModelQuery()
 * @method static Builder|ObjectFieldGroup newQuery()
 * @method static Builder|ObjectFieldGroup query()
 * @method static Builder|ObjectFieldGroup whereCreatedAt($value)
 * @method static Builder|ObjectFieldGroup whereDepth($value)
 * @method static Builder|ObjectFieldGroup whereId($value)
 * @method static Builder|ObjectFieldGroup whereLft($value)
 * @method static Builder|ObjectFieldGroup whereMultiField($value)
 * @method static Builder|ObjectFieldGroup whereName($value)
 * @method static Builder|ObjectFieldGroup whereParentId($value)
 * @method static Builder|ObjectFieldGroup whereRgt($value)
 * @method static Builder|ObjectFieldGroup whereUpdatedAt($value)
 * @method static Builder|Node withoutNode($node)
 * @method static Builder|Node withoutRoot()
 * @method static Builder|Node withoutSelf()
 * @mixin Eloquent
 * @property-read int|null $children_count
 * @property-read int|null $fields_count
 * @method static \Baum\Extensions\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Baum\Extensions\Eloquent\Collection|static[] get($columns = ['*'])
 */
class ObjectFieldGroup extends Node
{
    use ObjectField;

    public $timestamps = true;

    protected $table = 'object_field_group';
    protected $fillable = ['name', 'multi_field', 'id', 'parent_id'];
    protected $connection = 'mysql';

    public static function getTree($withEmptyValue = false, $withRoot = true): array
    {
       return self::tree(static::roots()->get(), $withEmptyValue, $withRoot);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(ObjectField::class);
    }
}