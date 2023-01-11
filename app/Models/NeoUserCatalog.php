<?php

namespace App\Models;

use App\Contracts\SiteMap;
use Ds\Vector;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Laudis\Neo4j\Exception\Neo4jException;
use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;
use Vinelab\NeoEloquent\Eloquent\Relations\HasOne;


/**
 * Class NeoUserCatalogData
 * @package App\Models
 *
 * @property string $url
 */
class NeoUserCatalog extends Neo4j implements SiteMap
{
    public static bool $absolute = false;
    public $timestamps = true;

    protected $label = 'Catalog';

    protected $fillable = ['user_id', 'catalog_views', 'cards_count', 'name', 'alias', 'site_id',
        'description', 'seo_title', 'seo_description', 'seo_h1', 'seo_keywords'];

    protected $connection = 'neo4j';

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [
        'created_at_formated',
        'updated_at_formated',
        'url'
    ];

    /**
     * @param $siteId
     * @param $userId
     * @param $id
     * @return bool
     * @throws Neo4jException
     */
    public static function getBySiteUserId($siteId, $userId, $id): bool
    {
        $query = 'MATCH (c:Catalog) WHERE ID(c)=' . (int)$id . ' 
        AND c.site_id=' . $siteId . ' AND c.user_id=' . $userId . ' return ID(c)';

        $result = Neo4j::client()->run($query);

        return count($result) > 0;
    }

    /**
     * @param $id
     * @return Vector
     */
    public static function deleteById($id): Vector
    {
        $query = 'MATCH (u:UserData) WHERE ID(u)=' . (int)$id . ' DETACH DELETE u';
        return Neo4j::client()->run($query);
    }

    public static function getFilter($request): array
    {
        $objectId = $request->get('object_id');

        $site = get_site();
        $user = Auth::user();

        $fields = Neo4j::client()->run("OPTIONAL MATCH (uc:Catalog)-[:USER_CATALOG]->(c:Catalog)-
        [:FIELD_GROUP]-(f2:FieldGroup)-[:FIELD]-(f4:Field) WHERE uc.user_id={$user->id} AND ID(uc)={$objectId}
        AND f4.use_in_filter=1 AND uc.site_id={$site->id} return f4, ID(f4)");

        if(count($fields) == 0) {
            return [
                'filter' => [],
                'sort_options' => NeoCard::$filter,
                'default_sort_options' => NeoCard::$defaultFilter
            ];
        }

        $ids = [];

        foreach($fields as $field) {
            $ids[] =  $field->get('ID(f4)');
        }

        $filter = NeoCatalogField::query()->with('values')->whereIn('id', $ids)->get();

        return [
            'filter' => $filter,
            'sort_options' => NeoCard::$filter,
            'default_sort_options' => NeoCard::$defaultFilter
        ];
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }

    public function getUpdatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->updated_at);
    }

    public function getUrlAttribute(): string
    {
        return route('objects.catalog.view', $this->url(), false);
    }

    public function url(): array
    {
        if ($this->alias) {
            $url = $this->alias;
        } else {
            $url = slugify($this->catalog_name);
        }
        $id = $this->id;

        return compact('url', 'id');
    }

    public function getApiUrlAttribute(): string
    {
        return route('api.objects.catalog.view', $this->url(), self::$absolute);
    }

    public function getObjectIdAttribute()
    {
        return $this->id;
    }

    #[ArrayShape(['loc' => "string"])]
    public function getSiteMapDATA(): array
    {
        return [
            'loc' => route('objects.catalog.front.view', [
                'url' => $this->alias,
                'id' => $this->id
            ]),
        ];
    }

    /**
     * @param Builder $query
     * @param Site $site
     * @return Collection
     */
    public function scopeGetSiteMapList(Builder $query, Site $site): Collection
    {
        return $query->whereSiteId($site->id)->get();
    }

    public function getCardsCountAttribute(): int
    {
        return $this->cards()->count();
    }

    public function cards(): HasMany
    {
        return $this->hasMany(NeoUserCard::class, 'CARD');
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(NeoCatalog::class, 'USER_CATALOG');
    }

    public function catalogPrototype(): HasOne
    {
        return $this->hasOne(NeoCatalog::class, 'USER_CATALOG');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(NeoCategory::class, 'CATEGORY');
    }
}