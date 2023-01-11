<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\FieldGroup;
use App\Models\Modules\ModuleCatalog;
use App\Models\Modules\ModuleSettings;
use App\Models\Neo4j;
use App\Models\NeoCard;
use App\Models\NeoField;
use App\Models\NeoFieldUserGroup;
use App\Models\NeoObject;
use App\Models\NeoObjectField;
use App\Models\NeoObjectFieldGroup;
use App\Models\NeoUserCatalogData;
use App\Models\NeoUserData;
use App\Models\PageStrokeModule;
use App\Models\Section;
use App\Models\User as UserModel;
use App\Traits\Activity;
use App\Traits\NeoObject as NeoObjectTrait;
use App\Traits\NeoObjectValue;
use App\Traits\Response;
use App\Traits\User;
use App\Traits\Utils;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laudis\Neo4j\Exception\Neo4jException;
use Validator;

class ObjectsController extends Controller
{
    /**
     * @activity done
     */
    use User;
    use NeoObjectTrait;
    use NeoObjectValue;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(NeoObject::class);
        $this->setFromObject(UserModel::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['catalogs', 'catalogView', 'copyCard',
            'createCatalog', 'delete', 'deleteCatalog', 'saveForm', 'update', 'viewCard']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return false|JsonResponse|string
     * @internal param Request $request
     * @api {GET} /api/objects/related/{ID} Похожие товары
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID карточки товара
     * @apiParam {string} v Версия (v1, v2)
     */
    public function related($id, Request $request)
    {
        if (!$id) {
            return $this->error('На задан ID карточки');
        }

        $versions = ['v1', 'v2'];

        $version = $request->get('v', $versions[0]);

        $neoCard = self::getCard(compact('id'), true);

        if (!$neoCard) {
            return $this->error('Карточка не найдена');
        }

        if (in_array($version, $versions)) {

            $response = new class {
                use Response;
            };

            return NeoCard::{'related' . ucfirst($version)}($neoCard, $response);
        }

        return $this->success();
    }

    /**
     * @return false|JsonResponse|string
     * @throws Neo4jExceptionInterface
     * @internal param Request $request
     * @api {GET} /api/objects Список карточек
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function index()
    {
        $site = get_site();
        if ($site && $site->siteDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {
            $objects = $this->catalogTree(Auth::User());
        } else {
            $objects = $this->getAllCatalogs();
        }

        return $this->success(compact('objects'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return Collection|JsonResponse|Model|ObjectsController|ObjectsController[]|string
     * @api {GET} /api/objects/form/{CATALOG_ID} Редактирование карточки
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} CATALOG_ID ID каталога
     * @apiParam {integer} id ID карточки (не обязательно)
     */
    public function form($id, Request $request)
    {
        $user = Auth::user();
        $permission = $user->hasPermission('card_edit');

        if (!$permission) {
            return $this->error('У вас нет прав для редактирования карточки');
        }

        $object = NeoUserCatalogData::query()->whereId($id)->first();

        if (!$object) {
            return $this->error('Форма не найдена');
        }

        $object = $object->object;

        if (empty($object->fieldGroups) || count($object->fieldGroups) == 0) {
            return $this->error('Группы полей для формы не найдены');
        }

        $oFieldGroups = [];

        $obFieldGroups = $object->fieldGroups->sortByDesc('sort');

        foreach ($obFieldGroups as $fieldGroup) {
            $oFieldGroup = NeoObjectFieldGroup::with(['fields'])
                ->whereId($fieldGroup->id)->first();

            if ($oFieldGroup && count($oFieldGroup->fields) > 0) {
                foreach ($oFieldGroup->fields as &$field) {
                    $field->makeHidden(['data']);
                    $field['select_fields'] = $field->data['select_fields'];
                    $field['data'] = '0';
                }
                $oFieldGroups[] = $oFieldGroup;
            }
        }

        $oFieldGroups = array_values($oFieldGroups);

        $data = [
            'field_groups' => $oFieldGroups,
            'field_types' => NeoObjectField::$fieldTypes,
            'card_object' => $object->makeHidden(['fieldGroups'])
        ];

        $cardId = $request->get('id');

        if (!empty($cardId)) {
            $card = $object->cards()->whereId($cardId)->first();
            if (!$card) {
                return $this->error('Карточка не найдена');
            }

            $cardData = $this->getData($request);

            if (!is_array($cardData) && get_class($cardData) == JsonResponse::class) {
                return $cardData;
            }
            $data += $cardData;
        }

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @param bool $json
     * @return Model|ObjectsController|Collection|JsonResponse|array|string|null
     * @api {GET} /api/objects/get_data Получение карточки для статей и тд
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID карточки из листинга
     * @internal param Request $request
     */

    public function getData(Request $request, bool $json = true):
    Model|ObjectsController|Collection|JsonResponse|array|string|null
    {
        $data = $this->showData($request, $json, true);

        if (get_class($data) == JsonResponse::class) {
            return $data;
        }

        if ($data) {
            $data = $data->toArray();

            $data['field_user_groups'] = collect($data['field_user_groups'])->sortByDesc('sort')->toArray();

            foreach ($data['field_user_groups'] as &$fieldUserGroup) {

                unset($fieldUserGroup['object_field_group_id']);

                if (count($fieldUserGroup['fields']) > 0) {
                    foreach ($fieldUserGroup['fields'] as &$field) {

                        if (isset($field['field_type']) &&
                            $field['field_type']['id'] == NeoObjectField::FIELD_TYPE_FEEDBACK) {
                            $fieldGroup = null;

                            if (!empty($field['data'])) {
                                $fieldGroup = FieldGroup::query()->find($field['data']);

                                if ($fieldGroup) {
                                    $fieldGroup = $fieldGroup->fields;
                                }
                            }
                            $field['feedback'] = $fieldGroup;

                        }

                        $field += $field['field'];
                        unset($field['field']);
                    }
                }
            }
        }
        $data['field_user_groups'] = array_values($data['field_user_groups']);
        return $data;
    }

    /**
     * @param Request $request
     * @param bool $json
     * @param null $incrementViews
     * @return ObjectsController|ObjectsController[]|Collection|Model|JsonResponse|null|string
     * @internal param Request $request
     * @api {GET} /api/objects/show_data Получение конкретной карточки
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID карточки из листинга
     */

    public function showData(Request $request, $json = false, $incrementViews = null)
    {
        $data = $request->all();

        if (empty($data['id'])) {
            return $this->error('не задан ID карточки');
        }

        $neoCard = self::getCard($data, $incrementViews);

        if (!$neoCard) {
            return $this->error('Карточка не найдена');
        }

        if (!$json) {
            return $this->success([
                'object' => $neoCard
            ]);
        } else {
            return $neoCard;
        }
    }

    /**
     * @return JSON
     * @throws Neo4jExceptionInterface
     * @internal param Request $request
     * @api {GET} /api/objects/data Получение списка готовых карточек
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page Номер страницы
     */

    public function data()
    {
        $user = Auth::user();

        $userCatalogs = NeoUserCatalogData::whereUserId($user->id)
            ->whereNotNull('site_id')->get();

        if (count($userCatalogs) == 0) {
            return $this->success('Карточки не найдены');
        }

        $cardsData = collect();
        $fieldGroupIds = [];

        foreach ($userCatalogs as $userCatalog) {

            $cards = $userCatalog->cards()->with(['cardObject', 'fieldUserGroups' => function ($query) {

                $query->with(['fields' => function ($query) {
                    $query->orderBy('fields.object_field_id', 'asc');
                }]);

                $query->orderBy('fieldUserGroups.sort', 'desc');
            }])->paginate(config('app.catalog_limit'), ['*'], 'page')->items();

            if (count($cards) > 0) {
                $cards = collect($cards)->map(function ($card) use (&$fieldGroupIds) {

                    if ($card->cardObject) {
                        $card->cardObject->makeHidden(['parent']);
                    }
                    $card->fieldUserGroups->map(function ($group) use (&$fieldGroupIds) {
                        $fieldGroupIds[] = $group->object_field_group_id;
                    });
                    return $card;
                });
            }
            $cardsData = $cardsData->merge($cards);
        }

        $fieldGroups = NeoObjectFieldGroup::query()
            ->whereIn('id', array_unique($fieldGroupIds));

        NeoFieldUserGroup::$fieldGroups = $fieldGroups->get();
        return $this->success($cardsData->toArray());
    }

    /**
     * @return JSON|false|JsonResponse|string
     * @throws Neo4jExceptionInterface
     * @internal param Request $request
     * @api {GET} /api/objects/list Список карточек для статьи
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     */

    public function list()
    {
        $user = Auth::user();

        $userData = NeoUserData::whereUserId($user->id)->first();

        if (!$userData) {
            return $this->error('Карточки не найдены');
        }

        $cards = $userData->cards()->with(['cardObject'])->get();

        return $this->success($cards->toArray());
    }

    /**
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/objects/search_card Поиск карточки по имени
     * @apiGroup Objects
     *
     * @apiParam {string} term Строка для поиска
     * @apiParam {integer} object_id ID карточки
     *
     */
    public function searchCard(Request $request)
    {
        $term = $request->get('term');
        $objectId = $request->get('object_id');

        if (!$term || !$objectId) {
            return $this->error('Не заданы все параметры');
        }

        $card = NeoObject::find($objectId);

        if (!$card) {
            return $this->error('Карточка не найдена');
        }

        $cards = $card->cards()->where("name", "=~", "(?iu).*" . $term . ".*")->limit(10)->get();
        return $this->success($cards);
    }

    public function viewCard($id, Request $request)
    {
        $request->request->add(['id' => $id]);

        $data = $this->showData($request, false, true);

        if (get_class($data) == JsonResponse::class) {
            return $data;
        }

        if ($data) {
            foreach ($data->fieldUserGroups as $fieldUserGroup) {
                $fieldUserGroup->makeHidden(['object_field_group_id']);

                if (count($fieldUserGroup->fields) > 0) {
                    foreach ($fieldUserGroup->fields as $field) {
                        $field->makeHidden(['object_field_id', 'field', 'select_fields']);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/objects/filter Данные для фильтра
     * @apiGroup Objects
     *
     * @apiParam {array} filter Фильтр для каталога
     * @internal param Request $request
     */

    public function filter()
    {
        $site = $this->getSite(env('DOMAIN'));

        $neoUserData = NeoUserData::whereUserId((int)$site->user_id)->first();

        if (!$neoUserData) {
            return $this->error('Каталог не найден');
        }

        $cards = $neoUserData->cards;

        if (count($cards) == 0) {
            return $this->error('Карточки не найдены');
        }

        $filter = $this->getCatalogFilter($cards);

        return $this->success($filter);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/objects/catalogs/delete Удаление каталога с карточками
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} id ID каталога
     */
    public function deleteCatalog(Request $request): JsonResponse
    {
        $site = get_site();
        $data = $request->all();
        $user = Auth::user();

        if (!isset($data['id'])) {
            return $this->error('Не задан ID каталога');
        }

        $permission = $user->hasPermission('catalog_delete');

        if (!$permission) {
            return $this->error('У вас нет прав для удаления каталога');
        }

        $userCatalogData = NeoUserCatalogData::query()->find((int)$data['id']);

        if (!$userCatalogData) {
            return $this->error('Каталог для удаления не найден');
        }

        $sections = Section::bySite($site->id)->whereObjectId($userCatalogData->id)->get();
        if (count($sections) > 0) {
            foreach ($sections as $section) {
                $section->update(['object_id' => null]);
            }
        }

        $moduleCatalog = ModuleCatalog::query()->whereObjectId((int)$data['id'])->first();

        if ($moduleCatalog) {

            PageStrokeModule::query()->whereModuleId($moduleCatalog->id)->delete();

            $moduleCatalog->delete();
            ModuleSettings::flushCache();
        }

        $userCatalogData = NeoUserCatalogData::find((int)$data['id']);

        if (count($userCatalogData->cards) > 0) {
            $userCatalogData->cards->map(function ($card) {
                if (count($card->fieldUserGroups) > 0) {
                    $card->fieldUserGroups->map(function ($fUserGroup) {
                        if (count($fUserGroup->fields) > 0) {
                            $fUserGroup->fields->map(function ($field) {
                                $field->delete();
                            });
                        }
                        $fUserGroup->delete();
                    });
                }
                $card->delete();
            });
        }

        $userCatalogData->delete();

        $data = $this->getCatalogs();

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param $alias
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\JsonResponse
     * @api {POST} /api/objects/catalogs/{slug}-{id} Каталог с карточками
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     */
    public function catalogView($alias, $id): \Symfony\Component\HttpFoundation\JsonResponse|array
    {
        $site = get_site();
        $user = Auth::user();

        $permission = $user->hasPermission('catalog_view');

        if (!$permission) {
            return $this->error('У вас нет прав для редактирования каталогов');
        }

        $userCatalogData = NeoUserCatalogData::query()
            ->whereId($id)->whereAlias($alias)->whereSiteId($site->id)->first();

        if (!$userCatalogData) {
            return $this->error('Каталог не найден');
        }

        /**
         * @todo DUPLICATED CODE!
         */

        if (!$userCatalogData->object) {
            return $this->error('Такого каталога с карточками нет');
        }

        $request = request();
        $request->query->add([
            'object_id' => $userCatalogData->id
        ]);

        $catalog = $this->getCatalog($request, $userCatalogData->cards);

        if (!is_array($catalog)) {
            return $catalog;
        }

        $filter = $this->getCatalogFilter([], $userCatalogData->object);
        $data = compact('catalog', 'filter');
        $userCatalogData->makeHidden(['object']);
        $data = array_merge($data, $userCatalogData->toArray());

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string
     * @api {POST} /api/objects/search_inside Данные для фильтра управления каталогом
     * @apiGroup Objects
     *
     * @apiParam {array} fields Фильтр для управления каталогом
     * @apiParam {string} sort Сортировка (views|name)
     * @apiParam {integer} object_id ID каталога
     * @apiParam {string} order Порядок сортировки (asc|desc)
     */
    public function searchInside(Request $request): JsonResponse|bool|string
    {
        return $this->search($request, true);
    }

    /**
     * @param Request $request
     * @param bool $withHidden
     * @return bool|JsonResponse|string
     * @api {POST} /api/objects/search Данные для фильтра
     * @apiGroup Objects
     *
     * @apiParam {array} fields Фильтр для каталога
     * @apiParam {string} sort Сортировка (views|name)
     * @apiParam {integer} object_id ID каталога
     * @apiParam {string} order Порядок сортировки (asc|desc)
     */
    public function search(Request $request, bool $withHidden = false): JsonResponse|bool|string
    {
        $data = $request->all();

        if (!isset($data['object_id'])) {
            return $this->error('Каталог не найден');
        }

        $neoObject = NeoUserCatalogData::query()->find($data['object_id']);

        if (!$neoObject) {
            return $this->error('Такого каталога нет');
        }

        $validator = self::createSearchFormValidator($data);

        if ($validator->fails()) {
            return $this->catalog($request);
        }

        if ($withHidden == true) {
            $cards = $neoObject->cards;
        } else {
            $cards = $neoObject->cards()->visible()->get();
        }

        /**
         * @todo remove array values function
         */
        $data['fields'] = array_values($data['fields']);
        $fieldIds = collect($data['fields'])->pluck('id')->toArray();
        $fieldIds = array_values($fieldIds);
        $neoFields = NeoField::query()->whereIn('id', $fieldIds)->get()->keyBy('id');

        $commonClause = '';
        $returnedValuesString = '';
        $returnedValues = [];

        $i = 0;
        $nValues = '';

        if (count($data['fields']) > 0) {

            foreach ($data['fields'] as $index => $field) {
                $fieldId = $field['id'];
                $neoField = $neoFields[$fieldId];

                $i++;

                $commonClause .= ' MATCH (u:UserData)-[:CARD]
                -(c' . $index . ':Card)-[]->
                (n' . $index . ':FieldUserGroup)-[]->
                (f' . $index . ':Field) WHERE ID(u)=' . $neoObject->id . ' AND f' . $index . '.object_field_id=' . $fieldId;

                $returnedValues[] = 'c' . $index;
                $returnedValues[] = 'ID(c' . $index . ')';
                $method = 'createQl' . $neoField->field_type;
                $methodResult = $this->$method($field['term'], $index);

                if (!empty($methodResult)) {
                    $commonClause .= ' AND ';
                }

                $commonClause .= $methodResult;
            }

            if ($i > 1) {
                $nValues = ' AND n0=n1';
            } else {
                $nValues = '';
            }

            $imploded = implode(',', $returnedValues);

            $returnedValuesString = ' return ' . $imploded . ' ORDER BY ID(f0)';
        }

        $cql = $commonClause . $nValues . $returnedValuesString;

        if (env('APP_DEBUG_VARS') == true) {
            debugvars($cql);
        }

        try {
            $client = Neo4j::client()->run($cql);
        } catch (Neo4jException $e) {
            return $this->error($e->getMessage());
        }

        $cardsIds = [];
        debugvars('-----------------------------------------------------', [$client]);
        if (count($client) > 0) {
            foreach ($client as $record) {
                for ($j = 0; $j < $i; $j++) {
                    debugvars('-----------------------------------------------------', [$j]);
                    $nodeId = $record->get('ID(c' . $j . ')');
                    $cardsIds[$nodeId] = $record->get('ID(c' . $j . ')');
                }
            }
            $cardsIds = array_values($cardsIds);
        }

        debugvars('-----------------------------------------------------', $cardsIds);

        $fieldGroupIds = [];

        $objectFields = NeoObjectField::whereUseInCatalogList(1)->get();
        NeoField::$objectFields = $objectFields;

        foreach ($cards as $card) {

            $card->fieldUserGroups->map(function ($group) use (&$fieldGroupIds) {

                if ($group->fields->count() > 0) {
                    foreach ($group->fields as $field) {
                        if ($field->field != null) {
                            if (!isset($fieldGroupIds[$group->object_field_group_id])) {
                                $fieldGroupIds[$group->object_field_group_id] = $group->object_field_group_id;
                            }
                        }
                    }
                }
            });
        }

        $fieldGroups = NeoObjectFieldGroup::query()
            ->whereIn('id', array_unique($fieldGroupIds))->orderBy('sort', 'desc');

        NeoFieldUserGroup::$fieldGroups = $fieldGroups->get();

        $data = $neoObject->object;

        $data->makeHidden(['id', 'user_id']);

        $catalogData = ['cards' => []];

        if (isset($data['sort']) && isset($data['order'])
            && in_array($data['sort'], array_keys(NeoCard::$filter))
            && in_array(strtolower($data['order']), ['asc', 'desc'])) {

            if ($data['order'] == 'asc') {
                $cards = $data->cards->sortBy($data['sort']);
            } else {
                $cards = $data->cards->sortByDesc($data['sort']);
            }

            $cards = $cards->values()->all();
        }

        foreach ($cards as $index => $card) {
            if (in_array($card->id, $cardsIds)) {
                $catalogData['cards'][$index] = $card->toArray();

                foreach ($card->fieldUserGroups as $fIndex => $fieldUserGroup) {
                    if ($fieldUserGroup->fields->count() > 0 && $fieldUserGroup->name != null) {
                        $fieldUserGroup->makeHidden(['object_field_group_id', 'fields']);

                        $catalogData['cards'][$index]['field_user_groups'][$fIndex] = $fieldUserGroup->toArray();

                        foreach ($fieldUserGroup->fields as $fieldIndex => $field) {
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

                                if ($field->field->field_type['id'] == NeoObjectField::FIELD_TYPE_FEEDBACK) {
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
        }

        $paginator = $this->paginateObjects($request, $catalogData['cards']);

        return $this->success([
            'filter' => NeoCard::$filter,
            'filter_default' => NeoCard::$defaultFilter,
            'pagination' => $paginator
        ]);
    }

    public static function createSearchFormValidator($data, $except = [],
                                                     $customErrors = [], $customMessages = [])
    {
        $default = [
            'fields' => 'array|required',
            'fields.*.id' => 'numeric|required',
            'fields.*.term' => 'required'
        ];

        $messages = [
            'fields.required' => 'Не заданы поля поиска',
            'fields.*.id.required' => 'Не задано значение ID поля',
            'fields.*.term.required' => 'Не задано значение поиска'
        ];

        $messagesMerged = array_merge($messages, $customMessages);

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return Validator::make($data, $rules, $messagesMerged);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/objects/catalog Каталог карточек
     * @apiGroup Objects
     *
     * @apiParam {string} sort поле для сортировки (name, views)
     * @apiParam {string} order порядок сортировки (asc, desc)
     * @internal param Request $request
     */

    public function catalog(Request $request): bool|JsonResponse|string
    {
        $objectId = $request->get('object_id');
        $cards = [];

        if (isset($objectId)) {
            $userCards = NeoUserCatalogData::query()->find($objectId);

            if (!$userCards) {
                return $this->error('Такого каталога нет');
            }

            $cards = $userCards->cards()->visible()->get();
        }

        $catalog = $this->getCatalog($request, $cards);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('NO SEARCH FIELD VALUES');
        }

        return $this->success($catalog);
    }

    /**
     * @return JsonResponse
     * @api {POST} /api/objects/cards Вывод списка карточек
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @internal param Request $request
     */

    public function cards(): JsonResponse
    {
        $user = $this->publicUser();

        $userData = NeoUserData::whereUserId($user->id)->first();
        $objects = NeoObject::whereType(NeoObject::CARD_WITH_FIELDS)->get();

        if (!$userData) {
            return $this->error('Пользователь не найден');
        }

        $cards = $userData->cards;
        $allData = [];


        foreach ($cards as $oIndex => $card) {
            foreach ($objects as $object) {
                if ($card->cardObject->id == $object->id) {
                    $allData['objects'][$object->id] = $object;

                    $request = new Request();
                    $request->query->add(['id' => $card->id]);
                    $fullCard = $this->showData($request, true);

                    foreach ($allData['objects'][$object->id]->cards as $oCard) {
                        $oCard->data = $fullCard;
                    }

                    break;
                }
            }
        }

        return $this->success($allData);
    }

    /**
     * @return array|false|JsonResponse|string
     * @throws Neo4jExceptionInterface
     * @internal param Request $request
     * @api {GET} /api/objects/catalogs Список каталогов
     * @apiGroup Objects
     *
     * @apiParam {string} token Ключ пользователя
     */

    public function catalogs(): bool|JsonResponse|array|string
    {
        $data = $this->getCatalogs();

        if (!is_array($data)) {
            return $data;
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Neo4jExceptionInterface
     * @internal param Request $request
     * @api {POST} /api/objects/create_catalog Создание нового каталога
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID каталога
     * @apiParam {integer} catalog_name Название каталога
     * @apiParam {string} alias Слаг для урла
     *
     */
    public function createCatalog(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $user = Auth::user();
        $site = get_site();

        $permission = $user->hasPermission('catalog_create');

        if (!$permission) {
            return $this->error('У вас нет прав для создания каталога');
        }

        if (!isset($data['id'])) {
            return $this->error('Выберите шаблон каталога');
        }

        if (!empty($data['catalog_name'])) {
            $data['catalog_name'] = Utils::cleanChars($data['catalog_name']);
        }

        if (!isset($data['catalog_name']) || empty($data['catalog_name'])) {
            return $this->error('Не задано имя каталога');
        }

        $object = NeoObject::query()->find($data['id']);

        if (!$object) {
            return $this->error('Такой каталог не найден');
        }

        $userData = $object->userDatas()->whereUserId($user->id)->first();

        if (!$userData) {
            $userData = NeoUserData::firstOrCreate([
                'user_id' => $user->id
            ]);

            $object->userDatas()->attach($userData);
        }

        $catalogName = strip_tags($data['catalog_name']);

        if (isset($data['alias']) && !empty($data['alias'])) {
            $alias = slugify($data['alias']);
        } else {
            $alias = slugify($data['catalog_name']);
        }

        $userCatalogData = NeoUserCatalogData::create([
            'site_id' => $site->id,
            'user_id' => $user->id,
            'catalog_name' => Utils::cleanChars($catalogName),
            'cards_count' => 0,
            'catalog_views' => 0,
            'alias' => $alias
        ]);

        $object->userCatalogDatas()->attach($userCatalogData);

        $catalogs = $this->getCatalogs();

        $this->setIsSystem(false);
        $this->setParams($userCatalogData->toArray());
        $this->createActivity();

        return $this->success($catalogs);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {POST} /api/objects/save_form/{ID} Сохранение полей для карточки
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID шаблона карточки
     * @apiParam {integer} object_field_group_id ID группы полей для карточки
     * @apiParam {array} data Массив значений и полей
     * @apiParam {integer} data[hidden] скрыть карточку или нет (0 - нет, 1 - да)
     * @internal param Request $request
     */
    public function saveForm($id, Request $request): bool|JsonResponse|string|JSON
    {
        $data = $request->all();
        $user = Auth::user();
        $site = get_site();

        $permission = $user->hasPermission('card_create');

        //fixed bug with $permission
        if (!$permission) {
            return $this->error('У вас нет прав для создания карточки');
        }

        $userCatalogData = NeoUserCatalogData::query()->find($id);

        if (!$userCatalogData) {
            return $this->error('Карточка не найдена');
        }

        if (empty($data['data'])) {
            return $this->error('Данные для группы не найдены');
        }

        $object = $userCatalogData->object;

        $validator = self::createObjectValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $neoUser = $object->userDatas()->whereUserId($user->id)->first();

        if (!$neoUser) {
            $neoUser = NeoUserData::firstOrCreate([
                'user_id' => (int)$user->id
            ]);
            $object->userDatas()->attach($neoUser);
        }

        if (!$userCatalogData) {
            $userCatalogData = NeoUserCatalogData::firstOrCreate([
                'user_id' => $user->id,
                'catalog_name' => $object->name . ' (новый)',
                'cards_count' => 0,
                'catalog_views' => 0,
                'site_id' => $site->id
            ]);

            $object->userCatalogDatas()->attach($userCatalogData);
        }

        $card = NeoCard::create([
            'name' => trim($data['name']),
            'views' => 0,
            'seo_title' => !empty($data['seo_title']) ? $data['seo_title'] : '',
            'seo_description' => !empty($data['seo_description']) ?
                $data['seo_description'] : '',
            'seo_h1' => !empty($data['seo_h1']) ? $data['seo_h1'] : '',
            'object_id' => $object->id,
            'hidden' => $data['hidden'] ?? 0
        ]);

        $neoUser->cards()->attach($card);
        $object->cards()->attach($card);
        $userCatalogData->cards()->attach($card);

        $userCatalogData->update([
            'cards_count' => $userCatalogData->cards->count()
        ]);

        foreach ($data['data'] as $fieldGroup) {
            $objectFieldGroup = NeoObjectFieldGroup::whereId($fieldGroup['object_field_group_id'])
                ->with(['fields'])->first();

            $objectFields = $objectFieldGroup->fields->pluck('field_type', 'id');

            if (!$objectFieldGroup) {
                return $this->error('Группа полей не найдена');
            }

            $neoFieldGroup = NeoFieldUserGroup::create([
                'object_field_group_id' => $objectFieldGroup->id,
                'sort' => $objectFieldGroup->sort
            ]);

            $card->fieldUserGroups()->attach($neoFieldGroup);

            $neoFieldIds = $neoFieldGroup->fields()->get()->pluck('field_id')->toArray();

            $fields = $fieldGroup['fields'];

            $objectFieldsIds = array_keys($objectFields->toArray());

            foreach ($fields as $field) {
                if (!in_array($field['field_id'], $neoFieldIds) &&
                    in_array($field['field_id'], $objectFieldsIds)) {

                    $objectField = $objectFields->get($field['field_id']);

                    $method = 'getValue' . $objectField['id'];

                    $neoField = NeoField::create([
                        'object_field_id' => $field['field_id']
                    ]);

                    if (isset($field['value'])) {
                        $value = $this->$method($field['value'], $neoField);
                        $neoField->update(['value' => $value]);
                    }

                    $neoFieldGroup->fields()->attach($neoField);
                }
            }
        }

        return $this->success();
    }

    public static function createObjectValidator($data, $update = false)
    {
        $customErrors = [];
        $customMessages = [];

        if ($update == true) {
            foreach ($data['data'] as $i => $fieldGroup) {
                foreach ($fieldGroup['fields'] as $j => $field) {
                    $neoField = NeoField::query()->find($field['field_id']);
                    if ($neoField) {
                        $data['data'][$i]['fields'][$j]['field_id'] = $neoField->object_field_id;
                    }
                }
            }
        }

        foreach ($data['data'] as $fIndex => $fieldGroup) {
            $oFieldGroupId = $fieldGroup['object_field_group_id'];

            if ($update == true) {
                $neoFieldGroup = NeoFieldUserGroup::query()->find($oFieldGroupId);
                if ($neoFieldGroup) {
                    $oFieldGroupId = $neoFieldGroup->object_field_group_id;
                }
            }

            $objectFieldGroup = NeoObjectFieldGroup::whereId($oFieldGroupId)
                ->with(['fields'])->first();

            if (!$objectFieldGroup) {
                $response = new class {
                    use Response;
                };

                return $response->error('Такая группа полей не найдена');
            }

            $objectFields = $objectFieldGroup->fields;

            if (count($objectFields) > 0) {
                foreach ($objectFields as $objectField) {
                    foreach ($fieldGroup['fields'] as $index => $field) {
                        if ($field['field_id'] == $objectField->id && $objectField->required == 1) {
                            $customErrors['data.' . $fIndex . '.fields.' . $index . '.value'] = 'required';
                            $customMessages['data.' . $fIndex . '.fields.' . $index . '.value.required'] =
                                'Поле "' . $objectField->name . '" обязательно для заполнения';
                        }
                    }
                }
            }
        }

        $default = [
            'name' => 'required',
            'data' => 'array|required',
            'data.*.object_field_group_id' => 'numeric|required',
            'data.*.fields' => 'array|required',
            'data.*.fields.*.field_id' => 'required|numeric',
            'data.*.fields.*.value' => 'nullable'
        ];

        $messages = [
            'name.required' => 'Не задано имя для карточки',
            'data.*.object_field_group_id.required' => 'Не задано значение ID группы',
            'data.*.fields.*.field_id.required' => 'Некоторые ID полей не найдены'
        ];

        $messagesMerged = array_merge($messages, $customMessages);

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->toArray();

        return Validator::make($data, $rules, $messagesMerged);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/objects/update Обновление полей для карточки
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {array} data Массив значений групп форм и полей
     * @apiParam {integer} data[hidden] скрыть карточку или нет (0 - нет, 1 - да)
     * @internal param Request $request
     */
    public function update(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $user = Auth::user();
        $permission = $user->hasPermission('card_edit');

        if (!$permission) {
            return $this->error('У вас нет прав для обновления карточки');
        }

        if (empty($data['id'])) {
            return $this->error('Не задан ID карточки');
        }

        $card = NeoCard::query()->find($data['id']);

        if (!$card) {
            return $this->error('Карточка не найдена');
        }

        $validator = self::createObjectValidator($data, true);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $card->update([
            'name' => $data['name'],
            'seo_title' => !empty($data['seo_title']) ? $data['seo_title'] : '',
            'seo_description' => !empty($data['seo_description']) ? $data['seo_description'] : '',
            'seo_h1' => !empty($data['seo_h1']) ? $data['seo_h1'] : '',
            'hidden' => $data['hidden'] ?? 0
        ]);

        foreach ($data['data'] as $datum) {

            if (!empty($datum['object_field_group_id'])) {
                $fieldGroup = NeoFieldUserGroup::query()->find((int)$datum['object_field_group_id']);
                if ($fieldGroup) {

                    $fieldsIds = $fieldGroup->fields->pluck(['id'])->toArray();

                    if (!empty($datum['fields'])) {
                        foreach ($datum['fields'] as $field) {
                            $neoField = NeoField::query()->find((int)$field['field_id']);

                            if ($neoField && in_array($neoField->id, $fieldsIds)) {

                                $objectField = NeoObjectField::query()->find($neoField->object_field_id);

                                $value = "";
                                if (isset($field['value'])) {
                                    $method = 'getValue' . $objectField->field_type['id'];
                                    $value = $this->$method($field['value'], $neoField);
                                }

                                $neoField->update([
                                    'value' => $value
                                ]);
                            }
                        }
                    }
                }
            }
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success();
    }

    /**
     * @param $id
     * @return false|JsonResponse|string
     * @api {POST} /api/objects/delete/{ID} Удаление карточки
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID созданной карточки
     * @internal param Request $request
     */
    public function delete($id)
    {
        $user = Auth::user();

        $card = NeoCard::query()->find($id);

        if (!$card) {
            return $this->error('Данные не найдены');
        }

        if ($card->userData && $card->userData->user_id != $user->id) {
            return $this->error('Вы не можете удалить эту карточку');
        }

        foreach ($card->fieldUserGroups as $fieldUserGroup) {
            foreach ($fieldUserGroup->fields as $field) {
                $this->deleteBigData($field);
                $field->delete();
            }
            $fieldUserGroup->delete();
        }

        if ($card->userCatalogData) {
            $card->userCatalogData->update([
                'cards_count' => $card->userCatalogData->cards->count()
            ]);
        }

        Neo4j::client()->run("MATCH (o:Object)-[r:RELATED_TO]-(c:Card) WHERE ID(c)=" . $card->id . "  DELETE r");
        Neo4j::client()->run("MATCH (a:Card)-[b:CARD]-() WHERE ID(a)=" . $card->id . " DELETE a,b");

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/objects/copy_card Копирование карточки
     * @apiGroup Objects
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} card_id ID карточки
     * @internal param Request $request
     */
    public function copyCard(Request $request)
    {
        $user = Auth::user();
        $cardId = $request->get('card_id');

        $userData = NeoUserData::whereUserId($user->id)->first();

        if (!$userData) {
            return $this->error('Данные не найдены');
        }

        $card = $userData->cards()->find($cardId);

        if (!$card) {
            return $this->error('Карточка не найдена');
        }

        $cardObject = $card->cardObject;

        if (!empty($cardObject)) {

            $newCard = $card->replicate();
            $newCard->name = $newCard->name . ' (копия)';
            $newCard->push();

            $userData->cards()->attach($newCard);
            $cardObject->cards()->attach($newCard);

            $fieldUserGroups = $card->fieldUserGroups;

            if (count($fieldUserGroups) > 0) {
                foreach ($fieldUserGroups as $fieldUserGroup) {

                    $newFieldGroup = $fieldUserGroup->replicate();
                    $newFieldGroup->save();
                    $newCard->fieldUserGroups()->attach($newFieldGroup);
                    $fields = $fieldUserGroup->fields;

                    if (count($fields) > 0) {
                        foreach ($fields as $field) {
                            $newField = $field->replicate();
                            $newField->save();
                            $newFieldGroup->fields()->attach($newField);
                        }
                    }
                }
            }
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success();
    }
}
