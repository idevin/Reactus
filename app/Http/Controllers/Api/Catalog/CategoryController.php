<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Controller;
use App\Models\NeoCategory;
use App\Models\NeoUserCard;
use App\Traits\Activity;
use App\Traits\NeoObject;
use App\Traits\User;
use App\Traits\Utils;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class CategoryController extends Controller
{
    use User;
    use Activity;
    use NeoObject;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(NeoCategory::class);
        $this->setFromObject(\App\Models\User::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
    }

    /**
     * @param Request $request
     * @return bool|JsonResponse|string
     * @api {GET} /api/catalog/categories Список категорий каталога
     * @apiGroup Catalog
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} catalog_id каталог пользователя
     * @apiParam {integer} parent_id сделать вывод части дерева
     *
     * @internal param Request $request
     */
    public function index(Request $request): JsonResponse|bool|string
    {
        $data = $request->all();
        $user = $this->publicUser();

        if (empty($data['catalog_id'])) {
            return $this->error('Не задан ID каталога');
        }

        $neoUser = NeoUserCard::query()->whereUserId($user->id)->first();

        if (!$neoUser) {
            return $this->error('Каталогов не найдено. Добавьте сначала каталог.');
        }

        $catalog = $neoUser->catalogs()->find((int)$data['catalog_id']);

        if (!$catalog) {
            return $this->error('Каталог не неайден');
        }

        $data = [];
        $categories = NeoCategory::tree($catalog->categories, $data);

        return $this->success(compact("categories"));
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/catalog/category/create Создание категории
     * @apiGroup Catalog
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {string} title название категории
     * @apiParam {string} description краткое описание
     * @apiParam {Text} content полное описание
     * @apiParam {integer} parent_id родительский раздел
     *
     * @internal param Request $request
     */
    public function create(Request $request): JsonResponse|bool|string
    {
        $data = $request->all();

        $validator = self::createValidator($data);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $title = Utils::cleanChars($data['title']);

        $category = NeoCategory::query()->firstOrCreate(self::getData($data, $title));

        if (!empty($data['parent_id'])) {
            $parentCategory = NeoCategory::query()->find((int)$data['parent_id']);
            $hasConnection = $parentCategory?->children()->find($category->id);
            if (!$hasConnection) {
                $parentCategory?->categories()->attach($category);
            }
        }

        return $this->success(NeoCategory::tree());
    }

    public static function createValidator($data, $except = [],
                                           $customErrors = [], $customMessages = []): \Illuminate\Validation\Validator
    {
        $default = [
            'title' => 'required',
            'description' => 'nullable',
            'parent_id' => 'nullable'
        ];

        $messages = [
            'title.required' => 'Не задано название категории'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function getData($data, $title): array
    {
        return [
            'title' => $title,
            'description' => !empty($data['description']) ? $data['description'] : null,
            'content' => !empty($data['content']) ? $data['content'] : null,
            'alias' => !empty($data['alias']) ? $data['alias'] : null,
            'seo_title' => !empty($data['seo_title']) ? $data['seo_title'] : null,
            'seo_description' => !empty($data['seo_description']) ? $data['seo_description'] : null,
            'seo_keywords' => !empty($data['seo_keywords']) ? $data['seo_keywords'] : null,
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'user_id' => \Auth::user()->id
        ];
    }

    /**
     * @param Request $request
     * @return array|bool|JsonResponse|string
     * @api {GET} /api/catalog/category/update Обновление категории
     * @apiGroup Catalog
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID раздела
     * @apiParam {string} title имя категории
     * @apiParam {string} description краткое описание
     * @apiParam {Text} content полное описание
     * @apiParam {integer} parent_id родительский раздел
     *
     * @internal param Request $request
     */
    public function update(Request $request): JsonResponse|bool|array|string
    {
        $data = $request->all();

        $customErrors['id'] = 'required';
        $customMessages['id.required'] = 'Не задан ID категории';

        $validator = self::createValidator($data, [], $customErrors, $customMessages);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $title = Utils::cleanChars($data['title']);

        $category = NeoCategory::query()->find($data['id']);

        if (!$category) {
            return $this->error('Раздел не найден');
        }

        $category->update(self::getData($data, $title));


        if ((int)$data['parent_id'] >= 0) {
            $parent = NeoCategory::query()->find((int)$data['parent_id']);

            if(!$parent) {
                return $this->error('Родительский раздел не найден');
            }

            $childExists = $parent->children()->find($category->id);

            if ($category->parent && $category->parent->id != (int)$data['parent_id']) {
                $category->parent()->edge()->delete();
            }

            if (!$childExists) {
                $parent->children()->attach($category);
            }
        }

        return $this->success(NeoCategory::tree());
    }

    /**
     * @param Request $request
     * @return array|bool|JsonResponse|string
     * @api {POST} /api/catalog/category/delete Удаление категории
     * @apiGroup Catalog
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID раздела
     *
     * @internal param Request $request
     */
    public function delete(Request $request): JsonResponse|bool|array|string
    {
        $data = $request->all();

        $customErrors['id'] = 'required';
        $customMessages['id.required'] = 'Не задан ID категории';

        $except = ['title', 'description', 'parent_id'];

        $validator = self::createValidator($data, $except, $customErrors, $customMessages);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $category = NeoCategory::query()->find($data['id']);

        if (!$category) {
            return $this->error('Раздел не найден');
        }

        $category->delete();

        return $this->success(NeoCategory::tree());
    }
}