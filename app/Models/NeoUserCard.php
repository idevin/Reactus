<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoUserCard extends Neo4j
{
    public $timestamps = false;
    protected $label = 'Card';

    protected $fillable = ['title', 'description', 'seo_title', 'seo_description', 'seo_h1',
        'seo_keywords', 'views', 'alias', 'hidden', 'user_id'];

    protected $connection = 'neo4j';
    protected $appends = ['url'];


    public function categories(): HasMany
    {
        return $this->hasMany(NeoCategory::class, 'CATEGORY');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NeoCategory::class, 'CATEGORY');
    }

    public function catalogs(): BelongsTo
    {
        return $this->belongsTo(NeoUserCatalog::class, 'CATALOG');
    }

    public function userFieldGroups(): HasMany
    {
        return $this->hasMany(NeoUserFieldGroup::class, 'USER_FIELD_GROUP');
    }

    public function getUrlAttribute(): array
    {
        if ($this->alias) {
            $url = $this->alias;
        } else {
            $url = slugify($this->title);
        }
        $id = $this->id;

        return compact('url', 'id');
    }

    public function scopeByUser($query, $id)
    {

    }
}