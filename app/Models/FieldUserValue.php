<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\FieldUserValue
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $field_user_group_id
 * @property int $site_id
 * @property string|null $value
 * @property string|null $visibility
 * @property int $field_id
 * @property-read \App\Models\Field $field
 * @property-read \App\Models\FieldGroup $field_group
 * @property-read \App\Models\FieldUserGroup $field_user_group
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\FieldUserValue newModelQuery()
 * @method static Builder|\App\Models\FieldUserValue newQuery()
 * @method static Builder|\App\Models\FieldUserValue query()
 * @method static Builder|\App\Models\FieldUserValue whereCreatedAt($value)
 * @method static Builder|\App\Models\FieldUserValue whereFieldId($value)
 * @method static Builder|\App\Models\FieldUserValue whereFieldUserGroupId($value)
 * @method static Builder|\App\Models\FieldUserValue whereId($value)
 * @method static Builder|\App\Models\FieldUserValue whereSiteId($value)
 * @method static Builder|\App\Models\FieldUserValue whereUpdatedAt($value)
 * @method static Builder|\App\Models\FieldUserValue whereUserId($value)
 * @method static Builder|\App\Models\FieldUserValue whereValue($value)
 * @method static Builder|\App\Models\FieldUserValue whereVisibility($value)
 * @mixin Eloquent
 */
class FieldUserValue extends Model
{
    const VISIBILITY_ALL = 0;
    const VISIBILITY_ME = 1;
    public $timestamps = true;
    protected $table = 'field_user_value';
    protected $fillable = ['field_user_group_id', 'value', 'user_id', 'site_id', 'field_id', 'visibility'];

    public function field_user_group()
    {
        return $this->belongsTo(FieldUserGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function field_group()
    {
        return $this->belongsTo(FieldGroup::class);
    }
}
