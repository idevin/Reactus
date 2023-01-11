<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ObjectFieldValue
 *
 * @property int $id
 * @property int $object_field_id
 * @property string|null $value
 * @property string|null $data_node_id
 * @property-read ObjectField $objectField
 * @method static Builder|ObjectFieldValue newModelQuery()
 * @method static Builder|ObjectFieldValue newQuery()
 * @method static Builder|ObjectFieldValue query()
 * @method static Builder|ObjectFieldValue whereDataNodeId($value)
 * @method static Builder|ObjectFieldValue whereId($value)
 * @method static Builder|ObjectFieldValue whereObjectFieldId($value)
 * @method static Builder|ObjectFieldValue whereValue($value)
 * @mixin Eloquent
 */
class ObjectFieldValue extends Model
{
    public $timestamps = false;
    protected $table = 'object_field_value';
    protected $fillable = ['object_field_id', 'value', 'data_node_id'];

    public function objectField(): BelongsTo
    {
        return $this->belongsTo(ObjectField::class);
    }

    public function node()
    {
        return NeoCatalog::query()->find($this->data_node_id);
    }
}
