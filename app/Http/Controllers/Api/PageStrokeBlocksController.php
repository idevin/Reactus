<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageStroke;
use App\Models\PageStrokeModule;
use App\Traits\Activity;
use App\Traits\Module;
use App\Traits\PageStrokeBlock;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Schema;

class PageStrokeBlocksController extends Controller
{
    /**
     * @activity done
     */
    use Activity;
    use PageStrokeBlock;
    use Module;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(PageStrokeBlock::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['index']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string|array
     * @api {POST} /api/pages/stroke/blocks/create Создание блока модуля
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {string} module_class класс модуля
     * @apiParam {integer} sort_order порядок сортировки
     * @apiParam {string} template_id данные для шаблона
     * @apiParam {string} content_options настройки контента
     * @apiParam {string} create_module создание модуля сразу
     */
    public function create(Request $request): bool|JsonResponse|string|array
    {
        $data = $request->all();
        $validator = self::validatePageStrokeBlock($data);

        $result = self::validateModel($validator, $data);

        if (!is_array($result)) {
            return $result;
        }

        $block = PageStrokeModule::query()->create(self::getData($data));

        $module = app($data['module_class']);

        $hasPermission = $module->hasPermission(true);

        if (!$hasPermission) {
            return $this->error('У Вас нет прав для создания блока ' . $data['module_class']);
        }

        if (isset($data['create_module']) && $data['create_module'] == true) {

            $moduleData = [];
            if (Schema::hasColumn($module->getTable(), 'site_id')) {
                $moduleData['site_id'] = $this->getSite(env('DOMAIN'))->id;
            }

            $module = $module->create($moduleData);
            $block->update(['module_id' => $module->id]);
        }

        $block = $block->toArray();

        return $this->success($block);
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string|array
     * @api {POST} /api/pages/stroke/blocks/update Обновление блока модуля
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} page_stroke_id ID строки
     * @apiParam {string} id блока модуля
     * @apiParam {json} content_options настройки
     * @apiParam {string} template_id шаблон
     */
    public function update(Request $request): bool|JsonResponse|string|array
    {
        $data = $request->all();
        $validator = self::validatePageStrokeBlock($data, ['module_class'],
            ['id' => 'required'], ['id.required' => 'На задан ID блока']);

        $result = self::validateModel($validator, $data);

        if (!is_array($result)) {
            return $result;
        }

        $block = PageStrokeModule::query()->find($data['id']);

        if (!$block) {
            return $this->error('Блок не найден');
        }

        $block->update([
            'sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : 1,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 0,
            'template_id' => $data['template_id'],
            'content_options' => $data['content_options'] ?? null
        ]);

        return $this->success($block);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/blocks/sort Сортировка блоков
     * @apiGroup Page Modules
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {array} blocks Массив блоков для сортировки (
     *      blocks[N][id]=X,
     *      blocks[N][page_stroke_id]=Y,
     *      blocks[N][sort_order]=Z...
     * )
     */
    public function sort(Request $request)
    {
        $data = $request->all();

        if (empty($data['blocks']) || !is_array($data['blocks'])) {
            return $this->error('Не найден массив блоков');
        }

        $pageStrokeId = null;

        foreach ($data['blocks'] as $block) {

            if (!isset($block['id'])) {
                return $this->error('Не задан либо неверный параметр ID');
            }

            if (!isset($block['sort_order'])) {
                return $this->error('Не задан параметр сортировки');
            }

            if (!isset($block['page_stroke_id'])) {
                return $this->error('Не задан ID строки');
            }

            $stroke = PageStroke::query()->find($block['page_stroke_id']);

            if (!$stroke) {
                return $this->error('Строка не найдена');
            }

            $blockObject = PageStrokeModule::query()->find($block['id']);

            if (!$blockObject) {
                return $this->error('Блок не найден');
            }

            $blockObject->update([
                'sort_order' => (int)$block['sort_order'],
                'page_stroke_id' => (int)$block['page_stroke_id']
            ]);

            $blockObject->refresh();

            if (!$pageStrokeId) {
                $pageStrokeId = $blockObject->page_stroke_id;
            }
        }

        $allBlocks = PageStrokeModule::query()->where('page_stroke_id', $pageStrokeId)
            ->orderBy('page_stroke_id')->get();

        self::reindexBlocks($allBlocks);

        return $this->success($allBlocks);
    }
}