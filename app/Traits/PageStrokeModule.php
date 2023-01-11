<?php


namespace App\Traits;


use App\Models\Modules\Module;
use App\Models\PageStroke;
use Illuminate\Http\JsonResponse;
use Validator;

trait PageStrokeModule
{
    public static function validatePageStrokeModule($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $modules = Module::getModules()->pluck('class')->toArray();
        $modules = implode(',', $modules);

        $default = [
            'page_stroke_id' => 'required',
            'module_class' => 'required|in:' . $modules,
            'settings' => 'required|json',
            'page_id' => 'required'
        ];

        $messages = [
            'page_stroke_id.required' => 'На задан ID строки',
            'module_class.required' => 'Не задан модуль',
            'settings.json' => 'Невалидный JSON',
            'settings.required' => 'Не заданы настройки',
            'page_id.required' => 'Не задан ID страницы',
            'module_class.in' => 'Модуль не найден'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function getData($data, $except = null): array
    {
        $defaultData = [
            'page_stroke_id' => $data['page_stroke_id'],
            'sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : 1,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'module_class' => $data['module_class'],
            'module_id' => isset($data['module_id']) ? (int)$data['module_id'] : null,
            'template_id' => $data['template_id'] ?? null,
            'content_options' => $data['content_options'] ?? null
        ];

        if ($except && is_array($except)) {
            $defaultData = collect($defaultData)->except($except)->toArray();
        }

        return $defaultData;
    }

    public static function validateModule($data): JsonResponse|array|bool
    {
        $pageStroke = PageStroke::query()->find($data['page_stroke_id']);

        if (!$pageStroke) {
            return Response::response()->error('Строка не найдена');
        }

        $page = $pageStroke->page;

        $module = \App\Models\PageStrokeModule::query()->find($data['id']);

        if (!$module) {
            return Response::response()->error('Модуль не найден');
        }

        if ($module->module_class !== $data['module_class']) {
            return Response::response()->error('Классы модуля не совпадают:' . $module->module_class);
        }

        return compact('page', 'module', 'pageStroke');
    }
}