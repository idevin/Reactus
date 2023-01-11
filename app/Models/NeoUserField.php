<?php

namespace App\Models;

use App\Models\Helpers\FieldDecorator\Decorator;
use App\Traits\Objects;
use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasOne;

class NeoUserField extends Neo4j
{
    use Objects;

    public $timestamps = false;
    public $connection = 'neo4j';

    protected $label = 'UserField';
    protected $fillable = ['value', 'use_in_filter', 'use_in_catalog_list', 'hidden'];

    protected $appends = ['value'];

    protected $casts = [
        'hidden' => 'integer',
        'use_in_filter' => 'integer',
        'use_in_catalog_list' => 'integer'
    ];

    public function field(): BelongsTo
    {
        return $this->belongsTo(NeoCatalogField::class, 'RELATED_FIELD');
    }

    public function fieldPrototype(): HasOne
    {
        return $this->hasOne(NeoCatalogField::class, 'RELATED_FIELD');
    }

    public function userFieldGroup(): HasOne
    {
        return $this->hasOne(NeoUserFieldGroup::class, 'USER_FIELD');
    }

    public function getValueAttribute()
    {
        $decorator = (new Decorator($this->fieldPrototype, $this->attributes['value'], NeoCatalogField::class));
        return $decorator->decorate();
    }
}