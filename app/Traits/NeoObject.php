<?php

namespace App\Traits;

use App\Models\Neo4j;
use App\Models\NeoCard;
use App\Models\NeoCatalog;
use App\Models\NeoCatalogField;
use App\Models\NeoCatalogFieldGroup;
use App\Models\NeoField;
use App\Models\NeoUserCard;
use App\Models\NeoUserCatalog;
use App\Models\NeoUserFieldGroup;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse as JsonResponseIlluminate;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Vinelab\NeoEloquent\Exceptions\Exception;

trait NeoObject
{
    /**
     * @param $request
     * @param null $cards
     * @param bool $paginate
     * @return array|JsonResponse
     */
    public static function getCatalog($request, $cards = null, bool $paginate = true): JsonResponse|array
    {
        $jsonResponse = new class {
            use Response;
        };

        $requestData = $request->all();

        if (!empty($requestData['object_id'])) {
            $neoObject = NeoUserCatalog::query()->find($requestData['object_id']);
            if (!$neoObject) {

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('get catalog ID error: ' . $requestData['object_id']);
                }

                return $jsonResponse->error('Такого каталога нет');
            }
            if (!$cards) {
                $cards = $neoObject->cards()->visible()->get();
            }
        }

        $fieldGroupIds = [];

        $objectFields = NeoCatalogField::query()->whereUseInCatalogList(1)->get();

        NeoField::$objectFields = $objectFields;

        foreach ($cards as $card) {

            $card->fieldUserGroups->map(function ($group) use (&$fieldGroupIds) {
                if ($group->fields->count() > 0) {
                    foreach ($group->fields as $index => $field) {
                        if ($field->field != null && $field->field->use_in_catalog_list == 1) {
                            if (!isset($fieldGroupIds[$group->object_field_group_id])) {
                                $fieldGroupIds[$group->object_field_group_id] = $group->object_field_group_id;
                            }
                        } else {
                            $group->fields->forget($index);
                        }
                    }
                }
            });
        }

        $fieldGroups = NeoCatalogFieldGroup::query()->whereIn('id', $fieldGroupIds)
            ->orderBy('sort', 'desc');

        NeoUserFieldGroup::$fieldGroups = $fieldGroups->get();

        $catalogData = ['cards' => []];

        if (isset($requestData['sort']) && isset($requestData['order'])
            && in_array($requestData['sort'], array_keys(NeoCard::$filter))
            && in_array(strtolower($requestData['order']), ['asc', 'desc'])) {

            if ($requestData['order'] == 'asc') {
                $cards = collect($cards)->sortBy($requestData['sort']);
            } else {
                $cards = collect($cards)->sortByDesc($requestData['sort']);
            }

            $cards = $cards->values()->all();
        }

        foreach ($cards as $index => $card) {
            $catalogData['cards'][$index] = $card->toArray();
            $catalogData['cards'][$index]['card_object'] = $card->cardObject->toArray();
            foreach ($card->fieldUserGroups as $fIndex => $fieldUserGroup) {

                if ($fieldUserGroup->fields->count() > 0 && $fieldUserGroup->name != null) {

                    $fieldUserGroup->makeHidden(['object_field_group_id', 'fields']);

                    $catalogData['cards'][$index]['field_user_groups'][$fIndex] = $fieldUserGroup->toArray();

                    foreach ($fieldUserGroup->fields as $field) {
                        $field->makeHidden(['object_field_id', 'object_field_group_id', 'select_fields', 'alias']);

                        if ($field->field != null && $field->field->use_in_catalog_list == 1) {
                            $field->field->makeHidden(['placeholder', 'required', 'api',
                                'object_field_group_id', 'use_in_filter', 'use_in_catalog_list']);

                            $fieldsData = [
                                'id' => $field->id,
                                'alias' => $field->field->alias,
                                'data' => $field->data,
                                'field_type' => $field->field->field_type,
                                'name' => $field->field->name
                            ];

                            if ($field->field->field_type['id'] == NeoCatalogField::FIELD_TYPE_FEEDBACK) {
                                $fieldsData['feedback'] = $field->feedback;
                            }

                            $catalogData['cards'][$index]['field_user_groups'][$fIndex]['fields'][] = $fieldsData;
                        }
                    }

                    $catalogData['cards'][$index]['field_user_groups'] =
                        array_values($catalogData['cards'][$index]['field_user_groups']);
                }
            }
        }

        $allData = [
            'filter' => NeoCard::$filter,
            'filter_default' => NeoCard::$defaultFilter
        ];

        if ($paginate == true) {
            $paginator = self::paginateObjects($request, $catalogData['cards']);
            $allData['pagination'] = $paginator;
        } else {
            $allData['cards'] = $catalogData['cards'];
        }

