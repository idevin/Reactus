<?php

namespace App\Models;

use App\Models\Modules\ModuleFeedback;
use App\Traits\ObjectField;
use Baum\Node;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\FieldGroup
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $multi_field 0-false, 1-true
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int $for_module
 * @property \Baum\Extensions\Eloquent\Collection|FieldGroup[] $children
 * @property Collection|FieldUserGroup[] $field_user_groups
 * @property ModuleFeedback $moduleFeedback
 * @property FieldGroup|null $parent
 * @method static Builder|Node limitDepth($limit)
 * @method static Builder|FieldGroup newModelQuery()
 * @method static Builder|FieldGroup newQuery()
 * @method static Builder|FieldGroup query()
 * @method static Builder|FieldGroup whereCreatedAt($value)
 * @method static Builder|FieldGroup whereDepth($value)
 * @method static Builder|FieldGroup whereForModule($value)
 * @method static Builder|FieldGroup whereId($value)
 * @method static Builder|FieldGroup whereLft($value)
 * @method static Builder|FieldGroup whereMultiField($value)
 * @method static Builder|FieldGroup whereName($value)
 * @method static Builder|FieldGroup whereParentId($value)
 * @method static Builder|FieldGroup whereRgt($value)
 * @method static Builder|FieldGroup whereUpdatedAt($value)
 * @method static Builder|Node withoutNode($node)
 * @method static Builder|Node withoutRoot()
 * @method static Builder|Node withoutSelf()
 * @mixin Eloquent
 * @property int|null $children_count
 * @property int|null $field_user_groups_count
 * @property int|null $fields_count
 * @property Collection|\App\Models\Field[] $fields
 * @method static \Baum\Extensions\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Baum\Extensions\Eloquent\Collection|static[] get($columns = ['*'])
 */
class FieldGroup extends Node
{
    use ObjectField;

    public $timestamps = true;

    protected $table = 'field_group';

    protected $fillable = ['name', 'multi_field', 'id', 'parent_id', 'for_module', 'registration'];

    public static function getTree($withEmptyValue = false, $withRoot = true, $forModule = false): array
    {
        if (!$forModule) {
            $nodes = static::roots()->get();
        } else {
            $nodes = self::query()->where('for_module', 1)->get();
        }

        return self::tree($withEmptyValue, $withRoot, $nodes);
    }

    public static function homepage($user = null): Collection|array
    {
        return self::with(['fields'])->whereHas('field_user_groups', callback: function ($query) use ($user) {
            if ($user) {
                $query->whereOnHomepage(1)->whereUserId($user->id);
            } else {
                $query->whereOnHomepage(1);
            }
        })->get();
    }

    public function field_user_groups(): HasMany
    {
        return $this->hasMany(FieldUserGroup::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class)->orderBy('sort_order');
    }

    public function moduleFeedback(): HasOne
    {
        return $this->hasOne(ModuleFeedback::class);
    }
}