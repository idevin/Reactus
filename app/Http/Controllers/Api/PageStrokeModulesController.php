<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modules\Module;
use App\Models\PageRevision;
use App\Models\PageStroke;
use App\Models\PageStrokeModule;
use App\Traits\Activity;
use App\Traits\Module as ModuleTrait;
use App\Traits\PageStrokeModule as PageStrokeModuleTrait;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageStrokeModulesController extends Controller
{
    /**
     * @activity done
     */
    use Activity;
    use PageStrokeModuleTrait;
    use ModuleTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(PageStrokeModule::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['index']);
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|array|string
     * @api {POST} /api/pages/stroke/modules/sort Сортировка модулей
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {json} modules [{"id": "n", "sort_order": "1-x"}]
     */
    public function sort(Request $request): JsonResponse|bool|array|string
    {
        $data = $request->all();
        $modules = json_decode($data['modules'], true);
        $modulesArray = [];

        if (empty($data['stroke_id'])) {
            return $this->error('Не задан ID строки');
        }

        $result = $this->checkStroke($data);

        if (!is_array($result)) {
            return $result;
        }

        if (!$result['page']) {
            return $this->error('Страница не найдена');
        }

        foreach ($modules as $item) {
            if (empty($item['id']) || !is_int($item['id'])) {
                return $this->error('Не задан либо неверный параметр ID');
            }

            if (empty($item['sort_order'])) {
                return $this->error('Не задан параметр сортировки');
            }

            $module = PageStrokeModule::query()->find($data['id']);

            if (!$module) {
                return $this->error('Модуль не найден');
            }

            $module->update([
                'sort_order' => (int)$data['sort_order']
            ]);
            $modulesArray[] = $module;
        }

        if (empty($modules)) {
            return $this->error('Модули не найдены');
        }

        PageRevision::createRevision($result['page'], PageRevision::SORT_MODULES, $modulesArray);

        return $this->success($modulesArray);
    }

    public function checkStroke($data): JsonResponse|bool|array|string
    {
        $pageStroke = PageStroke::query()->find($data['page_stroke_id']);
        if (!$pageStroke) {
            return $this->error('Строка не найдена');
        }

        $page = $pageStroke->page;

        return ['page' => $page];
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/pages/stroke/modules/form Форма для модуля
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} module_class класс модуля
     * @apiParam {string} module_id ID модуля
     */
    public function form(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $module = null;
        $site = $this->getSite(env('DOMAIN'));

        if (empty($data['module_class'])) {
            return $this->error(__('errors.module.no_class_param', ['key' => 'module_class']));
        }

        $modules = Module::getModules()->pluck('class')->toArray();

        if (!in_array($data['module_class'], $modules)) {
            return $this->error(__('errors.module.no_class', ['key' => $data['module_class']]));
        }

        if (isset($data['module_id']) && !empty($data['module_id'])) {
            $module = app($data['module_class'])::id((int)$data['module_id'], $site);
        }

        if ($module instanceof JsonResponse) {
            return $module;
        }

        $options = app($data['module_class'])::options($site, $data);

        return $this->success(compact('options', 'module'));
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string|array
     * @api {POST} /api/pages/stroke/modules/create Создание модуля
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {string} module_class класс модуля
     * @apiParam {integer} sort_order порядок сортировки
     * @apiParam {json} settings Настройки для модуля,
     * @apiParam {json} content_options Настройки контента
     */
    public function create(Request $request): bool|JsonResponse|string|array
    {
        $data = $request->all();
        $validator = self::validatePageStrokeModule($data, ['settings']);

        $result = self::validateModel($validator, $data);

        if (!is_array($result)) {
            return $result;
        }

        $module = PageStrokeModule::createModuleValidator($data);

        if (empty($module['errors'])) {
            PageStrokeModule::createModule($data);
            $pageStrokeModule = PageStrokeModule::query()->create(self::getData($data));
            $pageStrokeModule->refresh();

            PageRevision::createRevision($result['page'], PageRevision::ADD_MODULE, $pageStrokeModule);

            return $this->success($pageStrokeModule);
        } else {
            return $this->error($module['errors']);
        }
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/modules/update_content_options Обновление настроек модуля (без settings)
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {string} module_class класс модуля
     * @apiParam {integer} sort_order порядок сортировки
     * @apiParam {integer} id ID модуля
     * @apiParam {integer} template_id ID Шаблона
     * @apiParam {json} content_options Настройки контента
     */
    public function updateContentOptions(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $validator = self::validateModule($data);

        if (!is_array($validator)) {
            return $validator;
        }

        $validator['module']->update(self::getData($data, ['module_class', 'module_id']));

        return $this->refreshPageStroke($validator);
    }

    public function refreshPageStroke($result): JsonResponse
    {
        $result['pageStroke']->refresh();

        PageRevision::createRevision($result['page'], PageRevision::ADD_MODULE, $result['module']);

        return $this->success($result['module']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/modules/update Обновление модуля
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {string} module_class класс модуля
     * @apiParam {integer} sort_order порядок сортировки
     * @apiParam {integer} id ID модуля
     * @apiParam {integer} template_id ID Шаблона
     * @apiParam {json} settings Настройки для модуля
     * @apiParam {json} content_options Настройки контента
     */
    public function update(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $validator = self::validatePageStrokeModule($data, ['settings'], ['id' => 'required'],
            ['id.required' => 'Не задан ID модуля']);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $validator = self::validateModule($data);

        if (!is_array($validator)) {
            return $validator;
        }

        $moduleValidator = PageStrokeModule::createModuleValidator($data);

        $data['request'] = $request;

        $result = null;

        if (empty($moduleValidator['errors'])) {

            if (isset($data['settings'])) {
                if (!$validator['module']->module_id) {
                    $result = PageStrokeModule::createModule($data);
                } else {
                    $result = PageStrokeModule::updateModule($data, $validator['module']);
                }
            }

            if ($result && isset($result['module_object']) && $result['module_object'] instanceof JsonResponse) {
                return $result['module_object'];
            }

            $except = ['module_id'];

            if (isset($data['settings'])) {
                $except = null;
            }

            $validator['module']->update(self::getData($data, $except));

            return $this->refreshPageStroke($validator);
        } else {
            return $this->error($moduleValidator['errors']);
        }
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/pages/stroke/modules/delete Удаление модуля
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {integer} id ID модуля
     */
    public function delete(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $validator = self::validatePageStrokeModule($data, ['page_id', 'module_class', 'settings'],
            ['id' => 'required'],
            ['id.required' => 'Не задан ID модуля']);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $result = $this->checkStroke($data);

        if (!is_array($result)) {
            return $result;
        }

        $module = PageStrokeModule::query()->find($data['id']);

        if (!$module) {
            return $this->error('Модуль не найден');
        }

        PageRevision::createRevision($result['page'], PageRevision::DELETE_MODULE, $module);

        $module->delete();

        return $this->success();
    }
}