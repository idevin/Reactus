<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoFieldGroup extends Neo4j
{
    public $timestamps = false;
    protected $label = 'FieldGroup';
    protected $fillable = ['title, description, sort_order'];
    protected $connection = 'neo4j';

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(NeoCatalog::class, 'FIELD_GROUP');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(NeoField::class, 'FIELD');
    }
}