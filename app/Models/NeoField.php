<?php

namespace App\Models;

use App\Traits\Objects;
use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoField extends Neo4j
{
    use Objects;

    public $timestamps = false;
    public $connection = 'neo4j';

    protected $label = 'Field';
    protected $fillable = [];

    public function relatedField(): BelongsTo
    {
        return $this->belongsTo(NeoCatalogField::class, 'RELATED');
    }
}