        return $allData;
    }

    public static function paginateObjects($request, $cards): LengthAwarePaginator
    {

        $oCard = [];
        foreach ($cards as $card) {
            $cardId = $card->get('ID(ca2)');
            $oCard[$cardId] = NeoUserCard::query()->with(['userFieldGroups' => function ($query) {
                $query->with(['userFields' => function ($query) {
                    $query->with('fieldPrototype');
                }]);
            }])->find($cardId);
        }

        $cardsCount = count($oCard);
        $page = $request->get('page', 1);
        $perPage = $request->get('limit', config('app.catalog_limit'));

        $offset = ($page * $perPage) - $perPage;

        $oCard = array_slice($oCard, $offset, $perPage);

        $paginator = new LengthAwarePaginator($oCard, $cardsCount, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);

        $paginator = Utils::transformUrl($paginator);

        $paginator->appends([
            'page' => $page,
            'limit' => $perPage
        ]);

        return $paginator;
    }

    public static function getCatalogFilter(NeoUserCatalog $catalog, $site, $user): array
    {
        $filter = [];

        $catalogProto = $catalog->catalogPrototype->with(['fieldGroups' => function ($query) {
            $query->with(['fields' => function ($query) {
                $query->with('values');
            }]);
        }])->first()->toArray();

        if ($catalogProto) {
            foreach ($catalogProto['field_groups'] as $item) {
                foreach ($item['fields'] as $field) {
                    if ($field['use_in_filter'] == 1) {
                        $filter[] = $field;
                    }
                }
            }
        }

        return $filter;
    }

    public static function getCard($data = [], $incrementViews = null): Model|Collection|Builder|array|null
    {
        $jsonResponse = new class {
            use Response;
        };

        $neoCard = NeoCard::with(['userFieldGroups' => function ($query) {
            $query->with(['userFields' => function ($query) {
                $query->with('fieldPrototype');
            }]);
        }])->find((int)$data['id']);

        if (!$neoCard) {
            return $jsonResponse->error('Карточка не найдена');
        }

        if ($incrementViews) {
            $neoCard->update(['views' => (int)($neoCard->views + 1)]);
        }

        return $neoCard;
    }

    /**
     * @return mixed
     */
    public function getCatalogForSection($o): array
    {
        $objects = $this->catalogTree($o);

        $data['objects'] = array_values($objects);
        $data['sort_options'] = NeoCard::$filter;
        $data['default_sort_options'] = NeoCard::$defaultFilter;

        return $data;
    }

    /**
     * @param $o
     * @return array
     * @throws Exception
     */
    public static function catalogTree($o = null): array
    {
        $site = get_site();
        $user = Auth::user();

        $query = "MATCH (c:Catalog) WHERE c.site_id={$site->id} AND c.user_id={$user->id} RETURN c, ID(c)";

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('CATALOG TREE: ' . $query);
        }

        $objects = Neo4j::client()->run($query);

        $data = [];

        if (count($objects) > 0) {
            foreach ($objects as $object) {
                $id = $object->get('ID(c)');
                $catalog = $object->get('c');

                if ($catalog['name']) {
                    $data[$id] = $catalog +
                        ['id' => $id] +
                        ['name' => $catalog['name']];
                }
            }

            $data = array_values($data);
        }

        return $data;
    }

    public function getAllCatalogs(): Collection
    {
        return NeoCatalog::query()->orderBy('alias')->get(['id', 'name']);
    }

    public function getCatalogs(): bool|JsonResponseIlluminate|Collection
    {
        $user = Auth::user();
        $site = $this->getSite(env('DOMAIN'));

        $permission = $user->hasPermission('catalog_view');

        if (!$permission) {
            return $this->error('У вас нет прав для редактирования каталогов');
        }

        $hiddenFields = ['created_at', 'updated_at'];

        return NeoUserCatalog::query()
            ->whereUserId($user->id)->whereSiteId($site->id)->orderBy('updated_at')
            ->get()->makeHidden($hiddenFields);
    }

    public function checkUser($data): JsonResponseIlluminate|bool|array|string
    {
        $user = $this->publicUser();

        $neoUser = NeoUserCard::query()->whereUserId($user->id)->first();

        if (!$neoUser) {
            return $this->error('Каталогов не найдено. Добавьте сначала каталог.');
        }

        $catalog = $neoUser->catalogs()->find((int)$data['catalog_id']);

        if (!$catalog) {
            return $this->error('Каталог не найден');
        }

        return compact('neoUser', 'catalog');
    }

    /**
     * @param $field
     */
    private function deleteBigData($field)
    {
        $fs = new Filesystem();
        $neoBigData = resource_path() . DS . 'neo_big_data' . DS;
        $path = $neoBigData . 'n-' . $field->id . '.json';

        if ($fs->exists($path)) {
            $fs->delete($path);
        }
    }
}