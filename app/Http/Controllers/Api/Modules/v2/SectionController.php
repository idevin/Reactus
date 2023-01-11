<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Http\Controllers\Controller;
use App\Models\Modules\ModuleSection;
use App\Models\Modules\ModuleSettings;
use App\Models\Site;
use App\Traits\Activity;
use App\Traits\Media;
use App\Traits\Module;
use App\Traits\Section;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Session;
use Symfony\Component\HttpFoundation\Request;

class SectionController extends Controller
{
    /**
     * @activity done
     */
    public static $user = null;

    use Section;
    use Module;
    use Media;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        Session::forget('site');

        $this->setObject(ModuleSection::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['create', 'update', 'delete']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/modules/section/edit Настройки для блока разделов
     * @apiGroup Module section
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} module_settings_id данные редактирования для блока (не обязательно)
     * @apiParam {string} module_id ID модуля разделов
     * @apiParam {string} [id] ID раздела
     * @internal param Request $request
     */
    public function edit(Request $request)
    {
        $moduleSettingsId = $request->get('module_settings_id');
        $moduleId = $request->get('module_id');
        $id = $request->get('id', null);

        $module = self::checkModule(ModuleSection::class, $moduleId);

        if ($module['error']) {
            return $module['error'];
        }

        if ($id) {
            $section = ModuleSection::query()->find($id);
            if (!$section) {
                return $this->error('Не найдены настройки блока разделов');
            }

//            $cell = ModuleStrokeModule::whereModuleClassId($section->id)
//                ->where('module_class', ModuleSection::class)->get()->first();
//
//            if (!$cell) {
//                return $this->error('Ячейка не найдена');
//            }

//            $cell = $cell->makeHidden(['id', 'module_stroke_id', 'module_class', 'module_class_id', 'module_id']);
            $section = $section->makeHidden(['site_id']);
            $section->position = ModuleSettings::POSITION_CONTENT;

            $data['fields'] = $section->toArray();
//            $data['fields']['block_type'] = $cell->block_type_id;

            $data['fields'] = array_merge(
                $data['fields']
            );

        }

        $data['options'] = ModuleSection::options();

        if ($moduleSettingsId) {
            $moduleSettings = ModuleSettings::find($moduleSettingsId);
            $moduleSection = ModuleSection::where('module_settings_id', $moduleSettings->id)->get()->first();

            $data['data'] = [
                'module_settings' => $moduleSettings,
                'module_section' => $moduleSection
            ];
        }

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/modules/section/sort Сортировка модуля разделов
     * @apiGroup Module section
     *
     * @apiParam {integer} id ID настроек для модуля разделов
     * @apiParam {integer} module_id ID модуля раздела
     * @apiParam {integer} sort_by сортировка (1 - по заголовку, 2 - по рейтингу, 3 - по кол-ву статей, 4 - под дате публикации)
     * @piaParam {integer} view вид блока (1 - вертикальный блок, 2 - горизонтальный блок)
     * @apiParam {integer} sort_order сортировка читаемого (1 - по возрастанию, 2 - по убыванию)
     *
     */
    public function sort(Request $request)
    {
        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/section/create Создание блока разделов
     * @apiGroup Module section
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} module_id ID модуля разелов
     * @apiParam {integer} position позиция модуля (1 - Header, 2 - Footer, 3 - Content)
     * @apiParam {integer} block_cell_id ID ячейки строки
     * @apiParam {integer} block_type_id ID типа ячейки блока (расширяемый, с отступами по бокам)
     * @apiParam {integer} name название блока
     * @apiParam {integer} submodule 0|1 (для добавления в ячейку - 1 )
     * @apiParam {integer} module_settings_id ID настроек для модуля
     *
     * @apiParam {integer} sort_by сортировка (1 - по заголовку, 2 - по рейтингу, 3 - по кол-ву статей, 4 - под дате публикации)
     * @apiParam {integer} view вид блока (1 - вертикальный блок, 2 - горизонтальный блок)
     * @apiParam {integer} sort_order сортировка читаемого (1 - по возрастанию, 2 - по убыванию)
     * @apiParam {integer} block_view блок список/сетка (0 - список, 1 - сетка)
     *
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = self::createModuleSectionValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $module = $this->checkModule(ModuleSection::class, $data['module_id']);

        if ($module['error']) {
            return $module['error'];
        }

        $site = $this->getSite(env('DOMAIN'));

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
            $moduleSettings = ModuleSettings::find($data['module_settings_id']);
            if (!$moduleSettings) {
                return $this->error('Не найдены настройки для модуля');
            }
        }

        $sortBy = isset($data['sort_by']) ? $data['sort_by'] : null;
        $sortOrder = isset($data['sort_order']) ? $data['sort_order'] : null;
        $view = isset($data['view']) ? $data['view'] : null;
        $blockView = isset($data['block_view']) ? $data['block_view'] : 0;

