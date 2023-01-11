<?php

namespace App\Traits;

use App\Models\Modules\ModuleMenuAdvanced;
use App\Models\Modules\ModuleMenuAdvancedUrl;
use Validator;

trait MenuAdvanced
{
    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return mixed
     */
    public static function createMenuAdvancedValidator($data, array $except = [], array $customErrors = [],
                                                       array $customMessages = []): mixed
    {
        $default = [
            'name' => 'required',
            'sort_order' => 'required|numeric',
            'url' => 'required',
            'module_menu_advanced_id' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Название для ссылки пустое',
            'url.required' => 'Поле Url пустое',
            'module_menu_advanced_id.required' => 'Не задан ID меню',
            'sort_order.required' => 'Не задан порядок сортировки для ссылок',
            'sort_order.numeric' => 'Неверный порядок сортировки',
        ];

        $validator = Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);

        if ($validator->fails()) {
            return Response::response()->error($validator->errors());
        }

        $menu = ModuleMenuAdvanced::query()->find(self::getModuleMenuAdvancedId($data['module_menu_advanced_id']));

        if (!$menu) {
            return Response::response()->error('Не найден модуль меню');
        }

        $parentId = null;

        if (isset($data['parent_id'])) {
            $parent = ModuleMenuAdvancedUrl::query()->find((int)$data['parent_id']);
            $parentId = $parent?->id;
        }

        return compact('parentId', 'menu');
    }

    public static function getModuleMenuAdvancedId($id)
    {
        $strokeModule = \App\Models\PageStrokeModule::query()->find($id);
        return $strokeModule->module_id;
    }

    /**
     * @param array $url
     * @return mixed
     */
    public static function reindexUrls(array $url): mixed
    {
        $urls = ModuleMenuAdvancedUrl::query()->orderBy('sort_order')
            ->whereModuleMenuAdvancedId($url['module_menu_advanced_id']);

        if ($url['parent_id']) {
            $urls = $urls->whereParentId($url['parent_id']);
        }

        $urls = $urls->get(['id', 'sort_order']);

        return Utils::updateSortOrder($urls);
    }
}