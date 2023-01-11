<?php


namespace App\Traits;


use App\Models\Page as PageModel;
use Auth;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

trait Page
{
    public static function validatePage($data, $except = [], $customErrors = [],
                                        $customMessages = []): array|JsonResponse|string
    {
        $default = [
            'title' => 'required',
            'page_stroke_id' => 'required',
            'id' => 'required'
        ];

        $messages = [
            'title.required' => 'Не задано имя страницы',
            'page_stroke_id.required' => 'Не задан ID строки',
            'id.required' => 'Не задан ID страницы'
        ];

        $messagesMerged = array_merge($messages, $customMessages);

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        $validator = Validator::make($data, $rules, $messagesMerged);

        if ($validator->fails()) {
            return Response::response()->error($validator->errors());
        }

        $page = PageModel::query()->find($data['id']);

        if (!$page) {
            return Response::response()->error('Страница не найдена');
        }

        return compact('page');
    }

    #[ArrayShape(['title' => "mixed", 'slug' => "mixed|null", 'site_id' => "mixed", 'user_id' => "mixed",
        'is_edit_mode' => "int", 'is_active' => "int", 'seo_title' => "mixed|null", 'seo_description' => "mixed|null",
        'seo_keywords' => "mixed|null"])]
    public static function getData($data): array
    {
        return [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? null,
            'site_id' => get_site()->id,
            'user_id' => Auth::user()->id,
            'is_edit_mode' => isset($data['is_edit_mode']) ? (int)$data['is_edit_mode'] : 0,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 0,
            'seo_title' => $data['seo_title'] ?? null,
            'seo_description' => $data['seo_description'] ?? null,
            'seo_keywords' => $data['seo_keywords'] ?? null
        ];
    }
}