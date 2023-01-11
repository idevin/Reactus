<?php

namespace App\Models;

use App\Contracts\SiteMap;
use App\Traits\NeoObject as NeoObjectAlias;
use App\Traits\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Phpml\Association\Apriori;
use Symfony\Component\HttpFoundation\JsonResponse;
use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class NeoCard extends Neo4j implements SiteMap
{
    use Response;

    const FILTER_VIEWS = 'views';
    const FILTER_NAME = 'name';

    public static array $filter = [
        self::FILTER_VIEWS => 'По количеству просмотров',
        self::FILTER_NAME => 'По названию'
    ];

    public static array $defaultFilter = [
        'sort' => self::FILTER_NAME,
        'order' => 'asc'
    ];

    public static array $treeRlations = [
        0 => 'PARENT',
        1 => 'CHILD',
        2 => 'BROTHER_SISTER',
        3 => 'WIFE_HUSBAND'
    ];
    public static bool $absolute = false;
    public $connection = 'neo4j';
    protected $label = 'Card';

    protected $fillable = ['name', 'views', 'seo_title', 'seo_description', 'seo_h1',
        'no_parent', 'hidden', 'revision', 'seo_slug'];

    protected $appends = ['url', 'created_at_formated', 'updated_at_formated'];

    public static function generateUuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function setName($object, $object2): string
    {
        return encrypt($object->id . $object2->id, false);
    }

    /**
     * @param $neoCard
     * @param $response
     * @return array|JsonResponse
     */
    public static function relatedV1($neoCard, $response): JsonResponse|array
    {

        $result = self::checkCatalogData($neoCard, $response);

        if ($result['error'] != null) {
            return $result['error'];
        }

        $catalog = NeoObjectAlias::getCatalog($result['request']);

        if (!is_array($catalog)) {
            return $catalog;
        }

        $catalog['pagination'] = $catalog['pagination']->toArray();

        if (count($catalog['pagination']['data']) > 0) {
            foreach ($catalog['pagination']['data'] as $i => $item) {
                if ($item['id'] == $neoCard->id) {
                    unset($catalog['pagination']['data'][$i]);

                }
            }
        }
        $catalog['pagination']['data'] = array_values($catalog['pagination']['data']);
        return $response->success($catalog);
    }

    public static function checkCatalogData($neoCard, $response): array
    {
        $error = null;

        $userCatalogData = $neoCard->userCatalogData;

        if (!$userCatalogData) {
            $error = $response->error('Каталог не найден');
        }

        if (!$userCatalogData->object) {
            $error = $response->error('Такого каталога с карточками нет');
        }

        $request = request()->query->add([
            'object_id' => $userCatalogData->id
        ]);

        return compact('request', 'error');
    }

    /**
     * @param $neoCard
     * @param $response
     * @return array|JsonResponse
     */
    public static function relatedV2($neoCard, $response): JsonResponse|array
    {
        $values = [
            'samples' => [],
            'labels' => []
        ];

        foreach ($neoCard->fieldUserGroups as $group) {

            foreach ($group->fields as $field) {
                if (!empty($field->value)) {
                    if ($field->value && !is_array($field->value) && !is_object($field->value)) {
                        $field->value = match ($field->field_type['id']) {
                            NeoCatalogField::FIELD_TYPE_TARIFF_PRICE => array_map(function ($e) {
                                return array_filter(array_values((array)$e));
                            }, $field->value),
                        };
                        $values['labels'][] = $field->value;
                    }
                }
            }
            $values['labels'] = array_values($values['labels']);
        }

        $result = self::checkCatalogData($neoCard, $response);

        if ($result['error'] != null) {
            return $result['error'];
        }

        $catalog = NeoObjectAlias::getCatalog($result['request'], null, false);

        if (!is_array($catalog)) {
            return $catalog;
        }

        foreach ($catalog['cards'] as $card) {
            if ($card['id'] != $neoCard->id) {
                $values['samples'][$card['id']] = [$card['id']];

                foreach ($card['field_user_groups'] as $group) {
                    foreach ($group['fields'] as $field) {
                        if ($field['data'] && !is_array($field['data']) && !is_object($field['data'])) {

                            $field['data'] = match ($field['field_type']['id']) {
                                NeoCatalogField::FIELD_TYPE_TARIFF_PRICE => array_map(function ($e) {
                                    return array_filter(array_values((array)$e));
                                }, $field['data']),
                                NeoCatalogField::FIELD_TYPE_IMAGE => [[$field['data']]],
                            };
                            $values['samples'][$card['id']][] = $field['data'];
                        }
                    }
                }
            }
        }

        $values['samples'] = array_values($values['samples']);
        $values['labels'] = array_values($values['labels']);

        $apriori = new Apriori(0.5, 0.5);
        $apriori->train(array_values($values['samples']), $values['labels']);

        return $response->success($apriori->getRules());
    }

    public function categories(): HasMany
    {
        return $this->hasMany(NeoCategory::class);
    }

    public function getRelatedNodeAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }
        return '';
    }

    public function userData(): BelongsTo
    {
        return $this->belongsTo(NeoUserCard::class, 'CARD');
    }

    public function cardObject(): BelongsTo
    {
        return $this->belongsTo(NeoCatalog::class, 'RELATED_TO');
    }

    public function fieldUserGroups(): HasMany
    {
        return $this->hasMany(NeoUserFieldGroup::class, 'USER_FIELD_GROUP')
            ->orderBy('sort', 'desc');
    }

    public function fieldGroups(): HasMany
    {
        return $this->hasMany(NeoFieldGroup::class, 'FIELD_GROUP');
    }

    public function getUrlAttribute(): string
    {
        $name = slugify($this->name);
        return route('objects.view_card', ['name' => $name, 'id' => $this->id], self::$absolute);
    }

    /**
     * @param Builder $query
     * @param Site $site
     * @return Collection
     */
    public function scopeGetSiteMapList(Builder $query, Site $site): Collection
    {
        $allCards = collect();
        $catalogs = NeoUserCatalog::query()->whereSiteId($site->id)->get();

        if (count($catalogs) == 0) {
            return collect();
        }

        foreach ($catalogs as $catalog) {
            $cards = $catalog->cards()->visible()->get();
            if (count($cards) > 0) {
                foreach ($cards as $card) {
                    $allCards->add($card);
                }
            }
        }

        return $allCards;
    }

    public function userCatalogData(): BelongsTo
    {
        return $this->belongsTo(NeoUserCatalog::class, 'CARD');
    }

    #[ArrayShape(['loc' => "string", 'lastmod' => "string", 'changefreq' => "string", 'priority' => "float"])]
    public function getSiteMapDATA(): array
    {
        self::$absolute = true;
        return [
            'loc' => $this->url,
            'lastmod' => $this->updated_at->toDateString(),
            'changefreq' => 'monthly',
            'priority' => 1.0
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

    public function scopeVisible($query)
    {
        return $query->whereHidden(0);
    }

    public function price(): bool|JsonResponse|int|string
    {
        $price = 0;
        $priceFound = false;
        if (count($this->fieldUserGroups) > 0) {
            foreach ($this->fieldUserGroups as $fieldUserGroup) {
                if (count($fieldUserGroup->fields) == 0) {
                    return $this->error('Поля не найдены в группе');
                }

                foreach ($fieldUserGroup->fields as $field) {
                    if ($field->field->field_type['id'] == NeoCatalogField::FIELD_TYPE_PRICE) {
                        $priceFound = true;
                        $price += (int)$field->value;
                    }
                }
            }
        } else {
            return $this->error('Группы полей не найдены');
        }

        if ($priceFound == false) {
            return $this->error('Продукт с ценой не найден');
        }

        return $price;
    }
}