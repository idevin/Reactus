<?php


namespace App\Traits;

use App\Models\Page;
use App\Models\PageStroke as PageStrokeModel;
use JetBrains\PhpStorm\ArrayShape;

trait PageStroke
{
    public static function validatePageStroke($data, $except = [], $customErrors = [], $customMessages = []): array
    {
        $error = null;

        $default = [
            'page_id' => 'required',
            'position' => 'required|in:' . implode(',', array_keys(PageStrokeModel::$positions)),
            'template_id' => 'required'
        ];

        $messages = [
            'page_id.required' => 'На задан ID страницы',
            'position.required' => 'Не задана позиция строки',
            'template_id.required' => 'Не задан шаблон'
        ];

        $validator = Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);

        if ($validator->fails()) {
            $error = $validator->errors();
            return compact('error');
        }

        $page = Page::query()->find($data['page_id']);

        if (!$page) {
            $error = 'Страница не найдена';
            return compact('error');
        }

        $compact = [];

        if (isset($data['id'])) {
            $stroke = PageStrokeModel::query()->wherePageId($page->id)->whereId($data['id'])->first();

            if (!$stroke) {
                $error = 'Строка не найдена';
                return compact('error');
            }
            $compact = compact('stroke');
        }

        return $compact + compact('page', 'error');
    }

    #[ArrayShape(['page_id' => "mixed", 'sort_order' => "int",
        'position' => "int", 'is_active' => "int", 'template_id' => "mixed", 'content_options' => "mixed|null"])]
    public static function getData($data): array
    {
        return [
            'page_id' => $data['page_id'],
            'sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : 1,
            'position' => isset($data['position']) ? (int)$data['position'] : 0,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'template_id' => $data['template_id'],
            'content_options' => $data['content_options'] ?? null
        ];
    }

    public static function reindexStrokes($page, $position)
    {
        $method = PageStrokeModel::$positions[$position];

        $strokes = $page->{$method}()->orderBy('sort_order', 'asc')->without(['modules'])->get(['id', 'sort_order']);

        return Utils::updateSortOrder($strokes);
    }
}