        $sectionData = [
            'module_settings_id' => $moduleSettings->id,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'view' => $view,
            'site_id' => $site->id,
            'name' => $data['name'],
            'module_id' => $module['module']->id,
            'block_view' => $blockView
        ];

        $moduleSection = ModuleSection::create($sectionData);

//        $moduleStroke = $moduleSettings->objects()->first();

//        ModuleStrokeModule::create([
//            'module_stroke_id' => $moduleStroke->id,
//            'block_cell_id' => $data['block_cell_id'],
//            'module_class' => ModuleSection::class,
//            'module_class_id' => $moduleSection->id,
//            'block_type_id' => $data['block_type_id'],
//            'module_id' => $module['module']->id
//        ]);

        ModuleSettings::flushCache();

        $this->setIsSystem(false);
        $this->setParams($moduleSection->toArray());
        $this->createActivity();

        return $this->success([
            'blocks' => ModuleSettings::getHomeBlocks($site, $request),
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/section/update Обновление блока разделов
     * @apiGroup Module section
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} module_id ID настроек модуля разделов
     * @apiParam {integer} id ID модуля разделов
     * @apiParam {integer} position позиция модуля (1 - Header, 2 - Footer, 3 - Content)
     * @apiParam {integer} block_cell_id ID ячейки строки
     * @apiParam {integer} block_type_id ID типа ячейки блока (расширяемый, с отступами по бокам)
     * @apiParam {integer} [name] название блока
     * @apiParam {integer} [submodule] 0|1 (для добавления в ячейку - 1 )
     * @apiParam {integer} module_settings_id ID настроек для модуля
     *
     * @apiParam {integer} sort_by сортировка (1 - по заголовку, 2 - по рейтингу, 3 - по кол-ву статей, 4 - под дате публикации)
     * @apiParam {integer} view вид блока (1 - вертикальный блок, 2 - горизонтальный блок)
     * @apiParam {integer} block_view блок список/сетка (0 - список, 1 - сетка)
     * @apiParam {integer} sort_order сортировка читаемого (1 - по возрастанию, 2 - по убыванию)
     *
     */
    public function update(Request $request)
    {
        $data = $request->all();

        if (!isset($data['id'])) {
            return $this->error('Не задан ID модуля раздела');
        }

        if (!isset($data['module_id'])) {
            return $this->error('Не задан ID модуля');
        }

        $validator = self::createModuleSectionValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $module = $this->checkModule(ModuleSection::class, $data['module_id']);

        if ($module['error']) {
            return $module['error'];
        }

        $site = $this->getSite(env('DOMAIN'));

        $moduleSettings = ModuleSettings::find($data['module_settings_id']);

        if (!$moduleSettings) {
            return $this->error('Не найдены настройки для модуля');
        }

        $moduleSection = ModuleSection::find($data['id']);

        if (!$moduleSection) {
            return $this->error('Модуль не найден');
        }

        $sortBy = isset($data['sort_by']) ? $data['sort_by'] : null;
        $sortOrder = isset($data['sort_order']) ? $data['sort_order'] : null;
        $view = isset($data['view']) ? $data['view'] : null;
        $blockView = isset($data['block_view']) ? $data['block_view'] : 0;

        $sectionData = [
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'view' => $view,
            'site_id' => $site->id,
            'name' => $data['name'],
            'block_view' => $blockView
        ];

        $moduleSection->update($sectionData);

        $this->setIsSystem(false);
        $this->setParams($moduleSection->toArray());
        $this->createActivity();

        ModuleSettings::flushCache();

        return $this->success([
            'blocks' => ModuleSettings::getHomeBlocks($site, $request),
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/section/validate Валидация блока разделов
     * @apiGroup Module section
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} view вид списка разделов
     * @apiParam {integer} sort_by поле для сортировки (1 - название, 2 - рейтинг, 3 - кол-во статей, 4 - дата публикации)
     * @apiParam {integer} sort_order направление сортировки (1 - по возрастанию, 2 - по убыванию)
     * @apiParam {integer} position позиция строки (1 - хэдер, 2 - футер, 3 - контент)
     * @apiParam {string} name имя блока
     * @apiParam {integer} block_cell_id ID ячейки блока
     * @apiParam {integer} block_type_id ID типа блока
     */
    public function validateSection(Request $request)
    {
        $data = $request->all();
        $validator = self::createModuleSectionValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        } else {
            return $this->success();
        }
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/modules/section/delete Удаление модуля раздела со строки
     * @apiGroup Module section
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID модуля раздела
     *
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        $site = $this->getSite(env('DOMAIN'));

        if (!$id) {
            return $this->error('Не зандан параметр ID');
        }

        $moduleSection = ModuleSection::where('id', $id)->where('site_id', $site->id)->first();

        if (!$moduleSection) {
            return $this->error('Модуль раздела не найден');
        }

        $this->setIsSystem(false);
        $this->setParams($moduleSection->toArray());
        $this->createActivity();

        $moduleSection->delete();

        return $this->success();
    }
}