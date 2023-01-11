<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackLog;
use App\Models\FeedbackRecipient;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\FieldValue;
use App\Models\SiteUser;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Feedback as FeedbackTrait;
use App\Traits\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Validator;

class FeedbackController extends Controller
{
    /**
     * @activity done
     */
    use Site;
    use FeedbackTrait;
    use Activity;

    public static array $emails = [];

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Feedback::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['log', 'send']);
    }

    /**
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/feedback Получение формы обратной связи
     * @apiGroup Feedback
     *
     *
     * @internal param \Request $request
     * @internal param Request $request
     */
    public function index(): bool|JsonResponse|string|JSON
    {
        $site = $this->getSite(env('DOMAIN'));

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $fieldsArray = $this->getFeedbackFields($site);

        $data = [
            'fields' => $fieldsArray
        ];

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {GET} /api/feedback/fields Обратная связь по ID
     * @apiGroup Feedback
     *
     * @apiParam {string} feedback_id ID обратной связи
     *
     */
    public function fields(Request $request): bool|JsonResponse|string|JSON
    {
        $site = $this->getSite(env('DOMAIN'));
        $id = $request->get('feedback_id');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $fieldGroup = FieldGroup::query()->find($id);

        if (!$fieldGroup) {
            return $this->error('Не найдена обратная связь');
        }

        $fieldGroup->makeHidden(['fieldGroup']);

        $fields = self::mapFields($fieldGroup->fields);

        $fieldGroup->fields = $fields;

        return $this->success($fieldGroup);
    }

    /**
     * @api {POST} /api/feedback/log Лог обратной связи
     * @apiGroup Feedback
     * @internal param \Request $request
     * @internal param Request $request
     */
    public function log(): JsonResponse|bool|string
    {
        $user = Auth::user();
        $site = get_site();

        if ($user->id == $site->iser_id) {
            $siteUser = $user;
        } else {
            $siteUser = SiteUser::whereUserId($user->id)->whereSiteId($site->id)->first();
        }

        if (!$siteUser) {
            return $this->error('Вы не можете просматривать историю');
        }

        $feedbackLog = FeedbackLog::with(['fields'])->whereSiteId($site->id)->paginate(10);

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success($feedbackLog);
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/feedback/send Отправка обратной связи
     * @apiGroup Feedback
     * @apiParam {string} name ФИО
     * @apiParam {string} email Email пользователя
     * @apiParam {string} phone телефон
     * @apiParam {string} message сообщение
     */
    public function send(Request $request): JsonResponse|bool|string
    {
        $site = $this->getSite(env('DOMAIN'));
        $inputData = $request->all();

        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        if (Auth::user()) {
            $inputData['phone'] = Auth::user()->phone;
            $inputData['email'] = Auth::user()->email;
        }

        $feedbackFields = Feedback::whereSiteId($site->id)->get();
        $validateFields = [];
        $messageFields = [];
        $readyFields = [];

        if (!empty($feedbackFields)) {
            foreach ($feedbackFields as $field) {
                if ($field->field->required == 1) {
                    $validateFields[$field->field->alias] = 'required';
                    $messageFields[$field->field->alias . '.required'] =
                        $field->field->name . ' обязательно для заполнения.';
                }

                foreach ($inputData as $key => $value) {
                    if ($key == $field->field->alias) {
                        $field->field->value = $value;
                        $readyFields[] = $field;
                    }
                }
            }
        }

        $validator = $this->createValidator($inputData, $validateFields, $messageFields);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        } else {

            $clientMessage = $inputData['message'];
            $clientName = $inputData['name'];
            $clientEmail = $inputData['email'] ?? null;
            $clientPhone = $inputData['phone'] ?? null;

            if ($site->email) {
                static::$emails[] = $site->email;
            }

            if (count($site->users) > 0) {

                $site->users->map(function ($user) {

                    if ($user->user->email) {
                        static::$emails[] = $user->user->email;
                    }

                    return null;
                });
            }

            foreach ($readyFields as $field) {

                switch ($field->field->field_type) {
                    case Field::FIELD_TYPE_SELECT:
                        $fieldValue = FieldValue::find($field->field->value);
                        $field->field->value = $fieldValue->value;
                        break;
                    case Field::FIELD_TYPE_CHECKBOX:
                        if ($field->field->value == 1) {
                            $field->field->value = '+';
                        } else {
                            $field->field->value = '-';
                        }
                        break;
                }
            }

            if (!empty(static::$emails)) {

                static::$emails = array_merge(static::$emails, FeedbackRecipient::getEmails($site));

                static::$emails = collect(static::$emails)->filter(function ($email) {
                    return filter_var($email, FILTER_VALIDATE_EMAIL);
                })->unique()->toArray();


                sendEmail(static::$emails, 'Обратная связь с сайта ' . env('DOMAIN'),
                    compact('readyFields', 'clientMessage', 'clientName', 'clientEmail', 'clientPhone'), 'send-feedback');
            } else {
                return $this->error('Не найден email для отправки сообщения...');
            }
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success('Сообщение успешно отправлено!');
    }

    protected function createValidator($data, $requiredFields = [], $requiredMessages = [])
    {
        $default = array_merge([
            'name' => 'required',
            'message' => 'required',
            'email' => 'required_without:phone|email_extended',
            'phone' => 'required_without:email'
        ], $requiredFields);

        $messages = array_merge([
            'message.required' => 'Вы не написали сообщение',
            'email.required' => 'Вы не написали email',
            'email.email' => 'Невалидный email',
            'phone.required' => 'Напишите свой телефон',
            'name.required' => 'Напишите ФИО или имя'
        ], $requiredMessages);

        if (Auth::user()) {
            unset($default['name']);
            unset($messages['name.required']);

            if (!Auth::user()->email) {
                unset($default['email']);
                unset($messages['email.required']);
                unset($messages['email.email']);
            }
        }

        return Validator::make($data, $default, $messages);
    }
}