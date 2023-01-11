<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Section;
use App\Models\Site;
use App\Traits\Activity;
use App\Traits\Menu as MenuTrait;
use App\Traits\SiteMenu;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller
{
    /**
     * @activity done
     */
    use Activity;
    use SiteMenu;
    use MenuTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Menu::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['index']);
    }

    /**
     * @param string|null $json
     * @param string|null $hashedImg
     * @param string|null $domain
     * @return false|JsonResponse|string
     * @api {POST} /api/menu Меню для сайта
     * @apiGroup Menu
     * @apiParam {string} token Токен ключ пользователя
     */
    public function index(string $json = null, string $hashedImg = null, string $domain = null): bool|JsonResponse|string
    {
        $data = ['site' => null];

        if (!$domain) {
            $domain = env('DOMAIN');
        }

        $site = Site::whereDomain($domain)->first();

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('WEBSOCKET SITE: ' . $domain);
        }

        $urls = $site->menu()->visible(1)->orderBy('sort_order')->get()->toSortedHierarchy();

        foreach ($urls as $index => $menu) {
            $imageUrl = $menu->imageUrl('70x70', 'menu');
            $imageUrl = isset($hashedImg) ? ($imageUrl . '?' . sha1($imageUrl)) : $imageUrl;

            $data['site'][$index] = [
                'link' => $menu->url,
                'text' => $menu->title,
                'id' => $menu->id,
                'img' => $imageUrl,
                'children' => $menu->children
            ];

            if ((int)$menu->as_tree == 1) {
                $root = Section::roots()->bySite($site->id)->whereIsSecret(0)->first();
                $data['site'][$index]['children'] = $this->getChildren($site, $root, $hashedImg);
            }
        }

        if (!$json) {
            return $this->success($data);
        } else {
            return json_encode($data);
        }
    }

    /**
     * @param Request $request
     * @return bool|Validator|JsonResponse|string
     * @api {POST} /api/menu/create Создание пункта меню
     * @apiGroup Main Menu
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} title Название
     * @apiParam {string} url URL
     * @apiParam {string} image URL картинки
     * @apiParam {string} sort_order Порядок сортировки
     * @apiParam {integer} parent_id ID родителя
     */
    public function create(Request $request): bool|Validator|JsonResponse|string
    {
        $site = get_site();

        $result = self::getParentId($request);

        if (!is_array($result)) {
            return $result;
        }

        $url = Menu::query()->firstOrCreate($result);

        $this->setIsSystem(false);
        $this->setParams($url);
        $this->createActivity();

        $urls = Menu::query()->bySite($site->id)->orderBy('sort_order')->get()->toSortedHierarchy()->toArray();
        $urls = array_values($urls);

        return $this->success($urls);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/menu/update Обновление пункта меню
     * @apiGroup Main Menu
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} title Название для блока
     * @apiParam {integer} id ID пункта меню
     * @apiParam {string} url URL
     * @apiParam {string} image URL картинки
     * @apiParam {string} sort_order Порядок сортировки
     * @apiParam {integer} parent_id ID родителя
     */
    public function update(Request $request): bool|JsonResponse|string
    {
        $site = get_site();
        $data = $request->all();

        $result = self::getParent($data);

        if (!is_int($result)) {
            return $this->error($result);
        } else {
            $parentId = $result;
        }

        $result = $this->checkUrl($site, $data);

        if (!is_array($result)) {
            return $result;
        }

        $result['url']->update([
            'title' => strip_tags(trim($data['title'])),
            'sort_order' => (int)$data['sort_order'],
            'url' => $data['url'],
            'image' => $data['image'] ?? null,
            'parent_id' => $parentId,
            'site_id' => $site->id
        ]);

        return $this->getSuccess($result['url']);
    }

    public function checkUrl($site, $data): Menu|JsonResponse|array
    {
        $url = Menu::query()->bySite($site->id)->enabled()->whereId((int)$data['id'])->first();

        if (!$url) {
            return $this->error('URL не найден');
        }

        return compact('url');
    }

    public function getSuccess($url): JsonResponse
    {
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
     * @api {POST} /api/menu/sort Сортировка меню
     * @apiGroup Main Menu
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {array} urls массив в виде urls[0][id], urls[0][sort_order].
     *
     */
    public function sort(Request $request)
    {
        $site = get_site();
        $data = $request->all();

        $urlArray = null;

        if (!isset($data['urls']) || empty($data['urls'])) {
            return $this->error('Не задан массив пунктов меню');
        } else {

            foreach ($data['urls'] as $item) {
                if (!empty($item['id']) && !empty($item['sort_order'])) {
                    $url = Menu::query()->bySite($site->id)->enabled()->whereId($item['id'])->first();

                    if ($url) {
                        $url->update(['sort_order' => (int)$item['sort_order']]);
                        if (!$urlArray) {
                            $urlArray = $url->toArray();
                        }
                    }
                }
            }
        }

        self::reindexUrls($urlArray, $site->id);

        $urls = Menu::query()->bySite($site->id)->enabled()->orderBy('sort_order')->get()
            ->toSortedHierarchy()->toArray();

        $urls = array_values($urls);

        return $this->success($urls);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @apiGroup Main Menu
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} is_visible 0 - невидимая ссылка, 1 - видимая
     * @apiParam {integer} id ID пункта меню
     */
    public function setVisible(Request $request): bool|JsonResponse|string
    {
        $site = get_site();
        $data = $request->all();

        $result = $this->checkUrl($site, $data);

        if (!is_array($result)) {
            return $result;
        }

        $result['url']->update([
            'is_visible' => (int)$data['is_visible'],
        ]);

        return $this->getSuccess($result['url']);
    }

    public function form(Request $request): JsonResponse
    {
        $data = $request->all();
        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/menu/delete Удаление пункта меню
     * @apiGroup Main Menu
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID пункта меню
     *
     */
    public function delete(Request $request)
    {
        $site = get_site();
        $id = $request->get('id');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $url = Menu::query()->enabled()->find($id);

        $result = $this->deleteUrl($url);

        if (!is_array($result)) {
            return $result;
        }

        self::reindexUrls($result, $site->id);

        $urls = Menu::query()->bySite($site->id)->orderBy('sort_order')->get()->toHierarchy()->toArray();

        $urls = array_values($urls);

        return $this->success($urls);
    }
}