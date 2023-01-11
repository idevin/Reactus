<?php

namespace App\Models;

class NeoProductValue extends Neo4j
{
    public $timestamps = false;
    protected $label = 'ProductValue';
    protected $fillable = ['value'];
    protected $connection = 'neo4j';

    public function productAttribute()
    {
        return $this->belongsTo(NeoProductAttribute::class, 'VALUE_ATTRIBUTE');
    }
}