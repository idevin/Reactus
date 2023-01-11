<?php


namespace App\Traits;


use App\Models\Modules\Module;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

trait PageStrokeBlock
{
    public static function validatePageStrokeBlock($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $modules = Module::getModules()->pluck('class')->toArray();
        $modules = implode(',', $modules);

        $default = [
            'page_stroke_id' => 'required',
            'module_class' => 'required|in:' . $modules,
            'page_id' => 'required',
            'template_id' => 'required'
        ];

        $messages = [
            'page_stroke_id.required' => 'На задан ID строки',
            'module_class.required' => 'Не задан класс модуля',
            'page_id.required' => 'Не задан ID страницы',
            'module_class.in' => 'Модуль не найден',
            'template_id.required' => 'Не заданы данные для шаблона'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    #[ArrayShape(['page_stroke_id' => "mixed", 'sort_order' => "int", 'is_active' => "int", 'module_class' => "mixed",
        'template_id' => "mixed", 'module_id' => "null", 'content_options' => "mixed|null"])]
    public static function getData($data): array
    {
        return [
            'page_stroke_id' => $data['page_stroke_id'],
            'sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : 1,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 0,
            'module_class' => $data['module_class'],
            'template_id' => $data['template_id'],
            'module_id' => null,
            'content_options' => $data['content_options'] ?? null
        ];
    }

    public static function reindexBlocks($blocks)
    {
        $grouped = $blocks->groupBy('page_stroke_id');

        if (count($grouped) > 0) {
            foreach ($grouped as $strokes) {
                $strokes = $strokes->sortBy('sort_order');

                Utils::updateSortOrder($strokes, start: 1);
            }
        }

        return $grouped;
    }
}