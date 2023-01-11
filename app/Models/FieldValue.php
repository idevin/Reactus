<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FieldValue
 *
 * @property int $id
 * @property int $field_id
 * @property string $value
 * @property int|null $sort_order
 * @property-read \App\Models\Field $field
 * @method static Builder|\App\Models\FieldValue newModelQuery()
 * @method static Builder|\App\Models\FieldValue newQuery()
 * @method static Builder|\App\Models\FieldValue query()
 * @method static Builder|\App\Models\FieldValue whereFieldId($value)
 * @method static Builder|\App\Models\FieldValue whereId($value)
 * @method static Builder|\App\Models\FieldValue whereSortOrder($value)
 * @method static Builder|\App\Models\FieldValue whereValue($value)
 * @mixin Eloquent
 */
class FieldValue extends Model
{
    public $timestamps = false;
    protected $table = 'field_value';
    protected $fillable = ['field_id', 'value', 'sort_order'];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}
