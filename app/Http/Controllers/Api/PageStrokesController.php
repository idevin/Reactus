<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageRevision;
use App\Models\PageStroke;
use App\Traits\Activity;
use App\Traits\PageStroke as PageStrokeTrait;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageStrokesController extends Controller
{
    /**
     * @activity done
     */
    use Activity;
    use PageStrokeTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(PageStroke::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['index']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/sort Сортировка строк
     * @apiGroup Page Strokes
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} page_id ID страницы
     * @apiParam {array} strokes Массив строк для сортировки (strokes[N][id]=X, strokes[N][position]=Y,
     * strokes[N][sort_order]=Z...), позиция строки- position ("1-header, 2-footer, 3-content")
     */
    public function sort(Request $request)
    {
        $data = $request->all();

        if (empty($data['page_id'])) {
            return $this->error('Не задан ID страницы');
        }

        if (empty($data['strokes']) || !is_array($data['strokes'])) {
            return $this->error('Не найден массив строк');
        }

        $page = Page::query()->with(['header', 'footer', 'content'])->find($data['page_id']);

        if (!$page) {
            return $this->error('Страница не найдена');
        }

        $allStrokes = collect();

        foreach ($data['strokes'] as $stroke) {
            if (empty($stroke['id'])) {
                return $this->error('Не задан либо неверный параметр ID');
            }

            if (empty($stroke['sort_order'])) {
                return $this->error('Не задан параметр сортировки');
            }

            if (empty($stroke['position']) || !in_array($stroke['position'], array_keys(PageStroke::$positions))) {
                return $this->error('Не задана позиция');
            }

            $strokeObject = PageStroke::query()->find($stroke['id']);

            if (!$strokeObject) {
                return $this->error('Строка не найдена');
            }

            $strokeObject->update([
                'sort_order' => (int)$stroke['sort_order'],
                'position' => (int)$stroke['position']
            ]);

            $strokeObject->refresh();

            $allStrokes[] = $strokeObject;
        }

        foreach (PageStroke::$positions as $index => $position) {
            self::reindexStrokes($page, $index);
        }

        $page->refresh();

        foreach (PageStroke::$positions as $index => $position) {
            $page->$position->makeHidden(['deleted_at', 'page_id', 'position', 'is_active', 'template_id',
                'modules', 'content_options']);
        }

        PageRevision::createRevision($page, PageRevision::SORT_STROKES, $allStrokes);

        return $this->success($page);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/create Создание строки
     * @apiGroup Page Strokes
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {boolean} is_active активная неактивная строка (0 - неактивная, 1 - активная. Не обязательно.)
     * @apiParam {boolean} position позиция строки (1 - шапка, 2 - подвал, 3 - контент)
     * @apiParam {integer} sort_order Порядок сортировки
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} content_options настройки внешнего вида
     * @apiParam {integer} template_id шаблон строки
     */
    public function create(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $result = self::validatePageStroke($data);

        if (isset($result['error'])) {
            return $this->error($result->errors());
        }

        $stroke = PageStroke::with('modules')->create(self::getData($data));

        $stroke->refresh();

        $strokes = self::reindexStrokes($result['page'], $data['position']);

        PageRevision::createRevision($result['page'], PageRevision::ADD_STROKE, $stroke);

        return $this->success([
            'stroke' => $stroke,
            'sort_data' => $strokes
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/update Обновление строки
     * @apiGroup Page Strokes
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {boolean} is_active активная неактивная строка (0 - неактивная, 1 - активная. Не обязательно.)
     * @apiParam {boolean} position позиция строки (1 - шапка, 2 - контент, 3 - подвал)
     * @apiParam {integer} sort_order Порядок сортировки
     * @apiParam {integer} id ID строки
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} template_id шаблон строки
     * @apiParam {integer} content_options настройки внешнего вида
     */
    public function update(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $result = self::validatePageStroke($data, [], ['id' => 'required'], ['id.required' => 'Не задан ID строки']);

        if (isset($result['error'])) {
            return $this->error($result->errors());
        }

        $page = Page::query()->find($data['page_id']);

        if (!$page) {
            return $this->error('Страница не найдена');
        }

        $stroke = PageStroke::query()->find($data['id']);

        if (!$stroke) {
            return $this->error('Строка не найдена');
        }

        $stroke->update(self::getData($data));

        $sortData = self::reindexStrokes($page, $data['position']);

        $stroke->refresh();

        PageRevision::createRevision($page, PageRevision::UPDATE_STROKE, $stroke);

        return $this->success([
            'stroke' => $stroke,
            'sort_data' => $sortData
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/delete Удаление строки
     * @apiGroup Page Strokes
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID строки
     * @apiParam {integer} page_id ID страницы
     */
    public function delete(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $result = self::validatePageStroke($data, ['position', 'template_id'], ['id' => 'required'],
            ['id.required' => 'Не задан ID строки']);

        if ($result['error']) {
            return $this->error($result['error']);
        }

        $strokes = $result['page']->strokes()->wherePosition($result['stroke']->position)->get();

        $newStroke = null;

        if (count($strokes) == 1) {
            $data['position'] = $result['stroke']->position;
            $data['template_id'] = $result['stroke']->template_id;
            $newStroke = PageStroke::query()->create(self::getData($data));
        }

        $result['stroke']->delete();

        PageRevision::createRevision($result['page'], PageRevision::DELETE_STROKE, $result['stroke']);

        return $this->success($newStroke);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/pages/stroke/active Активность строки
     * @apiGroup Page Strokes
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID строки
     * @apiParam {integer} page_id ID страницы
     * @apiParam {integer} is_active Флаг активности (0 - неактивная, 1 - активная)
     */
    public function active(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $flags = implode(',', PageStroke::$activeFlags);

        $errors = [
            'id' => 'required',
            'is_active' => 'required|in:' . $flags
        ];
        $messages = [
            'id.required' => 'Не задан ID строки',
            'is_active.required' => 'Не задан флаг активности',
            'is_active.in' => 'Неверный флаг активности (' . $flags . ')'
        ];

        $result = self::validatePageStroke($data, ['position'], $errors, $messages);

        if ($result['error']) {
            return $this->error($result['error']);
        }

        $result['stroke']->update([
            'is_active' => (int)$data['is_active']
        ]);

        $action = PageRevision::ACTIVE_STROKE;

        if ((int)$data['is_active'] == 0) {
            $action = PageRevision::UNACTIVE_STROKE;
        }

        PageRevision::createRevision($result['page'], $action, $result['stroke']);

        return $this->success();
    }
}