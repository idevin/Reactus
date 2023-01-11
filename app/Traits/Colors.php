<?php

namespace App\Traits;

use App\Models\Site;
use App\Models\Template;
use App\Models\TemplateScheme;

trait Colors
{
    /**
     * @param array $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return mixed
     */
    public static function validator(array $data, array $except = [],
                                     array $customErrors = [], array $customMessages = []): mixed
    {
        $default = [
            'name' => 'required',
            'colors' => 'required|json',
            'template_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Имя обязательно для заполнения',
            'colors.required' => 'Не заданы цвета',
            'colors.json' => 'Невалидный JSON цветовой схемы',
            'template_id.required' => 'Не задан ID шаблона'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function check($request) {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return Response::response()->error('Сайт не найден');
        }

        $data = $request->all();

        $customErrors = [
            'template_scheme_id' => 'required'
        ];

        $customMessages = [
            'template_scheme_id.required' => 'Не задан ID цветовой схемы'
        ];

        $validator = self::validator($data, [], $customErrors, $customMessages);

        if ($validator->fails()) {
            return Response::response()->error($validator->errors());
        }

        $template = Template::query()->find((int)$data['template_id']);

        if (!$template) {
            return Response::response()->error('Шаблон не найден');
        }

        $scheme = TemplateScheme::query()->find($data['template_scheme_id']);

        if (!$scheme) {
            return Response::response()->error('Не найдена цветовая схема');
        }

        return compact('template', 'data', 'scheme');
    }
}