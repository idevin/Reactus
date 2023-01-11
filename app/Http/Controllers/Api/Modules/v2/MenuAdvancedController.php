<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Modules\ModuleMenuAdvanced;
use App\Models\Modules\ModuleMenuAdvancedUrl;
use App\Models\Page;
use App\Models\Section;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Menu as MenuTrait;
use App\Traits\MenuAdvanced;
use App\Traits\Module as ModuleTrait;
use Auth;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\RouteCompiler;
use Route;
use Session;
use Symfony\Component\HttpFoundation\Request;

class MenuAdvancedController extends Controller
{
    /**
     * @activity done
     */
    public static User|null $user = null;

    use MenuAdvanced;
    use ModuleTrait;
    use Activity;
    use MenuTrait;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        Session::forget('site');

        $this->setObject(ModuleMenuAdvanced::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['create', 'delete', 'update']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/v2/menu_advanced/create Создание пункта меню
     * @apiGroup Block menu (advanced)
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} name Название для блока
     * @apiParam {string} url URL
     * @apiParam {string} image URL картинки
     * @apiParam {string} sort_order Порядок сортировки
     * @apiParam {integer} parent_id ID родителя
     * @apiParam {integer} module_menu_advanced_id ID модуля в системе
     */
    public function create(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $result = static::createMenuAdvancedValidator($data);

        if (!is_array($result)) {
            return $result;
        }

        $moduleMenuUrl = ModuleMenuAdvancedUrl::query()->create([
            'module_menu_advanced_id' => $result['menu']->id,
            'name' => strip_tags(trim($data['name'])),
            'sort_order' => (int)$data['sort_order'],
            'url' => $data['url'],
            'image' => $data['image'] ?? null,
            'parent_id' => $result['parentId']
        ]);

        $this->setIsSystem(false);
        $this->setParams($moduleMenuUrl->toArray());
        $this->createActivity();

        $urls = ModuleMenuAdvancedUrl::query()
            ->whereModuleMenuAdvancedId($result['menu']->id)->orderBy('sort_order')->get()
            ->toSortedHierarchy()->toArray();

        $urls = array_values($urls);

        return $this->success($urls);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/modules/v2/menu_advanced/search Поиск
     * @apiGroup Block menu (advanced)
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} term слово для поиска
     *
     */
    public function search(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $foundByUrl = null;
        $site = get_site();

        if (!isset($data['term'])) {
            return $this->error('Не задано ключевое слово или URL');
        }

        $data['term'] = base64_decode($data['term'], true);

        if (!$data['term']) {
            return $this->error('Ошибка base64');
        }

        $allData = collect();

        if ($foundByUrl) {
            $allData[] = app($foundByUrl['type'])->query()->find($foundByUrl['id']);
        }

        /**
         * @todo refactor and optimize
         */
        $articleTable = (new Article())->getTable();
        $articleSelect = DB::raw("'" . addslashes(Article::class) . "'" . ' as type, ' .
            $articleTable . '.*');

        $articles = Article::query()->active()->published()->bySite($site->id)
            ->where('title', 'like', "%{$data['term']}%")
            ->select($articleSelect)->get()->map(function ($article) {
                return collect($article->toArray())->only(['id', 'url', 'title', 'type', 'thumbs'])->all();
            });

        $sectionTable = (new Section())->getTable();
        $sectionSelect = DB::raw("'" . addslashes(Section::class) . "'" . ' as type, ' .
            $sectionTable . '.*');

        $sections = Section::query()->published()->bySite($site->id)
            ->where('title', 'like', "%{$data['term']}%")
            ->orderBy('title')->select($sectionSelect)->get()->map(function ($article) {
                return collect($article->toArray())->only(['id', 'url', 'title', 'type', 'thumbs'])->all();
            });

        $pageTable = (new Page())->getTable();
        $pageSelect = DB::raw("'" . addslashes(Page::class) . "'" . ' as type, ' .
            $pageTable . '.*');

        $pages = Page::query()->active()->bySite($site->id)
            ->where('title', 'like', "%{$data['term']}%")
            ->orderBy('title')->select($pageSelect)->get()->map(function ($page) {
                return collect($page->toArray())->only(['id', 'url', 'title', 'type'])->all();
            });

        if (count($articles) > 0) {
            $allData = $allData->merge($articles);
        }

        if (count($sections) > 0) {
            $allData = $allData->merge($sections);
        }

        if (count($pages) > 0) {
            $allData = $allData->merge($pages);
        }

        return $this->success($allData);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/v2/menu_advanced/update Обновление пункта меню
     * @apiGroup Block menu (advanced)
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} name Название для блока
     * @apiParam {integer} id ID пункта меню
     * @apiParam {string} url URL
     * @apiParam {string} image URL картинки
     * @apiParam {string} sort_order Порядок сортировки
     * @apiParam {integer} parent_id ID родителя
     * @apiParam {integer} module_menu_advanced_id ID модуля в системе
     */
    public function update(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();

        $result = static::createMenuAdvancedValidator($data);

        if (!is_array($result)) {
            return $result;
        }

        $url = ModuleMenuAdvancedUrl::query()->whereModuleMenuAdvancedId($result['menu']->id)
            ->whereId((int)$data['id'])->first();

        if (!$url) {
            return $this->error('URL не найден');
        }

        $url->update([
            'module_menu_advanced_id' => $result['menu']->id,
            'name' => strip_tags(trim($data['name'])),
            'sort_order' => (int)$data['sort_order'],
            'url' => $data['url'],
            'image' => $data['image'],
            'parent_id' => $result['parentId']
        ]);

        $url->refresh();
        $url = $url->toArray();

        $this->setIsSystem(false);
        $this->setParams($url);
        $this->createActivity();

        return $this->success($url);
    }


    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/v2/menu_advanced/sort Сортировка блока меню (advanced)
     * @apiGroup Block menu advanced
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} module_menu_advanced_id ID модуля
     * @apiParam {array} items массив в виде items[0][id], items[0][sort_order].
     *
     */
    public function sort(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $menuId = $request->get('module_menu_advanced_id');

        if (!$menuId) {
            return $this->error('Параметр module_menu_advanced_id не задан');
        }

        $moduleMenu = ModuleMenuAdvanced::find(self::getModuleMenuAdvancedId($data['module_menu_advanced_id']));

        if (!$moduleMenu) {
            return $this->error('Не найден модуль меню');
        }

        $urlArray = null;

        if (!isset($data['items']) || empty($data['items'])) {
            return $this->error('Не задан массив пунктов меню items');
        } else {

            foreach ($data['items'] as $item) {
                if (!empty($item['id']) && !empty($item['sort_order'])) {
                    $url = ModuleMenuAdvancedUrl::query()->whereModuleMenuAdvancedId($moduleMenu->id)
                        ->whereId($item['id'])->first();

                    if ($url) {
                        $url->update(['sort_order' => (int)$item['sort_order']]);
                        if (!$urlArray) {
                            $urlArray = $url->toArray();
                        }
                    }
                }
            }
        }

        self::reindexUrls($urlArray);

        /**
         * @todo duplicated code
         */
        $urls = ModuleMenuAdvancedUrl::query()
            ->whereModuleMenuAdvancedId($urlArray['module_menu_advanced_id'])
            ->orderBy('sort_order')->get()
            ->toSortedHierarchy()->toArray();

        $urls = array_values($urls);

        return $this->success($urls);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/modules/v2/menu_advanced/delete Удаление пункта меню
     * @apiGroup Block menu (advanced)
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID Url-a
     *
     */
    public function delete(Request $request): bool|JsonResponse|string
    {
        $id = $request->get('id');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $url = ModuleMenuAdvancedUrl::query()->find($id);

        $result = $this->deleteUrl($url);

        if(!is_array($result)) {
            return $result;
        }

        self::reindexUrls($result);

        $urls = ModuleMenuAdvancedUrl::query()
            ->whereModuleMenuAdvancedId($result['module_menu_advanced_id'])
            ->orderBy('sort_order')->get()
            ->toHierarchy()->toArray();

        $urls = array_values($urls);

        return $this->success($urls);
    }

    public function form(): JsonResponse
    {
        return $this->success();
    }
}