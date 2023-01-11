<?php

namespace App\Traits\Modules;

use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleComment;
use App\Models\Modules\ModuleSection;
use App\Traits\Utils;
use Auth;
use Illuminate\Validation\Validator;

trait Validators
{
    public static function createModuleTextValidator($data, $except = [], $customErrors = [],
                                                     $customMessages = []): Validator|string
    {
        $site = get_site();
        if (!Auth::user()->can('site_menu_horizontal_manage', $site)) {
            return 'У вас нет прав для редактирования меню';
        }

        if (isset($data['content'])) {
            $data['content'] = trim($data['content']);
        }

        $default = [
            'content' => 'required',
        ];

        $messages = [
            'content.required' => 'Не написан текст',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }


    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return Validator
     */
    public static function createModuleMenuValidator($data, $except = [], $customErrors = [],
                                                     $customMessages = []): Validator
    {
        $default = [
            'urls' => 'required|array',
            'urls.*.name' => 'required',
            'urls.*.sort_order' => 'required|numeric',
            'urls.*.url' => 'required|url',
            'urls.*.id' => 'required|integer'
        ];

        $messages = [
            'urls.required' => 'Не заполнены все данные',
            'urls.*.name.required' => 'Название для ссылки пустое',
            'urls.*.url.required' => 'Поле Url пустое',
            'urls.*.url.url' => 'Невалидный Url',
            'urls.*.sort_order.required' => 'Не задан порядок сортировки для ссылок',
            'urls.*.id.required' => 'Не задан ID для URL',
            'urls.*.id.integer' => 'Не числовое значение ID',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return Validator
     */
    public static function createModuleMenuAdvancedValidator($data, array $except = [], array $customErrors = [],
                                                             array $customMessages = []): Validator
    {
        $default = [
            'urls' => 'required|array',
            'urls.*.name' => 'required',
            'urls.*.sort_order' => 'required|numeric',
            'urls.*.url' => 'required|url',
            'urls.*.type' => 'required'
        ];

        $messages = [
            'urls.required' => 'Не заполнены все данные',
            'urls.*.name.required' => 'Название для ссылки пустое',
            'urls.*.url.required' => 'Поле Url пустое',
            'urls.*.url.url' => 'Невалидный Url',
            'urls.*.sort_order.required' => 'Не задан порядок сортировки для ссылок',
            'urls.*.type.required' => 'Не задан тип ссылки (1 - URL, 2 - Anchor)'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleSocialsValidator($data, $except = [], $customErrors = [],
                                                        $customMessages = []): Validator
    {
        $default = [
            'facebook_url' => 'sometimes|url|facebook',
            'vk_url' => 'sometimes|url|vk',
            'twitter_url' => 'sometimes|url|twitter',
            'instagram_url' => 'sometimes|url|instagram',
            'ok_url' => 'sometimes|url|ok'
        ];

        $messages = [
            'facebook_url.url' => 'Неверный facebook URL',
            'vk_url.url' => 'Неверный VK URL',
            'twitter_url.url' => 'Неверный Twitter URL',
            'instagram_url.url' => 'Неверный Instagram URL',
            'instagram_url.instagram' => 'Неверный Instagram URL',
            'ok_url.url' => 'Неверный OK URL'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleCompetitiveAdvantagesValidator($data, $except = [], $customErrors = [],
                                                                      $customMessages = []): Validator
    {
        $default = [];
        $messages = [];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleInformationValidator($data, $except = [],
                                                            $customErrors = [], $customMessages = []): Validator
    {
        if (isset($data['content']) && !is_array($data['content'])) {
            $data['content'] = Utils::htmlDecode($data['content']);
        }

        $max = 70;

        $default = [
            'content' => 'required|max:' . $max
        ];

        $messages = [
            'content.required' => 'Не написана информация',
            'content.max' => 'Количество символов не должно превышать ' . $max
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleArticleValidator($data, $except = [],
                                                        $customErrors = [], $customMessages = [])
    {
        $default = [
            'view' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$view)),
            'sort_by' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$sortBy)),
            'sort_order' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$sortOrder)),
            'block_type' => 'required|in:' . implode(',', ModuleArticle::mapConstants(ModuleArticle::$blockTypes)),
            'name' => 'required',
        ];

        $messages = [
            'view.required' => 'Не задан вид блока',
            'sort_by.required' => 'Не задана сортировка',
            'sort_by.in' => 'Неверная сортировка',
            'sort_order.required' => 'Не задан порядок сортировки',
            'sort_order.in' => 'Неверный порядок сортировки',
            'block_type.required' => 'Не выбран тип вывода статей',
            'block_type.in' => 'Неверный ID типа статей',
            'name.required' => 'Заполните название блока статей',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleSectionValidator($data, $except = [],
                                                        $customErrors = [], $customMessages = [])
    {
        $rules = Utils::defaultSortRules(ModuleSection::class);

        return Utils::makeValidator($data, $rules['messages'], $customMessages, $rules['default'],
            $customErrors, $except);
    }

    public static function createModuleLogoValidator($data, $except = [],
                                                     $customErrors = [], $customMessages = [])
    {
        $default = [
            'name' => 'string',
            'settings' => 'sometimes|array'
        ];

        $messages = [
            'name.string' => 'Неверный формат названия',
            'settings.array' => 'Неверный формат настроек'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleSloganValidator($data, $except = [],
                                                       $customErrors = [], $customMessages = [])
    {
        $default = [
            'name' => 'string',
            'slogan' => 'required'
        ];

        $messages = [
            'name.string' => 'Неверный формат названия',
            'slogan.required' => 'Не задан текст'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleContactsValidator($data, $except = [],
                                                         $customErrors = [], $customMessages = []): Validator
    {
        $default = [
            'phone' => 'array',
            'name' => 'required',
            'address' => 'array'
        ];

        $messages = [
            'phone.array' => 'Не заданы телефоны',
            'name.required' => 'Не задано имя блока',
            'address.array' => 'Не заданы адреса'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleCatalogValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'object_id' => 'required'
        ];

        $messages = [
            'object_id.requied' => 'Не задан обьект каталога'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleCommentValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $rules = Utils::defaultSortRules(ModuleComment::class);

        return Utils::makeValidator($data, $rules['messages'], $customMessages, $rules['defult'],
            $customErrors, $except);
    }

    public static function createModuleFeedbackValidator($data, $except = [], $customErrors = [],
                                                         $customMessages = []): Validator
    {
        $default = [
            'field_group_id' => 'required'
        ];

        $messages = [
            'field_group_id.required' => 'Не задана группа для обратной связи'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createMenuValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'items' => 'required|array',
            'items.*.name' => 'required',
            'items.*.sort_order' => 'required|numeric',
            'items.*.url' => 'required|url',
            'module_id' => 'required|numeric'
        ];

        $messages = [
            'items.required' => 'Не заполнены все данные',
            'items.*.name.required' => 'Название для ссылки пустое',
            'items.*.url.required' => 'Поле Url пустое',
            'items.*.url.url' => 'Невалидный Url',
            'module_id.required' => 'Не задан ID блока',
            'items.*.sort_order.required' => 'Не задан порядок сортировки для ссылок',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createModuleSliderValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'view' => 'required',
            'block_type' => 'required'
        ];

        $messages = [
            'block_type.required' => 'Выберите тип блока'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }
}