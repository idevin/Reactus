<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;

class NeoCatalogFieldValue extends Neo4j
{
    public $timestamps = false;
    protected $label = 'Value';
    protected $fillable = ['value', 'sort_order'];
    protected $connection = 'neo4j';

    protected $hidden = ['field'];

    public function field(): BelongsTo
    {
        return $this->belongsTo(NeoCatalogField::class, 'RELATED');
    }
}