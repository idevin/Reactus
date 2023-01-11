<?php

namespace App\Traits\Api\Sites;


use App\Models\FieldGroup;
use App\Models\Modules\ModuleFeedback;
use App\Models\Site;
use App\Traits\Contacts;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait ContactsApi
{
    /**
     * @api {GET} /api/sites/contacts/form Форма для контактов сайта и редактирование
     * @apiGroup Site
     *
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function contactsForm(): JsonResponse|bool|string
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $site->makeHidden(['siteDomain', 'setting']);

        $data = $site->toArray();

        $nodes = FieldGroup::roots()->get();

        $data['options']['module_feedback_select'] = ModuleFeedback::tree($nodes, true, true);

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/sites/contacts/save Сохранение формы контактов
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     */
    public function contactsSave(Request $request): JsonResponse|bool|string
    {
        $data = Contacts::contactsData($request->all());

        unset($data['template_id'], $data['feedback_id']);

        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        if (!empty($data['recaptcha']) && preg_match("/[0-9a-zA-Z_-]{40}/", $data['recaptcha']) == 0) {
            return $this->error('Неверный код Recaptcha');
        }

        if (!empty($data['phone'])) {
            foreach ($data['phone'] as $phone) {
                $valid = preg_match(phoneRegexp(), $phone);
                if (!$valid) {
                    return $this->error('Телефон "' . htmlentities(strip_tags($phone)) . '" неверный');
                }
            }
        }

        $site->update($data);
        $site->makeHidden(['siteDomain', 'setting']);

        return $this->success($site->toArray());
    }
}