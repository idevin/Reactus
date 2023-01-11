<?php

namespace App\Traits;

use App\Models\Feedback as FeedbackModel;
use App\Models\FeedbackLog;
use App\Models\FeedbackLogField;
use App\Models\Field;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait Feedback
{
    public static function tree($nodes, $withRoot = true, $withEmptyValue = false): array
    {
        return Utils::getsubTree($withEmptyValue, $withRoot, $nodes);
    }

    public static function mapFields($fields)
    {
        if (count($fields) > 0) {
            $fields = $fields->map(function ($field) {
                if (!is_array($field->field_type)) {
                    $fieldIndex = $field->field_type;
                } else {
                    $fieldIndex = $field->field_type['id'];
                }
                $field->field_type = Field::$fieldTypes[$fieldIndex];
                return $field;
            });
        }

        return $fields;
    }

    public function feedbackLog($data, $toEmails, $site)
    {
        $user = \Auth::user();

        if ($user) {
            $userId = $user->id;
        } else {
            $user = self::registerFeedbackGuest($data);
            $userId = $user?->id;
        }

        $feedbackLog = FeedbackLog::firstOrCreate([
            'site_id' => $site->id,
            'to_user_id' => $site->user_id,
            'to_emails' => $toEmails,
            'from_user_id' => $userId,
            'from_name' => $data['name'],
            'from_email' => $data['email'],
            'from_phone' => $data['phone']
        ]);

        if (!empty($data['fields'])) {
            foreach ($data['fields'] as $field) {
                FeedbackLogField::create([
                    'feedback_log_id' => $feedbackLog->id,
                    'field_id' => $field['id'],
                    'value' => $field['value']
                ]);
            }
        }

        return $feedbackLog;
    }

    public function registerFeedbackGuest($data): Model|Builder|User|null
    {
        $user = null;
        $siteDomain = env('DOMAIN');

        if (!\Auth::user()) {
            $email = $data['email'] ?? null;

            $timestamp = (int)time();

            $username = 'f' . ($timestamp + rand(1, 1000));

            $lastUser = \DB::connection('mysqlu')->table('user')->latest('id')->first();

            if ($lastUser) {
                $username = 'f' . ($lastUser->id + rand(1, 5));
            }

            $phone = $data['phone'] ?? null;

            if (empty($email) && empty($phone)) {
                return null;
            }

            if (isset($phone) && !empty($phone)) {
                $phone = preg_replace('/[^\+\d]+/', '', $data['phone']);
            }

            $userExists = User::query();
            if ($email) {
                $userExists = $userExists->orWhere('email', $email);
            }
            if ($phone) {
                $userExists = $userExists->orWhere('phone', $phone);
            }

            $userExists = $userExists->orWhere('username', $username)->first();

            if (!$userExists) {
                $site = get_site();
                $language = null;
                $password = generate_code(config('netgamer.registration.password_length'));
                $authToken = User::authToken();

                $personalDomain = Domain::getRandomPersonal();

                $domain = $username . '.' . $personalDomain->name;

                if ($site->siteDomain->language) {
                    $language = $site->siteDomain->language_id;
                } else {
                    $defaultLanguage = Language::whereAlias(config('app.locale'))->first();
                    $language = $defaultLanguage?->id;
                }

                $user = User::firstOrCreate([
                    'username' => $username,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'active' => 1,
                    'phone' => $phone,
                    'domain' => $domain,
                    'language_id' => $language,
                    'auth_token' => $authToken
                ]);

                $roles = Role::whereForRegistered(1)->get();

                if (count($roles) > 0) {
                    foreach ($roles as $role) {
                        $user->roles()->attach($role->id);
                    }
                }

                $data['domain'] = $siteDomain;
                $data['user'] = $user;
                $data['password'] = $password;

                if (!empty($email)) {
                    sendEmail($email, 'Обратная связь', $data, 'register-feedback-success');
                } elseif (!empty($phone)) {

                    $message = "
                    Данные о регистрации:
                    Логин: {$username}
                    Пароль: {$password}
                    {$siteDomain}";

                    $phone = preg_replace('/[^0-9]+/', '', $phone);

                    send_sms($phone, $message);
                }

            } else {
                $user = $userExists;
            }
        }

        return $user;
    }

    public function getFeedbackFields($site): array|null
    {
        $fields = FeedbackModel::sorted()->whereSiteId($site->id)
            ->whereForAllSites(0)
            ->remember(config('app.remember_time'))->get();

        $fieldsArray = [];

        if (count($fields) > 0) {
            foreach ($fields as $index => $field) {
                if ($field->field) {
                    $fieldsArray[$index] = [
                        'id' => $field->id,
                        'name' => $field->field->alias,
                        'type' => Field::$fieldTypes[$field->field->field_type]['type'],
                        'type_fields' => Field::$fieldTypes[$field->field->field_type],
                        'label' => $field->field->name,
                        'defaultValue' => $field->field->default_value,
                        'placeholder' => $field->field->default_value,
                        'required' => $field->field->required
                    ];
                    if ($field->field->field_type == 4) {
                        foreach ($field->field->field_values as $fieldValue) {
                            $fieldsArray[$index]['values'][] = [
                                'value' => $fieldValue->id,
                                'text' => $fieldValue->value
                            ];
                        }

                    }
                }
            }
        } else {
            return null;
        }

        return $fieldsArray;
    }
}