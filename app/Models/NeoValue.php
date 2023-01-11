<?php

namespace App\Models;

use App\Traits\Objects;
use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;

class NeoValue extends Neo4j
{
    use Objects;

    public $timestamps = false;
    public $connection = 'neo4j';

    protected $label = 'Value';
    protected $fillable = [];

    public function field(): BelongsTo
    {
        return $this->belongsTo(NeoField::class);
    }
}