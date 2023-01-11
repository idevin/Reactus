<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Contracts\Streamable;
use App\Http\Controllers\Controller;
use App\Models\FeedbackRecipient;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Modules\ModuleFeedback;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Feedback;
use App\Traits\Media;
use App\Traits\Module;
use Auth;
use Exception;
use finfo;
use Illuminate\Http\JsonResponse;
use Session;
use Symfony\Component\HttpFoundation\Request;
use Validator;

class FeedbackController extends Controller
{
    /**
     * @activity done
     */
    public static $user = null;

    use Module;
    use Media;
    use Feedback;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        Session::forget('site');

        $this->setObject(ModuleFeedback::class);
        $this->setUserActivity();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/v2/feedback/send Отправление обратной связи (v2)
     * @apiGroup Module Feedback
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} field_group_id ID группы полей (для модуля преймуществ, без module_id)
     * @apiParam {array} fields Массив полей в виде: fields: [{alias: "...", name: "...", required: 0|1 }]
     * @apiParam {integer} module_id ID модуля
     *
     */
    public function send(Request $request)
    {
        $moduleId = $request->get('module_id');
        $fieldGroupId = $request->get('field_group_id');
        $site = get_site();

        if (!$site) {
            return $this->error('Сайт не найден');
        }

        $data = $request->all();

        $fromEmail = $data['fields']['email'] ?? null;
        $fromName = $data['fields']['name'] ?? null;
        $fromPhone = $data['fields']['phone'] ?? null;

        if (empty($moduleId) && !empty($fieldGroupId)) {
            $result = $this->processCardFeedback($data, $fieldGroupId);
        } elseif (empty($fieldGroupId) && !empty($moduleId)) {
            $result = $this->processModuleFeedbackSend($data, $moduleId);
        } else {
            $result = $this->processCardFeedback($data, $fieldGroupId);
        }

        if ($result instanceof JsonResponse) {
            return $result;
        }

        if ($result['status'] == false || !empty($result['messages'])) {
            return $this->error($result['messages']);
        }

        $files = [];
        foreach ($result['mailData'] as $i => $data) {
            if (!isset($data["value"]) || !is_array($data['value'])) {
                continue;
            }

            foreach ($data['value'] as $k => $file) {
                if (!is_array($file) || !isset($file['value']) || !isset($file['base64'])) {
                    continue;
                }
                $fileName = upload_base64_file($file['base64'], domain_upload_path());

                if (!$fileName || $fileName instanceof Exception) {
                    continue;
                }

                $stream = new Streamable();
                $stream->setPath($fileName);

                $fInfo = new finfo(FILEINFO_MIME);
                $mime = $fInfo->file($stream->getStreamPath(), FILEINFO_MIME_TYPE,
                    $stream->getContext());

                if (!in_array($mime, config('netgamer.allowed_file_types'))) {
                    continue;
                }

                $files[] = $fileName;
                $data['value'] = $fileName;
            }
            unset($result['mailData'][$i]);
        }

        $allData = [
            'fields' => $result['mailData'],
            'site' => $site,
            'user' => Auth::user(),
            'name' => $fromName,
            'email' => $fromEmail,
            'phone' => $fromPhone
        ];

        if (!empty($data['fields']['email'])) {
            sendEmail($data['fields']['email'], 'Обратная связь', $allData,
                'feedback-user-sent', $files);
        }

        $user = null;
        $adminEmails = [];
        if (!empty($site->user_id)) {
            $user = User::find($site->user_id);
        }

        if ($user && !empty($user->email)) {
            $adminEmails[] = $user->email;
        }

        if (!empty($site->email)) {
            $adminEmails[] = $site->email;
        }

        if (count($site->siteUsers) > 0) {
            foreach ($site->siteUsers as $siteUser) {
                if (!empty($siteUser->email)) {
                    $adminEmails[] = $siteUser->email;
                }
            }
        }

        self::feedbackLog($allData, $adminEmails, $site);

        if (!empty($adminEmails)) {
            $adminEmails = array_merge($adminEmails, FeedbackRecipient::getEmails($site));
            $adminEmails = array_unique($adminEmails);

            foreach ($adminEmails as $i => $adminEmail) {
                if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                    unset($adminEmails[$i]);
                }
            }

            sendEmail($adminEmails, 'Обратная связь', $allData, 'feedback-admin-sent', $files);
        }

        return $this->success();
    }

    protected function processCardFeedback(array $request, $fieldGroupId)
    {
        $obFieldGroup = FieldGroup::whereId($fieldGroupId)->first();

        if (!$obFieldGroup) {
            return $this->error('Группа не найдена');
        }

        if (count($obFieldGroup->fields) == 0) {
            return $this->error('Поля не найдены');
        }

        return $this->getSendValidator($obFieldGroup, $request);
    }

    protected function getSendValidator(FieldGroup $fieldGroup, array $request): array
    {
        $rules = [];
        $messages = [];
        $emailData = [];

        foreach ($fieldGroup->fields as $field) {

            if ((int)$field->required == 1) {
                $rules[$field->alias] = 'required';
                $messages[$field->alias . '.required'] = 'Поле ' . $field->name . ' обязательно для заполнения';
            }

            foreach ($request['fields'] as $alias => $value) {
                if ($alias == $field->alias) {
                    $fieldType = $field->field_type;

                    $value = Field::{"feedbackValue" . $fieldType}($value);

                    $emailData[] = [
                        'name' => $field->name,
                        'value' => $value,
                        'id' => $field->id
                    ];
                }
            }
        }

        $validator = Validator::make($request['fields'], $rules, $messages);

        $result = [
            'status' => false,
            'messages' => [],
            'mailData' => [],
        ];

        if ($validator->fails()) {
            $result['messages'] = $validator->errors();
            return $result;
        }

        $result['status'] = true;
        $result['mailData'] = $emailData;

        return $result;
    }

    protected function processModuleFeedbackSend(array $request, $moduleId)
    {
        $moduleFeedback = ModuleFeedback::find($moduleId);

        if (!$moduleFeedback) {
            return $this->error('Модуль не найден');
        }

        if (!$moduleFeedback->fieldGroup) {
            return $this->error('Группа не найдена');
        }

        if (count($moduleFeedback->fieldGroup->fields) == 0) {
            return $this->error('Поля не найдены');
        }

        return $this->getSendValidator($moduleFeedback->fieldGroup, $request);
    }
}