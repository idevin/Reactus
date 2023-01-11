<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Http\Controllers\Api\ObjectsController;
use App\Http\Controllers\Controller;
use App\Models\Modules\ModuleCatalog;
use App\Models\Modules\ModuleSettings;
use App\Models\Neo4j;
use App\Models\NeoCard;
use App\Models\NeoCatalogField;
use App\Models\NeoCatalogFieldGroup;
use App\Models\NeoField;
use App\Models\NeoObject as NeoObjectModel;
use App\Models\NeoObjectFieldGroup;
use App\Models\NeoUserCatalog;
use App\Models\NeoUserCatalogData;
use App\Models\NeoUserData;
use App\Models\Site;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Catalog;
use App\Traits\Module;
use App\Traits\NeoObject;
use Auth;
use Ds\Vector;
use Exception;
use GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends Controller
{
    public static $user = null;

    /**
     * @activity done
     */
    use Module;
    use Catalog;
    use NeoObject;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        $this->setObject(ModuleCatalog::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['create', 'update', 'delete']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/catalog/create Создание блока каталога
     * @apiGroup Module catalog
     *
     * @apiParam {integer} content контент для блока
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} module_id ID модуля в системе
     * @apiParam {integer} module_settings_id ID настроек модуля
     * @apiParam {integer} block_cell_id ID ячейки
     * @apiParam {integer} block_type_id тип строки
     * @apiParam {integer} position позиция блока 1 - Header, 2 - Footer, 3 - Content
     * @apiParam {array} filter_settings массив фильтров для каталога
     * @apiParam {array} sort_options массив для сортировки каталога по умолчанию
     * @apiParam {integer} object_id ID обьекта для фильтра и каталога
     *
     */
    public function create(Request $request): bool|JsonResponse|string
    {
        $site = $this->getSite(env('DOMAIN'));
        $data = $request->all();

        unset($data['objects']);

        $validator = static::createCatalogValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $module = self::checkModule(ModuleCatalog::class, $data['module_id']);

        if ($module['error']) {
            return $module['error'];
        }

        /**
         * @todo дублирующийся код
         */
        if (!isset($data['submodule'])) {
            $data['submodule'] = 1;
        }

        if ((int)$data['submodule'] == 0) {

            $moduleSettings = ModuleSettings::create([
                'site_id' => $site->id,
                'module_id' => $module['module']->id,
                'object' => Site::class,
                'object_id' => $site->id,
                'name' => 'Строка',
                'position' => $data['position']
            ]);

        } else {
            $moduleSettings = ModuleSettings::query()->find($data['module_settings_id']);
            if (!$moduleSettings) {
                return $this->error('Не найдены настройки для модуля');
            }
        }

        $objectId = $data['object_id'] ?? null;

        $catalog = ModuleCatalog::query()->firstOrCreate([
            'site_id' => $site->id,
            'module_settings_id' => $moduleSettings->id,
            'name' => $data['name'],
            'module_id' => $module['module']->id,
            'filter_settings' => $data['filter_settings'] ?? null,
            'object_id' => $objectId,
            'sort_by' => $data['sort_by'] ?? ModuleCatalog::DEFAULT_SORT_BY,
            'sort_order' => $data['sort_order'] ?? ModuleCatalog::DEFAULT_SORT_ORDER,
            'hide_filter' => $data['hide_filter'] ?? 0
        ]);

        ModuleSettings::flushCache();

        $catalogArray = [];

        if (!empty($catalog->filter_settings)) {

            $newSettings = collect($catalog->filter_settings)->map(function ($setting) {
                return [
                    'id' => $setting['id'],
                    'term' => $setting['value'] ?? null
                ];
            })->toArray();

            $request->query->add([
                'fields' => $newSettings,
                'object_id' => $catalog->object_id
            ]);

            $catalogData = app(ObjectsController::class)->search($request);
            $catalogData = $catalogData->getData()->data;
            $catalogArray['filter_settings'] = $catalog->filter_settings;
        } else {

            $neoObject = NeoObjectModel::find($catalog->object_id);

            $neoUserData = $neoObject->userDatas()->whereUserId((int)$site->user_id)->first();

            if (!$neoUserData) {
                return $this->error('Данные пользовательских карточек не найдены');
            }

            $cards = $neoUserData->cards()->whereObjectId($catalog->object_id)->get();

            $catalogData = $this->getCatalog($request, $cards);
            $catalogArray['filter_settings'] = [];
        }

        $neoUserData = NeoUserData::whereUserId((int)$site->user_id)->first();

        if (!$neoUserData) {
            return $this->error('Каталог не найден');
        }

        /**
         * Повторяющийся код - полная лажа с выборкой в цикле, не для HIGH LOAD
         */
        $cards = $neoUserData->cards()->paginate(config('app.catalog_limit'))->items();
        $newCards = [];

        foreach ($cards as $index => $card) {
            if (!isset($card->cardObject) || !isset($card->cardObject->id) || !isset($catalog->object_id)) {
                continue;
            }

            if ($card->cardObject->id == $catalog->object_id) {
                $newCards[] = $card;
            }
        }

        $cards = $newCards;

        $filter = $this->getCatalogFilter($cards);

        $catalogArray['object_id'] = $catalog->object_id;
        $catalogArray['catalog'] = $catalogData;
        $catalogArray['filter'] = $filter;

        $blocks = ModuleSettings::getBlocks($site);

        $data = [
            'blocks' => $blocks,
            'item' => $catalogArray
        ];

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string
     * @api {GET} /api/modules/v2/catalog/get_filter_data Выбор для фильтра каталога
     * @apiGroup Module catalog
     *
     * @apiParam {integer} object_id ID обьекта для фильтра
     * @apiParam {string} token хеш пользователя
     *
     */
    public function getFilterData(Request $request): JsonResponse|bool|string
    {

        $data = NeoUserCatalog::getFilter($request->input('object_id'));

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/catalog/update Обновление блока каталога
     * @apiGroup Module catalog
     *
     * @apiParam {string} content контент для блока
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID модуля каталога
     * @apiParam {string} content информация
     * @apiParam {string} name Имя для блока каталога
     * @apiParam {integer} module_id ID модуля в системе
     * @apiParam {integer} module_settings_id ID настроек блока
     * @apiParam {array} filter_settings массив фильтров для каталога
     * @apiParam {array} sort_options массив для сортировки каталога по умолчанию
     * @apiParam {integer} object_id ID обьекта для фильтра и каталога
     *
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $site = $this->getSite(env('DOMAIN'));

        if (!isset($data['id'])) {
            return $this->error('Не задан ID модуля каталога');
        }

        $except = ['position'];

        $validator = static::createCatalogValidator($data, $except);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $module = self::checkModule(ModuleCatalog::class, $data['module_id']);

        if ($module['error']) {
            return $module['error'];
        }

        $moduleSettings = ModuleSettings::query()->where([
            'id' => $data['module_settings_id'],
            'site_id' => $site->id
        ])->get()->first();

        if (!$moduleSettings) {
            return $this->error('Не найдены настройки для модуля');
        }

        $catalog = ModuleCatalog::query()->find($data['id']);

        if (!$catalog) {
            return $this->error('Модуль каталога не найден');
        }

        $catalog->update([
            'name' => $data['name'],
            'filter_settings' => isset($data['filter_settings']) ? $data['filter_settings'] : null,
            'object_id' => isset($data['object_id']) ? $data['object_id'] : null,
            'sort_by' => isset($data['sort_by']) ? $data['sort_by'] : ModuleCatalog::DEFAULT_SORT_BY,
            'sort_order' => isset($data['sort_order']) ? $data['sort_order'] : ModuleCatalog::DEFAULT_SORT_ORDER,
            'hide_filter' => isset($data['hide_filter']) ? $data['hide_filter'] : 0
        ]);

        ModuleSettings::flushCache();

        if ((int)$moduleSettings->position != ModuleSettings::POSITION_CONTENT) {
            $arrayData['item'] = $moduleSettings->objects()->first();
            $arrayData['block'] = $moduleSettings->makeHidden(['module'])->toArray();
        } else {
            $arrayData = ModuleSettings::getBlocks($site);
        }

        /**
         * @todo Повторяющийся код
         */
        $catalogArray = [];

        if (!empty($catalog->filter_settings)) {

            $newSettings = collect($catalog->filter_settings)->map(function ($setting) {
                return [
                    'id' => $setting['id'],
                    'term' => isset($setting['value']) ? $setting['value'] : null
                ];
            })->toArray();

            $request->query->add([
                'fields' => $newSettings,
                'object_id' => $catalog->object_id
            ]);

            $catalogData = app(ObjectsController::class)->search($request);
            $catalogData = $catalogData->getData()->data;
            $catalogArray['filter_settings'] = $catalog->filter_settings;
        } else {
            $catalogData = $this->getCatalog($request);
            $catalogArray['filter_settings'] = [];
        }

        $neoUserData = NeoUserData::whereUserId((int)$site->user_id)->first();
        if (!$neoUserData) {
            return $this->error('Каталог не найден');
        }

        /**
         * Повторяющийся код - полная лажа с выборкой в цикле, не для HIGH LOAD
         */
        $cards = $neoUserData->cards;
        $newCards = [];

        foreach ($cards as $index => $card) {
            if ($card->cardObject->id == $catalog->object_id) {
                $newCards[] = $card;
            }
        }

        $cards = $newCards;

        $filter = $this->getCatalogFilter($cards);

        $catalogArray['object_id'] = $catalog->object_id;
        $catalogArray['catalog'] = $catalogData;
        $catalogArray['filter'] = $filter;

        $data = [
            'blocks' => $arrayData,
            'item' => $catalogArray
        ];

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Neo4jExceptionInterface
     * @api {POST} /api/modules/catalog/edit Редактирование блока каталога
     * @apiGroup Module catalog
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID модуля каталога
     *
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $site = get_site();
        $data = [];
        $filter = [];

        if ($id) {

            $moduleCatalog = ModuleCatalog::query()->where([
                'id' => $id,
                'site_id' => $site->id
            ])->first();

            if ($moduleCatalog) {
                $data['item'] = $moduleCatalog;
                $data['block'] = $moduleCatalog->makeHidden(['module'])->toArray();
            } else {
                return $this->error('Такой модуль не найден');
            }

            $object = NeoUserCatalogData::query()->whereId($moduleCatalog->object_id)->first();

            if (!$object || !$object->object) {
                return $this->error("Каталог не найден");
            }

            $object = $object->object;

            foreach ($object->fieldGroups as $index => $fieldGroup) {
                $oFieldGroup = NeoObjectFieldGroup::with(['fields' => function ($query) {
                    $query->orderBy('ID(fields)', 'asc');
                }])->whereId($fieldGroup->id)->first();

                if ($oFieldGroup && count($oFieldGroup->fields) > 0) {
                    $oFieldGroup->fields->makeHidden(['object_field_group_id']);
                    $filter = array_merge($filter, $oFieldGroup->fields->toArray());
                }
            }
        }

        $user = Auth::user();

        $permission = $user->hasPermission('catalog_view');

        if (!$permission) {
            return $this->error('У вас нет прав для редактирования каталогов');
        }

        $o = $site;

        if ($permission->pivot->own == 1 && $permission->pivot->other == 0) {
            $o = $user;
        }

        $data = ModuleCatalog::options($o);

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/modules/catalog/delete Удаление блока каталога
     * @apiGroup Module catalog
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID модуля каталога
     *
     */
    public function delete(Request $request)
    {
        $id = $request->get('id', null);
        $site = $this->getSite(env('DOMAIN'));

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $moduleCatalog = ModuleCatalog::query()->where([
            'id' => $id,
            'site_id' => $site->id
        ])->first();

        if (!$moduleCatalog) {
            return $this->error('Такой блок не найден');
        }

        $this->setIsSystem(false);
        $this->setParams($moduleCatalog->toArray());
        $this->createActivity();

        $moduleCatalog->delete();

        ModuleSettings::flushCache();

        return $this->success();
    }

    public function form()
    {
        return $this->success();
    }
}