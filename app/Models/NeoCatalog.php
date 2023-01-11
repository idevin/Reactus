<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

/**
 * @property mixed|string alias
 * @property mixed name
 */
class NeoCatalog extends Neo4j
{
    public $timestamps = false;
    protected $label = 'Catalog';
    protected $fillable = ['name', 'alias'];
    protected $connection = 'neo4j';

    public function save(array $options = []): bool
    {
        $this->alias = self::getAlias($this->name);

        return parent::save($options);
    }

    public static function getAlias(string $name): string
    {
        return slugify($name);
    }

    public function fieldGroups(): HasMany
    {
        return $this->hasMany(NeoCatalogFieldGroup::class, 'FIELD_GROUP')->orderBy('sort_order');
    }

    public function userCatalogs(): HasMany
    {
        return $this->hasMany(NeoUserCatalog::class, 'USER_CATALOG');
    }

    public function userCatalog(): BelongsTo
    {
        return $this->belongsTo(NeoUserCatalog::class, 'USER_CATALOG');
    }
}