<?php

namespace App\Traits\Api\Sites;


use App\Models\Site;
use App\Traits\Response;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Validator;

trait FeedbackSettingsApi
{
    use Response;

    /**
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/sites/feedback_settings/form Форма сервисов приема данных
     * @apiGroup Site
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function feedbackSettingsForm()
    {
        $site = Site::whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $data = [
            'email' => $site->email
        ];

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/sites/feedback_settings/save Сохранение сервисов приема данных
     * @apiGroup Site
     * @apiParam {string} email E-mail
     */
    public function feedbackSettingsSave(Request $request): JsonResponse|string
    {
        $data = $request->all();
        $result = Utils::siteInstance();

        if (!is_array($result)) {
            return $result;
        }

        $rules = [
            'email' => 'required|email'
        ];

        $messages = [
            'email.required' => 'Напишите e-mail',
            'email.email' => 'Невалидный e-mail'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $result['site']->update([
            'email' => $data['email']
        ]);

        Utils::forgetModuleCache();

        return $this->success();
    }
}