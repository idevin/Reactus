<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoCategory extends Neo4j
{
    public $timestamps = false;
    protected $label = 'Category';
    protected $fillable = ['title', 'description', 'alias', 'seo_title',
        'seo_description', 'seo_keywords', 'parent_id', 'user_id'];

    protected $connection = 'neo4j';

    protected $casts = ['parent_id' => 'integer'];

    public static function tree(&$nodes = null, &$depth = 0, array &$tree = [], array $with = [], array &$options = [])
    {
        if ($depth == 0) {

            $nodes = $options['parents'] ?? self::query()->whereNull('parent_id');

            if (!empty($with) && !isset($options['parents'])) {
                $nodes = $nodes->with($with);
            }
            if (!isset($options['parents'])) {
                $nodes = $nodes->get();
            }
        }

        foreach ($nodes as $node) {

            $tree[$node->id] = $node;

            $children = $node->children();

            if (!empty($with)) {
                $children = $children->with($with);
            }

            $children = $children->get();

            if (count($children) > 0) {
                $depth += 1;
                self::tree($node->children, $depth, $tree, $with, $options);
            } else {
                $depth = 0;
            }
        }

        return $nodes;
    }

    /**
     * @param string $categoryId
     * @param $card
     * @return bool
     */
    public static function sync(string $categoryId, $card): bool
    {
        $cql = "OPTIONAL MATCH (n:Card)-[l:CATEGORY]-(c:Category) WHERE ID(n)={$card->id} return ID(c)";
        $oldCategories = Neo4j::client()->run($cql);
        $oldCategoriesArray = [];

        $categoryIds = json_decode($categoryId, true);

        if (!empty($categoryIds)) {

            $cql = "MATCH (c:Category) WHERE ID(c) IN [" . implode(',', $categoryIds) . "] return count(c) as count";
            $foundCategories = Neo4j::client()->run($cql);

            if ($foundCategories[0]->get('count') != count($categoryIds)) {
                return false;
            }

            if (count($oldCategories) > 0) {
                foreach ($oldCategories as $oldCategory) {
                    $oldCategoriesArray[] = $oldCategory->get('ID(c)');
                }
            }

            $categoriesToAttach = array_diff($categoryIds, $oldCategoriesArray);
            $categoriesToDetach = array_diff($oldCategoriesArray, $categoryIds);

            if (count($categoriesToDetach) > 0) {
                $categoriesToDetach = array_values($categoriesToDetach);

                if (!empty($categoriesToDetach)) {
                    $detachString = implode(',', $categoriesToDetach);

                    if (!empty($detachString)) {
                        $cql = "OPTIONAL MATCH (n:Card)-[c1:CATEGORY]-(c:Category)-
                [c2:CATEGORY]-(m:Catalog) WHERE ID(n)={$card->id} AND ID(c) IN [{$detachString}] DELETE c1,c2";

                        Neo4j::client()->run($cql);
                    }
                }
            }

            if (count($categoriesToAttach) > 0) {

                $categoriesToAttach = array_values($categoriesToAttach);

                $attachString = implode(',', $categoriesToAttach);

                if (!empty($attachString)) {
                    $cql = "OPTIONAL MATCH (n:Card)-[n2:CARD]-(m:Catalog), (c:Category) WHERE ID(c) IN [{$attachString}] 
                    AND ID(n)={$card->id} MERGE (c)-[a:CATEGORY]->(m) MERGE (c)-[b:CATEGORY]->(n)";

                    Neo4j::client()->run($cql);
                }
            }
        }

        return true;
    }

    public function catalogs(): HasMany
    {
        return $this->hasMany(NeoUserCatalog::class, 'CATEGORY');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NeoCategory::class, 'CATEGORY');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(NeoCategory::class, 'CATEGORY');
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(NeoUserCard::class, 'CATEGORY');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NeoCategory::class, 'CATEGORY');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(NeoUserCard::class, 'CATEGORY');
    }

    public function children(): HasMany
    {
        return $this->hasMany(NeoCategory::class, 'CATEGORY');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(NeoCategory::class, 'CATEGORY');
    }

    public function scopeByUser($query, int $id)
    {
        return $query->whereUserId($id);
    }
}