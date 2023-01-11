<?php

namespace App\Traits;

use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSlider;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Validator;

trait Slide
{
    public static function validator($data)
    {
        $customErrors = [];
        $customMessages = [];

        $response = new class {
            use Response;
        };

        if ($data['slider_type'] == ModuleSlider::STATIC_TYPE) {
            $customErrors = [
                'url' => 'required',
                'name' => 'required',
                'short_description' => 'required',
                'image' => 'required'
            ];

            $customMessages = [
                'url.required' => 'URL обязателен для заполнения',
                'url.url' => 'неверный URL',
                'name.required' => 'Напишите заголовок',
                'url.our_domain' => 'URL не найден или не принадлежит сайту',
                'short_description.required' => 'Анонс обязателен для заполнения',
                'image.required' => 'Выберите фото'
            ];

        } else if ((int)$data['slider_type'] === ModuleSlider::DYNAMIC_TYPE) {
            $customErrors = [
                'slides_count' => 'required|in:' . implode(',', ModuleSlide::$slidesCount),
                'name' => 'required',
                'content_type' => 'required|in:' .
                    implode(',', array_values(ModuleSlide::mapConstants(ModuleSlide::$contentTypes))),
                'sort_by' => 'required|in:' .
                    implode(',', array_values(ModuleSlide::mapConstants(ModuleSlide::$sortBy))),
                'period' => 'required|in:' .
                    implode(',', array_values(ModuleSlide::mapConstants(ModuleSlide::$periods))),
                'sort_order' => 'required|in:' .
                    implode(',', array_values(ModuleSlide::mapConstants(ModuleSlide::$sortOrder))),
                'publish' => 'required|in:' .
                    implode(',', array_values(ModuleSlide::mapConstants(ModuleSlide::$publish))),
            ];

            $customMessages = [
                'period.in' => 'Неверное значение выборки периода',
                'publish.in' => 'Неверное значение публикации',
                'slides_count.in' => 'Неверное значение кол-ва слайдов',
                'slides_count.required' => 'Выберите количество слайдов',
                'name.required' => 'Не написано название',
                'content_type.required' => 'Не выбран тип контента',
                'content_type.in' => 'Неверное значение типа контента',
                'sort_by.required' => 'Не выбрана сортировка выборки',
                'sort_by.in' => 'Неверная сортировка выборки',
                'sort_order.required' => 'Не выбрано направление сортировки',
                'sort_order.in' => 'Неверное направление сортировки'
            ];

            if (!empty($data['period']) && (int)$data['period'] === ModuleSlide::PERIOD_CUSTOM) {

                $customErrors['period_start'] = 'required|date';
                $customErrors['period_end'] = 'required|date';

                $customMessages['period_start.required'] = 'Начало выборки не задано';
                $customMessages['period_end.required'] = 'Не задан конец выборки';
                $customMessages['period_start.date'] = 'Начало выборки - неверная дата';
                $customMessages['period_end.date'] = 'Не задан конец выборки - неверная дата';
            }

            if (!empty($data['publish']) && (int)$data['publish'] === ModuleSlide::PUBLISH_CUSTOM) {

                $customErrors['publish_start'] = 'required|date';
                $customErrors['publish_end'] = 'required|date';

                $customMessages['publish_start.required'] = 'Не задано начало даты публикации';
                $customMessages['publish_end.required'] = 'Не задан конец даты публикации';
                $customMessages['publish_start.date'] = 'Начало публикации - неверная дата';
                $customMessages['publish_end.date'] = 'Конец публикации - неверная дата';
            }
        }

        $validator = static::createSlideValidator($data, [], $customErrors, $customMessages);

        if ($validator->fails()) {
            return $response->error($validator->errors());
        }

        return $response->success();
    }

