<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PermissionDoesNotExist;
use App\Helpers\Deployer\Classes\Deployer;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Address;
use App\Models\Article;
use App\Models\Domain;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\FieldUserGroup;
use App\Models\FieldUserValue;
use App\Models\Language;
use App\Models\StorageFile;
use App\Models\User;
use App\Models\UserStatus;
use App\Models\UserStatusEmotion;
use App\Models\UserStorageImage;
use App\Traits\Activity as ActivityTrait;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Traits\User as UserTrait;
use App\Traits\UserSession;
use App\Traits\Utils;
use Cache;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\FoundationAuthAuthenticatesAndRegistersUsers;
use Illuminate\FoundationAuthAuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\FacadesAuth;
use Session;
use Validator;

class ProfileController extends Controller
{
    const EMAIL_CODE = 1;
    const PASS_CODE = 2;
    const PHONE_CODE = 3;

    public static array $codeTypes = [
        self::EMAIL_CODE => 'Email',
        self::PASS_CODE => 'Пароля',
        self::PHONE_CODE => 'Телефона'
    ];

    /**
     * @activity done
     */
    use ThrottlesLogins, Site, UserTrait, Utils, ActivityTrait, DomainTrait;
    protected string $username = 'login';

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Field::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['changeDomainNick', 'changeEmail', 'changePassword',
            'changePhone', 'deleteImages', 'save', 'saveField', 'saveImages', 'savePersonalNames',
            'saveStatus', 'setFieldVisibility', 'setGroupVisibility', 'setOnHomepage']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/profile/save_fields Сохранение абстрактных полей
     * @apiGroup Profile
     *
     * @apiParam {integer} field_group_id ID группы полей
     * @apiParam {array} fields[ALIAS][visibility] fields[ALIAS][value] поля для профайла. Где ALIAS - имя поля, visibility(OPTIONAL) for fields[ALIAS][visibility]: 0 - видимо для всех, 1- только для меня
     *
     */
    public function saveFields(Request $request)
    {
        $user = Auth::user();
        $publicUser = $this->publicUser();

        $message = 'Вы не можете обновлять профайл';

        if (!$user) {
            return $this->error('Вы не авторзированы...');
        } else {

            if ($user->id != $publicUser->id && !$user->hasPermissionOther('profile_access')) {
                return $this->error($message);
            }

            if ($user->id == $publicUser->id && !$user->hasPermissionOwn('profile_access')) {
                return $this->error($message);
            }
        }

        $fileLinks = [];

        if ($publicUser) {
            $oldFieldsInput = $fieldsInput = $request->input('fields');

            if (empty($fieldsInput)) {
                return $this->error('Не задан массив');
            }

            $newFieldsInput = [];
            $fieldGroupId = current($fieldsInput)['field_group_id'];

            foreach ($fieldsInput as $index => $field) {

                $newFieldsInput[$field['alias']] = [
                    'visibility' => $field['visibility'],
                    'value' => $field['value']
                ];
            }

            $fieldsInput = $newFieldsInput;

            $files = $request->files;

            foreach ($files as $fileArray) {
                foreach ($fileArray as $fieldAlias => $file) {
                    $oFile = $file['value'];
                    if ($oFile->isValid() && $oFile->getError() == 0) {
                        $hash = generate_code(16, true);
                        $extension = strtolower($oFile->getClientOriginalExtension());

                        $newFilename = $hash . '.' . $extension;

                        $path = '/uploads/storage/files/' . $hash[0] . $hash[1] . '/' .
                            $hash[2] . $hash[3] . '/' . $hash[4] . '/' . $extension . '/';
                        $filename = pathinfo($oFile->getClientOriginalName())['filename'];

                        $data = [
                            'user_id' => $publicUser->id,
                            'filename' => $filename,
                            'type' => $oFile->getMimeType(),
                            'size' => $oFile->getClientSize(),
                            'hash' => $hash,
                            'extension' => $extension,
                            'url' => $path,
                            'path' => getenv('DOCUMENT_ROOT') . '/' . $path . '/' . $newFilename
                        ];

                        $newFile = StorageFile::create($data);
                        $url = route('storage.download', ['id' => $newFile->id]);

                        $oFile->move(getenv('DOCUMENT_ROOT') . '/' . $path, $newFilename);

                        $fileLinks[] = [
                            'field_name' => $fieldAlias,
                            'url' => $url,
                            'name' => $filename
                        ];
                        $fieldsInput[$fieldAlias] = ['value' => $url];
                    }
                }
            }

            $validationFields = [];
            $validationInputs = [];
            $validationErrorMessages = [];

            foreach ($fieldsInput as $field => $value) {
                $oField = Field::whereAlias($field)->get()->first();

                if ($oField && $oField->required == 1) {

                    $validationFields[$field] = 'required';
                    $validationInputs[$field] = $value['value'];

                    $validationErrorMessages[$field . '.required'] = 'Поле "' . $oField->name . '"' . ' обязательно для заполнения';
                }
            }

            $validator = Validator::make($validationInputs, $validationFields, $validationErrorMessages);

            $errorMessages = $validator->errors()->getMessageBag()->getMessages();

            if (empty($errorMessages)) {
                $fieldGroup = FieldGroup::find($fieldGroupId);

                $fieldUserGroup = FieldUserGroup::whereFieldGroupId($fieldGroupId)
                    ->whereUserId($publicUser->id)->first();

                if (empty($fieldUserGroup) ||
                    ($fieldGroup && (int)$fieldGroup->multi_field == 1)) {

                    $fieldUserGroup = FieldUserGroup::firstOrCreate([
                        'user_id' => $publicUser->id,
                        'field_group_id' => $fieldGroupId
                    ]);
                }

                $fieldUserGroupId = $fieldUserGroup->id;
                $site = $this->getSite(main_domain(env('DOMAIN')));

                $fieldExists = function () use ($publicUser, $site) {
                    $fieldsData = FieldUserValue::where([
                        'field_user_value.user_id' => $publicUser->id,
                        'field_user_value.site_id' => $site->id])
                        ->select('field.alias')
                        ->join('field', 'field.id', '=', 'field_user_value.field_id')
                        ->get()->toArray();

                    $fields = array_map(function ($field) {
                        return $field['alias'];
                    }, $fieldsData);

                    return array_values($fields);
                };

                foreach ($fieldsInput as $alias => &$field) {
                    $oField = Field::whereAlias($alias)->first();

                    if (in_array($alias, $fieldExists()) && $fieldGroup->multi_field == 0) {

                        $fieldUserValue = FieldUserValue::whereUserId($publicUser->id)
                            ->whereFieldId($oField->id)
                            ->whereSiteId($site->id)->first();

                        if ($fieldUserValue) {
                            $fieldData = [
                                'value' => $field['value']
                            ];

                            if (isset($field['visibility'])) {
                                $fieldData['visibility'] = $field['visibility'];
                            }

                            $fieldUserValue->update($fieldData);
                        }

                    } else {
                        if ($oField) {
                            FieldUserValue::firstOrCreate([
                                'user_id' => $publicUser->id,
                                'field_user_group_id' => $fieldUserGroupId,
                                'value' => $field['value'],
                                'visibility' => isset($field['visibility']) ?
                                    (int)$field['visibility'] : FieldUserValue::VISIBILITY_ME,
                                'field_id' => $oField->id,
                                'site_id' => $site->id
                            ]);
                        } else {
                            return $this->error('Не возможно сохранить данные');
                        }
                    }

                    $field['name'] = $oField->name;
                }

                $this->setIsSystem(false);
                $this->setParams($fieldsInput);
                $this->createActivity();

            } else {
                return $this->error($errorMessages);
            }

        } else {
            return $this->error('Вы не авторизорваны...');
        }

        return $this->success($oldFieldsInput, 'Данные успешно сохранены!');
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @api {POST} /api/profile/save_field Сохранение поля
     * @apiGroup Profile
     *
     */
    public function saveField(Request $request)
    {
        $data = $request->all();
        $publicUser = $this->publicUser();
        $site = $this->getSite(main_domain(env('DOMAIN')));
        $field = Field::find($data['id']);

        if (!$field) {
            return $this->error('Поле не найдено');
        }

        $except = [];

        if ($field->field_type == Field::FIELD_TYPE_IMAGE && empty($data['data'])) {
            $except = ['data.value'];
        }

        $validator = self::createSaveFieldValidator($data, $except);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $fieldGroup = FieldGroup::find($data['field_group_id']);

        if (!$fieldGroup) {
            return $this->error('Группа полей не найдена');
        }

        $fieldUserGroup = FieldUserGroup::firstOrCreate([
            'user_id' => $publicUser->id,
            'field_group_id' => $fieldGroup->id
        ]);

        $fieldUserValueData = [
            'user_id' => $publicUser->id,
            'field_user_group_id' => $fieldUserGroup->id,
            'site_id' => $site->id,
            'value' => !empty($data['data']) ? $data['data']['value'] : null,
            'field_id' => $field->id
        ];

        if ($field->field_type == Field::FIELD_TYPE_IMAGE) {

            $fieldUserValue = FieldUserValue::whereFieldUserGroupId($fieldUserGroup->id)
                ->whereFieldId($field->id)->whereSiteId($site->id)
                ->whereUserId($publicUser->id);

            $fieldUserValue->delete();

            if (!empty($data['data'])) {
                foreach ($data['data']['value'] as $index => $image) {
                    $fieldUserValueData['value'] = $image['id'];
                    FieldUserValue::firstOrCreate($fieldUserValueData);
                }
            }
        } else {

            $fieldUserValue = FieldUserValue::whereFieldUserGroupId($fieldUserGroup->id)
                ->whereFieldId($field->id)->whereSiteId($site->id)
                ->whereUserId($publicUser->id)->first();


            if (!$fieldUserValue) {
                $fieldUserValue = FieldUserValue::firstOrCreate($fieldUserValueData);
            } else {
                $fieldUserValue->update($fieldUserValueData);
            }
        }

        $this->setIsSystem(false);
        $this->setParams($fieldUserValue->toArray());
        $this->createActivity();

        return $this->success($fieldUserValue);
    }

    public static function createSaveFieldValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'id' => 'required|integer',
            'field_group_id' => 'required|integer',
            'data.value' => 'required'
        ];

