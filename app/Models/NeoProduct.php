<?php

namespace App\Models;

class NeoProduct extends Neo4j
{
    public $timestamps = false;
    protected $label = 'Product';
    protected $fillable = ['name'];
    protected $connection = 'neo4j';

    public function category()
    {
        return $this->belongsTo(NeoCategory::class, 'PRODUCT');
    }

    public function productValues()
    {
        return $this->hasMany(NeoProductValue::class, 'PRODUCT_VALUE');
    }
}