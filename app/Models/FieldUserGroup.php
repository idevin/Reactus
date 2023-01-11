<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\FieldUserGroup
 *
 * @property int $id
 * @property int $field_group_id
 * @property int $user_id
 * @property int $visibility
 * @property int $on_homepage
 * @property-read \App\Models\FieldGroup $field_group
 * @property-read Collection|\App\Models\FieldUserValue[] $field_user_values
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\FieldUserGroup newModelQuery()
 * @method static Builder|\App\Models\FieldUserGroup newQuery()
 * @method static Builder|\App\Models\FieldUserGroup query()
 * @method static Builder|\App\Models\FieldUserGroup whereFieldGroupId($value)
 * @method static Builder|\App\Models\FieldUserGroup whereId($value)
 * @method static Builder|\App\Models\FieldUserGroup whereOnHomepage($value)
 * @method static Builder|\App\Models\FieldUserGroup whereUserId($value)
 * @method static Builder|\App\Models\FieldUserGroup whereVisibility($value)
 * @mixin Eloquent
 * @property-read int|null $field_user_values_count
 */
class FieldUserGroup extends Model
{
    public $timestamps = false;
    protected $table = 'field_user_group';
    protected $fillable = ['field_group_id', 'visibility', 'user_id', 'on_homepage'];


    public function field_group()
    {
        return $this->belongsTo(FieldGroup::class);
    }

    public function field_user_values()
    {
        return $this->hasMany(FieldUserValue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