    public static function createSlideValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {

        $in = implode(',', array_values(ModuleSlider::mapConstants(ModuleSlider::$sliderTypes)));

        $default = [
            'url' => 'required',
            'slider_type' => 'required|in:' . $in
        ];

        $messages = [
            'slider_type.required' => 'Не задан тип слайдера',
            'slider_type.in' => 'Неверный тип слайдера',
            'url.required' => 'URL обязателен для заполнения',
            'url.url' => 'неверный URL'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createSliderValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'slides' => 'required|array',
            'navigation' => 'required',
            'module_id' => 'required',
            'miniature' => 'required',
            'view' => 'required',
            'block_type' => 'required',
            'module_settings_id' => 'required'
        ];

        $messages = [
            'navigation.required' => 'Выберите навигацию',
            'miniature.required' => 'Выберите миниатюру',
            'block_type.required' => 'Выберите тип блока',
            'module_settings_id.required' => 'Настройки модуля не найдены',
            'module_id' => 'Не задан ID модуля',
            'slides' => 'Не заданы слайды'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createSlide($data, $moduleSlider): Model|Collection|Builder|ModuleSlide|array
    {
        $url = $data['url'] ?? null;

        $name = $data['name'] ?? null;

        $shortDescription = isset($data['short_description']) ?
            truncate_content($data['short_description'], 160, true, true) : null;

        $publishStart = date('Y-m-d H:i:s');

        $title = $data['title'] ?? null;

        if (!empty($data['publish_end'])) {
            $publishEnd = date('Y-m-d H:i:s', strtotime($data['publish_end']));
        } else {
            $publishEnd = null;
        }

        if (isset($data['roles']) && is_array($data['roles'])) {
            $roles = (new Role)->whereIn('id', $data['roles'])->get()->pluck(['id'])->toArray();
        } else {
            $roles = null;
        }

        if (!isset($data['sort_order']) || empty($data['sort_order'])
            || !in_array($data['sort_order'], array_values(ModuleSlide::mapConstants(ModuleSlide::$sortOrder)))
        ) {
            $sortOrder = ModuleSlide::$sortOrder[0]['id'];
        } else {
            $sortOrder = $data['sort_order'] ?? null;
        }

        if (isset($data['sort_by']) && in_array($data['sort_by'], array_keys(ModuleSlide::$sortBy))) {
            $sortBy = $data['sort_by'];
        } else {
            $sortBy = null;
        }

        if (!isset($data['slides_count']) || empty($data['slides_count'])) {
            $slidesCount = 1;
        } else {
            if (!in_array($data['slides_count'], ModuleSlide::$slidesCount)) {
                $slidesCount = 1;
            } else {
                $slidesCount = $data['slides_count'];
            }
        }

        if (!isset($data['content_type']) ||
            !in_array($data['content_type'], array_values(ModuleSlide::mapConstants(ModuleSlide::$contentTypes)))
        ) {
            $contentType = ModuleSlide::CONTENT_TYPE_ARTICLE;
        } else {
            $contentType = $data['content_type'];
        }

        $period = $data['period'] ?? null;

        if (!empty($data['period_start'])) {
            $periodStart = date('Y-m-d H:i:s', strtotime($data['period_start']));
        } else {
            $periodStart = null;
        }

        if (!empty($data['period_end'])) {
            $periodEnd = date('Y-m-d H:i:s', strtotime($data['period_end']));
        } else {
            $periodEnd = null;
        }

        if (!empty($data['publish']) &&
            in_array((int)$data['publish'], array_values(ModuleSlide::mapConstants(ModuleSlide::$publish)))
        ) {
            $publish = $data['publish'];
        } else {
            $defaultPublish = array_filter(ModuleSlide::$publish, function ($i) {
                return $i['default'] === 1;
            });
            $defaultPublish = current(array_values($defaultPublish));

            $publish = $defaultPublish['id'];
        }

        if (!empty($data['image']) && !empty($data['image']['id'])) {
            $imageId = $data['image']['id'];
        } else {
            $imageId = null;
        }

        if ($period && !in_array($period, array_values(ModuleSlide::mapConstants(ModuleSlide::$periods)))) {
            $period = null;
        }

        $actionLevel = $data['action_level'] ?? null;

        $sectionId = $data['section_id'] ?? null;

        $articleId = $data['article_id'] ?? null;

        if (isset($slide['hide_title'])) {
            $hideTitle = (int)$slide['hide_title'];
        } else {
            $hideTitle = 0;
        }

        if (isset($slide['hide_title'])) {
            $hide = (int)$slide['hide'];
        } else {
            $hide = 0;
        }

        $slideData = [
            'module_slider_id' => $moduleSlider->id,
            'roles' => $roles,
            'sort_order' => $sortOrder,
            'url' => $url,
            'name' => $name,
            'title' => $title,
            'slider_type' => $data['slider_type'],
            'short_description' => $shortDescription,
            'publish' => $publish,
            'publish_start' => $publishStart,
            'publish_end' => $publishEnd,
            'slides_count' => $slidesCount,
            'content_type' => $contentType,
            'sort_by' => $sortBy,
            'period' => $period,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'image_id' => $imageId,
            'action_level' => $actionLevel,
            'section_id' => $sectionId,
            'article_id' => $articleId,
            'hide_title' => $hideTitle,
            'hide' => $hide
        ];

        if (!$imageId) {
            unset($slideData['image_id']);
        }

        if (isset($data['id'])) {
            $moduleSlide = ModuleSlide::query()->find($data['id']);

            if (!$moduleSlide) {
                return Response::response()->error('Слайд не найден');
            }

            $moduleSlide->update($slideData);
            $moduleSlide->refresh();

        } else {
            $moduleSlide = ModuleSlide::create($slideData);
        }

        return $moduleSlide;
    }
}