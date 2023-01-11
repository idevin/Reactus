<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoCatalogFieldGroup extends Neo4j
{
    public static array $tree = [];
    public static array $ids = [];
    public $timestamps = false;
    public $connection = 'neo4j';
    protected $label = 'FieldGroup';
    protected $fillable = ['title', 'description', 'sort_order'];

    public static function getTree($items, $depth = 0): array
    {
        if (count($items) > 0) {
            foreach ($items as $item) {
                self::$tree[$item->id] = '';

                self::$tree[$item->id] .= $item->title;

                if ($item->objectFieldGroups && count($item->objectFieldGroups) > 0) {
                    $depth += 1;
                }
            }
        }

        return self::$tree;
    }

    public function fields(): HasMany
    {
        return $this->hasMany(NeoCatalogField::class, 'FIELD')->orderBy('sort_order');
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(NeoCatalog::class, 'FIELD_GROUP');
    }
}