        $messages = [
            'field_id.required' => 'ID поля обязательно для заполнения',
            'field_group_id.required' => 'ID группы обязательно для заполнения',
            'data.value.required' => 'Поле не может быть пустое'
        ];

        $messagesMerged = array_merge($messages, $customMessages);

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return Validator::make($data, $rules, $messagesMerged);
    }

    /**
     * @param Request $request
     * @return array
     * @throws PermissionDoesNotExist
     * @api {POST} /api/profile/save Сохранение профайла
     * @apiGroup Profile
     *
     * @apiParam {string} first_name Имя
     * @apiParam {string} last_name Фамилия
     * @apiParam {string} middle_name Отчество
     * @apiParam {string} birthday Дата рождения (format: yyyy-mm-dd hh:mm:ss)
     * @apiParam {integer} native_city_id ID города рождения
     * @apiParam {integer} marital_status_id ID семейного положения
     * @apiParam {string} phone_work телефон рабочий
     * @apiParam {string} phone_home телефон домашний
     * @apiParam {integer} sex пол (0-male, 1-female)
     * @apiparam {string} address адрес
     *
     */
    public function save(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->error('Вы не авторизированы...');
        }

        if ($user && !$user->hasPermissionTo('profile_access')) {
            return $this->error('Вы не можете обновлять профайл');
        }

        $data = $request->all();

        unset($data['native_city']);

        $validator = Validator::make($data, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'required|string',
            'birthday' => 'required',
            'sex' => 'required',
            'native_city_id' => 'required'
        ], [
            'first_name.required' => 'Имя обязательно для заполнения',
            'last_name.required' => 'Поле фамилия не заполнено',
            'middle_name.required' => 'Напишите отчество',
            'birthday.required' => 'Выберите дату рождения',
            'sex.required' => 'Выберите пол',
            'native_city_id.required' => 'Выберите место рождения'
        ]);

        if (!$validator->fails()) {
            $data['birthday'] = date('Y-m-d H:i:s', strtotime($data['birthday']));

            if ($user && !$user->can('profile_birthday_edit', $user)) {
                unset($data['birthday']);

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars(username(Auth::user()) . ': Нет прав для редактирования даты рождения');
                }
            }

            if ($user && !$user->can('profile_name_edit', $user)) {
                unset($data['first_name'], $data['last_name'], $data['middle_name']);

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars(username(Auth::user()) . ': Нет прав для ФИО');
                }
            }

            if (!empty($data['address'])) {
                $aAddress = [
                    'name' => $data['address']
                ];

                if ($user->address) {
                    $user->address()->update($aAddress);
                }

                $address = Address::firstOrCreate($aAddress);

                $data['address_id'] = $address->id;
            }

            $user->update($data);

            $this->setIsSystem(false);
            $this->setParams($user->toArray());
            $this->createActivity();

        } else {

            $errorMessages = $validator->errors()->getMessageBag()->getMessages();
            return $this->error($errorMessages);
        }

        return $this->success(['user' => $user]);
    }

    /**
     * @param Request $request
     * @return array|false|JsonResponse|string
     * @api {GET} /api/profile/activity Листинг активности пользователя
     * @apiGroup Profile
     * @apiParam {string} token Токен пользователя
     * @apiParam {array} dates Массив из дат
     * @apiParam {integer} limit Кол-во записей на страницу
     * @apiParam {integer} page Номер страницы
     * @apiParam {string} sortby_field Сортировка по полю
     * @apiParam {string} sortby_order Направление сортировки (asc, desc)
     * @apiParam {array} filter_countries Массив из стран (из обьекта country_options)
     * @apiParam {array} filter_devices Массив из девайсов (из обьекта device_options)
     * @apiParam {array} filter_browsers Массив из браузеров (из обьекта browser_options)
     * @apiParam {array} filter_oc Массив из оп. систем (из обьекта oc_options)
     */
    public function activity(Request $request)
    {
        $user = $this->publicUser();

        if (!$user) {
            return $this->error('Пользователь не найден');
        }

        if (\Auth::user()->id != $user->id) {
            return $this->error('Неверный token');
        }

        $defaultOrder = 'desc';
        $defaultField = 'created_at';
        $defaultDates = "[]";

        $browsers = Activity::browsers($user->id);
        $devices = Activity::devices($user->id);
        $ocs = Activity::oc($user->id);
        $countries = Activity::countries($user->id);

        $defaultDevices = "[]";
        $defaultBrowsers = "[]";
        $defaultOcs = "[]";
        $defaultCountries = "[]";

        $sortByField = $request->get('sortby_field', $defaultField);
        $sortByOrder = $request->get('sortby_order', $defaultOrder);

        $filterDevices = $request->get('filter_devices', $defaultDevices);
        $filterBrowsers = $request->get('filter_browsers', $defaultBrowsers);
        $filterOcs = $request->get('filter_oc', $defaultOcs);
        $filterCountries = $request->get('filter_countries', $defaultCountries);

        $limit = $request->get('limit', Activity::DEFAULT_LIMIT);
        $page = $request->get('page');
        $dates = $request->get('dates', $defaultDates);

        if (!in_array($sortByOrder, Activity::SORTBY_ORDER)) {
            $sortByOrder = $defaultOrder;
        }

        if (!in_array($sortByField, array_keys(Activity::SORT_OPTIONS))) {
            $sortByField = $defaultField;
        }

        $dateTo = null;
        $dateFrom = null;
        $dates = json_decode($dates);

        if (is_array($dates) && count($dates) == 2) {
            try {
                $dateFrom = new Carbon($dates[0]);
            } catch (Exception $e) {
                $dateFrom = null;
            }

            try {
                $dateTo = new Carbon($dates[1]);
            } catch (Exception $e) {
                $dateTo = null;
            }
        }

        if ($dateFrom && $dateTo) {
            $dates = [
                $dateFrom, $dateTo
            ];
        } else {
            $dates = [];
        }

        $filterDevices = UserSession::filterParams($devices, $defaultDevices, $filterDevices);
        $filterBrowsers = UserSession::filterParams($browsers, $defaultBrowsers, $filterBrowsers);
        $filterOcs = UserSession::filterParams($ocs, $defaultOcs, $filterOcs);
        $filterCountries = UserSession::filterParams($countries,
            $defaultCountries, $filterCountries);

        $activity = Activity::whereUserId($user->id)->personal()->orderBy($sortByField, $sortByOrder);

        if (!empty($dates)) {
            $activity = $activity->whereBetween('created_at', $dates);
        }

        if (!empty($filterDevices)) {
            $activity = $activity->whereIn('device_string', $filterDevices);
        }

        if (!empty($filterBrowsers)) {
            $activity = $activity->whereIn('browser_string', $filterBrowsers);
        }

        if (!empty($filterOcs)) {
            $activity = $activity->whereIn('oc', $filterOcs);
        }

        if (!empty($filterCountries)) {
            $activity = $activity->whereIn('country_string', $filterCountries);
        }

        $activity = $activity->orderBy($sortByField, $sortByOrder);
        $activity = $activity->paginate((int)$limit, ['*'], 'page');

        $activity = Utils::transformUrl($activity);

        $activity->appends([
            'sortby_field' => $sortByField,
            'sortby_order' => $sortByOrder,
            'limit' => $limit,
            'page' => $page,
            'dates' => $dates,
            'filter_devices' => $filterDevices,
            'filter_countries' => $filterCountries,
            'filter_oc' => $filterOcs,
            'filter_browsers' => $filterBrowsers
        ]);

        $activity = $activity->toArray();

        $grouped = [];
        foreach ($activity['data'] as $i => &$item) {
            unset($item['params'], $item['env'], $item['server'], $item['login'],
                $item['request']);

            if ($item['title_translated']) {
                $item['title'] = $item['title_translated'];
            }
            $grouped[$item['date_only']][] = $item;
        }

        $activity['data'] = $grouped;

        return $this->success([
            'activity' => $activity,
            'sort_options' => Activity::SORT_OPTIONS,
            'browser_options' => $browsers,
            'device_options' => $devices,
            'country_options' => $countries,
            'oc_options' => $ocs
        ]);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/profile/info Информация о пользователе
     * @apiGroup Profile
     * @apiParam {string} token Токен пользователя
     */
    public function info()
    {
        $user = $this->publicUser(false);

        if (!$user) {
            return $this->error('Пользователь не найден');
        }

        $status = null;
        $userStatus = UserStatus::whereId($user->user_status_id)->first();

        if ($userStatus) {
            $status = $userStatus->status;
        }

        $fieldGroups = FieldGroup::homepage($user);

        $avatar = null;

        if (!empty($user->thumbs)) {
            $avatar = [
                'id' => $user->thumbs['id'],
                'title' => $user->thumbs['title'],
                'description' => $user->thumbs['description'],
                'url' => $user->thumbs['url'] ?? null,
                'url_miniature' => $user->thumbs['thumb150x150'],
                'orginal' => $user->thumbs['original']
            ];
        }

        $background = null;

        if (!empty($user->background) && $user->background['id']) {
            $background = [
                'id' => $user->background['id'],
                'title' => $user->background['title'],
                'description' => $user->background['description'],
                'url' => $user->background['url'],
                'url_miniature' => $user->background['thumbs']['thumb1920x1080'],
                'orginal' => $user->background['thumbs']['original']
            ];
        }

        $personalDomains = Domain::personal()->active()->whereHideFromRegistration(0)
            ->orderBy('name', 'asc')->get(['id', 'name']);

        $languages = Language::query()->orderBy('id', 'desc')->get();

        $data['user'] = [
            'id' => $user->id,
            'domain' => $user->domain,
            'username' => username($user),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'status' => $status,
            'rating' => $user->rating,
            'articles_count' => $user->articles->count(),
            'comments_count' => $user->comments->count(),
            'subscribers_count' => 0,
            'rewards_count' => 0,
            'avatar' => $avatar,
            'background' => $background,
            'field_types' => Field::$fieldTypes,
            'field_groups' => $fieldGroups,
            'personal_domains' => $personalDomains,
            'last_password_update' => $user->pass_update_formated,
            'phone_hidden' => $user->phone_hidden,
            'email_hidden' => $user->email_hidden,
            'language' => $user->language
        ];

        $data['languages'] = $languages;

        $data['referer'] = getenv('HTTP_REFERER');

        return $this->success($data);
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/profile/fields Поля для профиля
     * @apiGroup Profile
     * @apiParam {string} token Токен пользователя
     */
    public function fields(): JsonResponse
    {
        $user = $this->publicUser();
        $fieldGroups = FieldGroup::with(['fields'])->get()->toHierarchy();

        Field::$user = $user;

        return $this->success([
            'field_groups' => array_values($fieldGroups->toArray()),
            'field_types' => Field::$fieldTypes
        ]);
    }

    /**
     * @return false|JsonResponse|string
     * @api {GET} /api/profile/images Картинки для слайдера в профайле
     * @apiGroup Profile
     * @apiParam {string} token Токен пользователя
     */
    public function images()
    {
        $user = $this->publicUser();

        if (!$user) {
            return $this->error('Пользователь не найден');
        }

        $images = UserStorageImage::whereUserId($user->id)->with(['storageFile'])
            ->where('type', UserStorageImage::SLIDE)->get()->map(function ($image) {
                if ($image->storageFile) {
                    return [
                        'id' => $image->storageFile->id,
                        'title' => $image->storageFile->title,
                        'description' => $image->storageFile->description,
                        'url' => $image->storageFile->url . DS . $image->storageFile->filename,
                        'url_miniature' => $image->storageFile->thumbs['thumb1920x1080'],
                        'orginal' => $image->storageFile->thumbs['original']
                    ];
                }
                return null;
            });

        return $this->success(array_filter($images->toArray()));
    }


    /**
     * @param Request $request
     * @return array|false|JsonResponse|string
     * @api {POST} /api/profile/set_field_visibility Сохранение видимости поля
     * @apiGroup Profile
     * @apiParam {integer} id ID поля
     * @apiParam {integer} field_group_id ID группы полей
     * @apiParam {boolean} visibility Видимость: 0- видимо для всех, 1- только для меня
     */
    public function setFieldVisibility(Request $request)
    {
        $user = $this->publicUser();
        $site = $this->getSite(main_domain(env('DOMAIN')));

        $data = $request->all();

        if (empty($data['id'])) {
            return $this->error('ID поля не найдено');
        }

        if (empty($data['field_group_id'])) {
            return $this->error('ID группы полей не найдено');
        }

        if (!isset($data['visibility'])) {
            return $this->error('не задана видимость');
        }

        $field = Field::find($data['id']);

        if (!$field) {
            return $this->error('Поле не найдено');
        }

        if ($user) {

            $fieldUserGroup = FieldUserGroup::whereFieldGroupId($data['field_group_id'])
                ->first();

            if (!$fieldUserGroup) {
                $fieldUserGroup = FieldUserGroup::firstOrCreate([
                    'field_group_id' => $data['field_group_id'],
                    'user_id' => $user->id,
                    'visibility' => config('netgamer.default_group_visibility')
                ]);
            }

            $fieldUserValue = FieldUserValue::whereFieldId($data['id'])
                ->whereUserId($user->id)
                ->whereFieldUserGroupId($fieldUserGroup->id)->first();

            if (!empty($fieldUserValue)) {
                $fieldUserValue->update([
                    'visibility' => (int)$data['visibility']
                ]);

            } else {
                FieldUserValue::firstOrCreate([
                    'user_id' => $user->id,
                    'field_user_group_id' => $fieldUserGroup->id,
                    'field_id' => (int)$data['id'],
                    'visibility' => (int)$data['visibility'],
                    'site_id' => $site->id
                ]);
            }

            $this->setIsSystem(false);
            $this->setParams($fieldUserValue->toArray());
            $this->createActivity();

        } else {
            return $this->error('Вы не авторизированы');
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return array
     * @api {POST} /api/profile/set_group_visibility Сохранение видимости группы полей
     * @apiGroup Profile
     *
     * @apiParam {integer} field_group_id ID of field group for fields
     * @apiParam {boolean} visibility Visibiity of form group for user may accept: 0- visible for all, 1- visible for
     * me, 2- visible for nobody
     *
     * @internal param bool $forGroup
     */
    public function setGroupVisibility(Request $request)
    {
        $user = Auth::user();
        $success = false;

        $fieldGroupId = $request->input('field_group_id', -1);
        $visibility = (int)$request->input('visibility', null);
        $userGroup = (boolean)$request->input('user_group', false);

        if ($user) {
            $data = [
                'field_group_id' => $fieldGroupId,
                'user_id' => $user->id
            ];

            if ($fieldGroupId == -1 && $userGroup == true) {
                $user->update(['visibility' => $visibility]);
            }

            $fieldUserGroup = FieldUserGroup::where($data)->get()->first();

            $existentData = null;

            if ($fieldUserGroup) {
                $existentData = $fieldUserGroup->toArray();
            }

            if (!empty($existentData)) {
                if (isset($visibility)) {
                    $existentData['visibility'] = $visibility;
                }

                $fieldUserGroup->update($existentData);
                $fieldUserGroup = $existentData;
            } else {
                if (isset($visibility)) {
                    $data['visibility'] = $visibility;
                }
                $fieldUserGroup = FieldUserGroup::create($data)->toArray();
            }

            $success = true;

        } else {
            $fieldUserGroup = null;
        }

        $this->setIsSystem(false);
        $this->setParams($fieldUserGroup);
        $this->createActivity();

        return [
            'success' => $success,
            'field_group_id' => $fieldGroupId,
            'visibility' => config('netgamer.group_visibility')[$visibility],
            'field_user_group' => $fieldUserGroup
        ];
    }

    /**
     * @param Request $request
     * @return array
     * @api {POST} /api/profile/save_personal_names Сохранение ФИО
     * @apiGroup Profile
     * @apiParam {string} first_name first name
     * @apiParam {string} last_name last name
     * @apiParam {string} username user name
     */
    public function savePersonalNames(Request $request)
    {
        $user = Auth::user();
        $success = false;

        if ($user && !$user->can('profile_name_edit', $user)) {
            return $this->error('Вы не можете изменять ФИО');
        }

        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $username = $request->input('username');

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:mysqlu.user,username,' . $user->id
        ], [
            'first_name.required' => 'Заполните поле Имя',
            'last_name.required' => 'Не заполнено поле фамилия',
            'username.required' => 'Придумайте Никнейм',
            'username.unique' => 'Такой никнейм уже существует'
        ]);

        $errorMessages = $validator->errors()->getMessageBag()->getMessages();

        if (empty($errorMessages)) {

            $user->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username
            ]);

            $success = true;
        }

        $this->setIsSystem(false);
        $this->setParams($user->toArray());
        $this->createActivity();

        return $this->success(['success' => $success, 'errors' => $errorMessages]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws PermissionDoesNotExist
     * @api {POST} /api/profile/change_password Изменение пароля
     * @apiGroup Profile
     * @apiParam {string} password_old old password
     * @apiParam {string} password_new last new password
     * @apiParam {string} password_new_confirm new password confirm
     * @apiParam {string} code код подтверждения
     */
    public function changePassword(Request $request)
    {
        $currentUser = Auth::user();
        $publicUser = $this->publicUser();
        $message = 'Пароль изменен';

        $passwordOld = $request->input('password_old');
        $passwordNew = $request->input('password_new_confirm');

        $code = $request->input('code');

        $errorMessages = $this->getPasswordValidator($request, $currentUser, $publicUser, $passwordOld);

        if (!empty($errorMessages)) {
            return $this->error($errorMessages);
        } else {

            $codeResult = self::getCodeFromCache($currentUser, $code, self::PASS_CODE);

            if ($codeResult[0] == true) {
                return $this->error('Неверный код');
            }

            $currentUser->forceFill([
                'password' => Hash::make($passwordNew)
            ]);

            $currentUser->save();

            Cache::forget($codeResult[1]);

            if (!empty($currentUser->email)) {
                sendEmail($currentUser->email, $message, [], 'confirm-change-password', [],
                    env('DEFAULT_DOMAIN'));

            } elseif (!empty($currentUser->phone)) {
                $phone = preg_replace('#[^0-9]#', '', $currentUser->phone);
                send_sms($phone, $message . "\n\n" . 'Reactus');
            }
        }

        $this->setIsSystem(false);
        $this->setParams($currentUser->toArray());
        $this->createActivity();

        return $this->success(['message' => $message]);
    }

    public function getPasswordValidator($request, $currentUser, $publicUser, $passwordOld, $except = [])
    {
        $requestData = $request->all();

        if (!$publicUser || !$currentUser) {
            return $this->error('Пользователь не найден');
        }

        if ($currentUser->id !== $publicUser->id) {
            return $this->error('Несовпадение пользователей');
        }

        if (!$currentUser->hasPermissionOwn('profile_access')) {
            return $this->error('У вас нет прав для доступа к профилю');
        }

        $rules = [
            'code' => 'required',
            'password_old' => 'required',
            'password_new' => 'min:' . config('auth.password_length') . '|required',
            'password_new_confirm' => 'min:' . config('auth.password_length') . '|required|same:password_new'
        ];

        if (!empty($except)) {
            $rules = collect($rules)->except($except)->toArray();
        }

        $validator = Validator::make($requestData, $rules, [
            'code.required' => 'Введите код подтверждения',
            'password_old.required' => 'Введите старый пароль',
            'password_new.required' => 'Новый пароль не заполнен',
            'password_new_confirm.required' => 'Повторите новый пароль',
            'password_new.min' => 'Новый пароль должен быть не менее ' . config('auth.password_length') . ' символов'
        ]);

        $matched = Hash::check($passwordOld, $currentUser->password);

        if (!$matched) {
            $validator->errors()->add('password_old', 'Неверный старый пароль');
        }

        return $validator->errors()->getMessageBag()->getMessages();
    }

    /**
     * @param $currentUser
     * @param $code
     * @param $type
     * @return array
     */
    public static function getCodeFromCache($currentUser, $code, $type)
    {
        $cacheKey = 'change_' . $currentUser->id;
        $codeNotFound = false;

        if (Cache::has($cacheKey)) {
            $codeArray = Cache::get($cacheKey);
            if ((int)$codeArray['codeType'] != $type) {
                $codeNotFound = true;
            }
            if ($codeArray['code'] != $code) {
                $codeNotFound = true;
            }
        } else {
            $codeNotFound = true;
        }

        return [$codeNotFound, $cacheKey];
    }

    /**
     * @param Request $request
     * @return array
     * @throws PermissionDoesNotExist
     * @api {POST} /api/profile/get_change_code Получение кода
     * @apiGroup Profile
     * @apiParam {string} code_type тип кода (1 - email, 2 - пароль, 3 - телефон)
     */
    public function getChangeCode(Request $request)
    {
        $codeTypes = self::$codeTypes;
        $codeType = $request->input('code_type');

        if (empty($codeType) || !in_array($codeType, array_keys($codeTypes))) {
            return $this->error('Не задан тип кода, либо тип кода неверный');
        }

        $sendToEmail = function ($codeTypes, $codeType, $currentUser, $message, $code) {
            sendEmail($currentUser->email, 'Изменение ' . $codeTypes[$codeType],
                compact('code', 'codeType', 'codeTypes'),
                'send-security-profile-code', [], env('DEFAULT_DOMAIN'));

            $message .= 'e-mail';

            return $message;
        };

        $sendToPhone = function ($phoneNew, $message, $code) {
            send_sms($phoneNew, $code);
            $message .= 'телефон';
            return $message;
        };

        $currentUser = Auth::user();
        $publicUser = $this->publicUser();

        $code = generate_code(config('netgamer.registration.password_length'), true);
        $message = 'Код отправлен на ';

        if ((int)$codeType == static::EMAIL_CODE) {
            $emailOld = $request->input('email_old');
            $emailNew = $request->input('email_new');

            $errorMessages = $this->getEmailValidator($request, $currentUser, $publicUser,
                $emailOld, $emailNew, ['code']);

            if (!empty($errorMessages)) {
                return $this->error($errorMessages);
            }

            $message = $sendToEmail($codeTypes, $codeType, $currentUser, $message, $code);

        } elseif ((int)$codeType == static::PASS_CODE) {
            $passwordOld = $request->input('password_old');

            $errorMessages = $this->getPasswordValidator($request, $currentUser, $publicUser, $passwordOld, ['code']);

            if (!empty($errorMessages)) {
                return $this->error($errorMessages);
            }

            if (!empty($currentUser->email)) {
                $message = $sendToEmail($codeTypes, $codeType, $currentUser, $message, $code);
            } elseif (!empty($currentUser->phone)) {
                $message = $sendToPhone($currentUser->phone, $message, $code);
            }
        } elseif ((int)$codeType == static::PHONE_CODE) {
            $phoneOld = $request->input('phone_old');
            $phoneNew = $request->input('phone_new');

            $errorMessages = $this->getPhoneValidator($request, $currentUser, $publicUser,
                $phoneOld, $phoneNew, ['code']);

            if (!empty($errorMessages)) {
                return $this->error($errorMessages);
            }

            $message = $sendToPhone($phoneNew, $message, $code);
        }

        $cacheKey = 'change_' . $currentUser->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }

        remember($cacheKey, function () use ($code, $codeType) {
            return compact('code', 'codeType');
        }, 600); //TTL: 10 min

        $this->setIsSystem(false);
        $this->setParams($currentUser->toArray());
        $this->createActivity();

        return $this->success($message);
    }

    /**
     * @param $request
     * @param $currentUser
     * @param $publicUser
     * @param $emailOld
     * @param $emailNew
     * @return array|false|JsonResponse|string
     */
    public function getEmailValidator($request, $currentUser, $publicUser, $emailOld, $emailNew, $except = [])
    {
        if (!$publicUser || !$currentUser) {
            return $this->error('Пользователь не найден');
        }

        if ($currentUser->id !== $publicUser->id) {
            return $this->error('Несовпадение пользователей');
        }

        if (!$currentUser->hasPermissionOwn('profile_access')) {
            return $this->error('У вас нет прав для доступа к профилю');
        }

        if (!$currentUser->can('profile_email_edit', $currentUser)) {
            return $this->error('Вы не можете изменять Email');
        }

        $rules = [
            'email_old' => 'required|email',
            'email_new' => 'required|email',
            'code' => 'required'
        ];

        if (!empty($except)) {
            $rules = collect($rules)->except($except)->toArray();
        }

        $validator = Validator::make($request->all(), $rules, [
            'email_old.required' => 'Введите текущий E-mail',
            'email_old.email' => 'Невалидный старый Email',
            'email_new.email' => 'Невалидный новый Email',
            'email_new.required' => 'Новый Email не заполнен',
            'code.required' => 'Неверный код'
        ]);

        $matched = ($emailOld == $currentUser->email);

        if (!$matched) {
            $validator->errors()->add('email_old', 'Старый email неверный');
        }

        $exists = User::query()->whereEmail($emailNew)->first();

        if ($exists) {
            $validator->errors()->add('email_new', 'Такой email уже занят');
        }

        return $validator->errors()->getMessageBag()->getMessages();
    }

    public function getPhoneValidator($request, $currentUser, $publicUser, $phoneOld, $phoneNew, $except = [])
    {

        if (!$publicUser || !$currentUser) {
            return $this->error('Пользователь не найден');
        }

        if ($currentUser->id !== $publicUser->id) {
            return $this->error('Несовпадение пользователей');
        }

        if ($currentUser && !$currentUser->hasPermissionOwn('profile_access')) {
            return $this->error('У вас нет прав для доступа к профилю');
        }

        if ($currentUser && !$currentUser->hasPermissionOwn('profile_tel_edit')) {
            return $this->error('у Вас нет прав для изменения телефона');
        }

        $rules = [
            'code' => 'required',
            'phone_old' => 'min:6|required|phone:AUTO',
            'phone_new' => 'min:6|required|phone:AUTO'
        ];

        if (!empty($except)) {
            $rules = collect($rules)->except($except)->toArray();
        }

        $validator = Validator::make($request->all(), $rules, [
            'code.required' => 'Ввведите код подтверждения',
            'phone_old.phone' => 'Неверный формат старого телефона',
            'phone_new.phone' => 'Неверный формат нового телефона',
            'phone_new.required' => 'Новый Телефон не заполнен',
            'phone_old.min' => 'Старый телефон должен быть не менее 6 символов',
            'phone_old.required' => 'Напишите старый телефон',
            'phone_new.min' => 'Новый телефон должен быть не менее 6 символов'
        ]);

        $phoneOld = preg_replace('#[^0-9\+]+#', '', $phoneOld);
        $phoneNew = preg_replace('#[^0-9\+]+#', '', $phoneNew);
        $currentPhone = preg_replace('#[^0-9\+]+#', '', $currentUser->phone);

        $matched = ($phoneOld == $currentPhone);

        if (!$matched) {
            $validator->errors()->add('phone_old', 'Старый телефон неверный');
        }

        $exists = User::query()->wherePhone($phoneNew)->first();

        if ($exists) {
            $validator->errors()->add('phone_new', 'Такой телефон уже занят');
        }

        return $validator->errors()->getMessageBag()->getMessages();
    }

    /**
     * @param Request $request
     * @return array
     * @throws PermissionDoesNotExist
     * @api {POST} /api/profile/change_email Изменение email
     * @apiGroup Profile
     * @apiParam {string} email_old старый email
     * @apiParam {string} email_new last новый email
     *
     */
    public function changeEmail(Request $request)
    {
        $emailNew = $request->input('email_new');
        $emailOld = $request->input('email_old');

        $code = $request->input('code');
        $currentUser = Auth::user();
        $publicUser = $this->publicUser();

        $errorMessages = $this->getEmailValidator($request, $currentUser, $publicUser, $emailOld, $emailNew);

        if (!empty($errorMessages)) {
            return $this->error($errorMessages);
        } else {

            $codeResult = self::getCodeFromCache($currentUser, $code, self::EMAIL_CODE);

            if ($codeResult[0] == true) {
                return $this->error('Неверный код');
            }

            Cache::forget($codeResult[1]);

            $currentUser->update(['email' => $emailNew]);

            sendEmail($currentUser->email, 'E-mail изменен', [], 'confirm-change-email', [], env('DEFAULT_DOMAIN'));
            $message = 'Данные успешно изменены!';
        }

        $this->setIsSystem(false);
        $this->setParams($currentUser->toArray());
        $this->createActivity();

        return $this->success($message);
    }

    /**
     * @param Request $request
     * @return array
     * @throws PermissionDoesNotExist
     * @api {POST} /api/profile/change_language Изменение языка системы
     * @apiGroup Profile
     * @apiParam {string} language_id ID языка системы
     */
    public function changeLanguage(Request $request)
    {
        $user = Auth::user();

        $languageId = $request->input('language_id', null);

        $validator = Validator::make($request->all(), [
            'language_id' => 'required'
        ], [
            'language_id.required' => 'Выберите язык'
        ]);

        if ($user) {

            $errorMessages = $validator->errors()->getMessageBag()->getMessages();

            if (empty($errorMessages)) {

                $user->update([
                    'language_id' => $languageId
                ]);
            } else {
                return $this->error($errorMessages);
            }
        } else {
            return $this->error('Пользователь не найден');
        }

        $this->setIsSystem(false);
        $this->setParams($user->toArray());
        $this->createActivity();

        $profileUserString = 'profileUser.' . $user->id;
        Session::forget($profileUserString);

        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws PermissionDoesNotExist
     * @api {POST} /api/profile/change_phone Изменение номера телефона
     * @apiGroup Profile
     * @apiParam {string} phone_old старый телефон
     * @apiParam {string} phone_new last новый телефон
     */
    public function changePhone(Request $request)
    {
        $currentUser = Auth::user();
        $publicUser = $this->publicUser();
        $phoneOld = $request->input('phone_old');
        $phoneNew = $request->input('phone_new');

        $message = 'Телефон изменен';
        $code = $request->input('code');

        $errorMessages = $this->getPhoneValidator($request, $currentUser, $publicUser, $phoneOld, $phoneNew);

        if (!empty($errorMessages)) {
            return $this->error($errorMessages);
        } else {

            $codeResult = self::getCodeFromCache($currentUser, $code, self::PHONE_CODE);

            if ($codeResult[0] == true) {
                return $this->error('Неверный код');
            }

            Cache::forget($codeResult[1]);

            $phoneNew = preg_replace('#[^0-9\+]+#', '', $phoneNew);
            $currentUser->update(['phone' => $phoneNew]);

            send_sms($phoneNew, $message . "\n\n" . 'Reactus');
        }

        $this->setIsSystem(false);
        $this->setParams($currentUser->toArray());
        $this->createActivity();

        return $this->success($message);
    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     * @api {POST} /api/profile/delete_multi_field/{id} Delete multi field row
     * @apiGroup Profile
     * @apiParam {integer} id id of the field
     *
     * @internal param Request $request
     */
    public function deleteMultiField($id)
    {
        $success = false;
        $message = 'Данные успешно удалены!';
        $user = Auth::user();
        $fieldGroup = null;

        if ($user) {
            $fieldUserGroup = FieldUserGroup::with('field_group')->findOrFail($id);
            $fieldGroup = $fieldUserGroup->field_group_id;

            if ($fieldUserGroup->user_id != $user->id) {
                $success = false;
                $message = 'Ошибка авторизации...';
            } else {
                $fieldUserValue = FieldUserValue::with('field')->where('field_user_group_id', $fieldUserGroup->id);

                $this->setIsSystem(false);
                $this->setParams($fieldUserValue->get()->toArray());
                $this->createActivity();

                $fieldUserValue->delete();
                $fieldUserGroup->delete();
                $success = true;
            }
        } else {
            $message = 'Ошибка авторизации...';
        }

        return $this->success([
            'success' => $success,
            'message' => $message,
            'field_user_group_id' => (int)$id,
            'field_group_id' => $fieldGroup
        ]);
    }

    /**
     * @param Request $request
     * @return array
     * @api {POST} /api/profile/search/article Поиск по своим статьям
     * @apiGroup Profile
     * @apiParam {string} term Term of search
     * @apiParam {string} token User token
     *
     */
    public function searchArticle(Request $request)
    {
        $term = $request->get('term', null);

        if (!$term) {
            return $this->error('Не задан параметр term');
        }

        $articles = Article::byUser(Auth::user()->id)
            ->where('title', 'LIKE', '%' . $term . '%')
            ->get();

        return $this->success(['articles' => $articles]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @api {POST} /api/profile/set_on_homepage Размещение группы на главную
     * @apiGroup Profile
     * @apiParam {string} field_group_id ID группы полей
     * @apiParam {string} on_homepage Значения: 1 - на главную, 0 - нет
     * @apiParam {string} token Токен пользователя
     */
    public function setOnHomepage(Request $request): JsonResponse|bool|string
    {
        $fieldGroupId = $request->get('field_group_id', null);
        $onHomepage = $request->get('on_homepage', null);

        if (!$fieldGroupId) {
            return $this->error('Не задан параметр группы полей');
        }

        if (!isset($onHomepage)) {
            return $this->error('Не задан параметр на главную');
        }

        $fieldGroup = FieldGroup::query()->find($fieldGroupId);

        if (!$fieldGroup) {
            return $this->error('Группа полей не найдена');
        }

        $user = $this->publicUser();
        $fieldUserGroup = FieldUserGroup::whereUserId($user->id)
            ->whereFieldGroupId($fieldGroupId)->first();

        if (!$fieldUserGroup) {
            FieldUserGroup::firstOrCreate([
                'user_id' => $user->id,
                'field_group_id' => $fieldGroup->id,
                'visibility' => config('netgamer.default_group_visibility'),
                'on_homepage' => (int)$onHomepage
            ]);
        } else {
            $fieldUserGroup->update([
                'on_homepage' => (int)$onHomepage
            ]);
        }

        $fieldGroups = FieldGroup::homepage();

        $this->setIsSystem(false);
        $this->setParams($fieldGroups->toArray());
        $this->createActivity();

        return $this->success([
            'field_groups' => $fieldGroups
        ]);
    }

    /**
     * @return JsonResponse|bool|string
     * @api {GET} /api/profile/delete_account Удаление аккаунта
     * @apiGroup Profile
     * @apiParam {string} token token пользователя
     */
    public function deleteAccount(): JsonResponse|bool|string
    {
        $user = $this->publicUser(false);

        if (!$user || Auth::user()->id != $user->id) {
            return $this->error('Пользователь не найден');
        }

        $user->update([
            'active' => 0
        ]);

        return $this->success('Аккаунт успешно удален');
    }

    /**
     * @param Request $request
     * @return array
     * @api {GET} /api/profile/statuses Список моих мыслей
     * @apiGroup Profile
     * @apiParam {integer} page номер страницы
     * @apiParam {string} token token пользователя
     *
     */
    public function statuses(Request $request)
    {
        $user = $this->publicUser();

        if (!$user) {
            return $this->error('Пользователь не найден');
        }

        $statuses = UserStatus::with('userStatusEmotion')
            ->whereUserId($user->id)->orderBy('id', 'desc');

        $page = $request->get('page');

        $statuses = $statuses->paginate(5, ['*'], 'page');
        $statuses = Utils::transformUrl($statuses);
        $statuses->appends([
            'page' => $page
        ]);

        $emotions = UserStatusEmotion::orderBy('name', 'asc')->get();

        return $this->success(compact('statuses', 'emotions'));
    }

    /**
     * @param Request $request
     * @return array|false|JsonResponse|string
     * @api {POST} /api/profile/save_status Сохранение статуса
     * @apiGroup Profile
     * @apiParam {string} status status
     * @apiParam {string} token токен пользователя
     * @apiParam {integer} user_status_emotion_id ID Эмоции
     *
     * @internal param $id
     * @internal param Request $request
     */
    public function saveStatus(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status', null);
        $emotionId = $request->input('user_status_emotion_id', null);
        $userStatus = null;

        if ($user) {
            if (mb_strlen(preg_replace('/\s+/u', '', $status)) == 0) {
                $status = null;
            }

            $status = preg_replace('#\s{2,}#', ' ', htmlentities($status));

            if (mb_strlen($status) < 1) {
                return $this->error('Статус должен быть не менее 1 символа');
            }

            $userStatus = UserStatus::create([
                'user_id' => $user->id,
                'status' => $status,
                'user_status_emotion_id' => $emotionId
            ]);

            $user->update(['user_status_id' => $userStatus->id]);
            $profileUserString = 'profileUser.' . $user->id;

            Session::forget($profileUserString);

            $this->setIsSystem(false);
            $this->setParams($user->toArray());
            $this->createActivity();

        } else {
            return $this->error('Пользователь не найден');
        }

        $oStatus = null;

        if ($userStatus) {
            $oStatus = $userStatus;
        }

        return $this->success(['status' => $oStatus]);
    }

    /**
     * @param Request $request
     * @return array
     * @api {POST} /api/profile/save_images Сохранение картинок
     * @apiGroup Profile
     * @apiParam {array} images Массив картинок
     * @apiParam {string} token токен пользователя
     * @internal param $id
     * @internal param Request $request
     */
    public function saveImages(Request $request)
    {
        $data = $request->all();

        if (empty($data['images'])) {
            return $this->deleteImages();
        }

        $images = UserStorageImage::whereUserId(Auth::user()->id)
            ->whereType(UserStorageImage::SLIDE);
        $syncFiles = collect();

        if (count($images->get()) > 0) {
            $images->forceDelete();
        }

        foreach ($data['images'] as $image) {

            $storageFile = StorageFile::find($image['id']);

            if ($storageFile) {
                $newImage = UserStorageImage::firstOrCreate([
                    'user_id' => Auth::user()->id,
                    'storage_file_id' => $storageFile->id,
                    'type' => UserStorageImage::SLIDE
                ]);
                $syncFiles->push([
                    'id' => $newImage->storage_file_id,
                    'title' => $newImage->storageFile->title,
                    'descirption' => $newImage->storageFile->description,
                    'url' => $newImage->storageFile->url . $newImage->storageFile->filename,
                    'url_miniature' => $newImage->storageFile->thumbs['thumb1920x1080'],
                    'orginal' => $newImage->storageFile->thumbs['original']
                ]);
            }
        }

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        UserStorageImage::flushCache();

        return $this->success($syncFiles->toArray());
    }

    /**
     * @return array|false|JsonResponse|string
     * @api {POST} /api/profile/delete_images Удаление слайдов
     * @apiGroup Profile
     * @apiParam {string} token токен пользователя
     * @internal param $id
     * @internal param Request $request
     */
    public function deleteImages()
    {
        $images = UserStorageImage::where('user_id', Auth::user()->id)
            ->where('type', UserStorageImage::SLIDE);

        if (count($images->get()) > 0) {
            $this->setIsSystem(false);
            $this->setParams($images->get()->toArray());
            $this->createActivity();

            $images->forceDelete();
        }

        UserStorageImage::flushCache();

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @internal param Request $request
     * @api {POST} /api/profile/change_domain_nick Смена домена и ника
     * @apiGroup Auth
     *
     * @apiParam {string} domain Имя нового или текущего домена в виде domain.tld
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function changeDomain(Request $request)
    {
        $request = $request->all();
        $user = Auth::user();

        if (empty($request['domain'])) {
            return $this->error('Не заданы все параметры');
        }

        $domain = Domain::query()->personal()->active()
            ->whereHideFromRegistration(0)
            ->whereName($request['domain'])->first();

        if (!$domain) {
            return $this->error('Домен не найден');
        }

        $validator = self::validateUserLogin($request);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $fullUrl = $user->username . '.' . $request['domain'];

        $domainExists = User::whereDomain($fullUrl)->first();

        if ($domainExists) {
            return $this->error("Домен $fullUrl уже существует");
        }

        $user = \Auth::user();

        $user->update(['domain' => $fullUrl]);

        \Auth::login($user, true);

        if (!empty($user->email)) {

            sendEmail(\Auth::user()->email, 'Новый домен', [
                'domain' => $user->domain
            ], 'new-nickname');

        } elseif (!empty($user->phone)) {
            $message = 'Ваш новый домен: ' . $fullUrl;
            send_sms($user->phone, $message);
        }

        $profileUserString = 'profileUser.' . $user->id;
        $userString = 'user.' . $user->id;

        $this->setIsSystem(false);
        $this->setParams($user->toArray());
        $this->createActivity();

        Session::forget($profileUserString);
        Session::forget($userString);

        (new Deployer($fullUrl, $user->blogSite->domainVolume, true))->v1();

        return $this->success(\Auth::user());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @internal param Request $request
     * @api {POST} /api/profile/change_username Смена ника
     * @apiGroup Auth
     *
     * @apiParam {string} username Новое имя пользователя
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function changeUsername(Request $request)
    {
        $request = $request->all();

        if (empty($request['username'])) {
            return $this->error('Не задан ник');
        }

        $request['login'] = slugify($request['username']);

        $validator = self::validateUserLogin($request);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $user = \Auth::user();

        $user->update(['username' => $request['login']]);

        \Auth::login($user, true);

        if (!empty($user->email)) {

            sendEmail(\Auth::user()->email, 'Регистрация', [
                'username' => $user->username,
                'domain' => $user->domain
            ], 'new-nickname');

        } elseif (!empty($user->phone)) {
            $message = 'Ваш новый ник: ' . $user->username;
            send_sms($user->phone, $message);
        }

        $profileUserString = 'profileUser.' . $user->id;
        $userString = 'user.' . $user->id;

        $this->setIsSystem(false);
        $this->setParams($user->toArray());
        $this->createActivity();

        Session::forget($profileUserString);
        Session::forget($userString);

        return $this->success(\Auth::user());
    }
}