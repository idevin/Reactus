<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogSection;
use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\DomainVolume;
use App\Models\Language;
use App\Models\RegisterCode;
use App\Models\Role;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Auth;
use App\Traits\AuthMethods;
use App\Traits\Domain as DomainTrait;
use App\Traits\User as UserTrait;
use DB;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class RegisterController extends Controller
{
    /**
     * @activity done
     */
    use AuthenticatesUsers, AuthMethods, DomainTrait, UserTrait, Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(RegisterCode::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['register', 'registerV2', 'sendCode']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/register/check-login Проверка логина
     * @apiGroup Registration
     *
     * @apiParam {string} login  Username
     *
     *
     */
    public function checkLogin(Request $request)
    {
        $login = trim($request->get('login', ''));
        $domainId = trim($request->get('domain_id'));

        $validator = self::validateUserLogin($request->all());

        if (!$validator->fails()) {
            return $this->success();
        }

        $domain = Domain::whereId($domainId)->get(['id', 'name', 'domain_type'])->first();

        /**
         * @todo: add available logins
         */
        $logins = [
            $login . date('Y'),
            $login . mt_rand(10, 1000),
            $login . mt_rand(10, 1000),
            $login . mt_rand(10, 1000),
        ];

        foreach ($logins as $i => $item) {
            if (User::where('username', $item)->get()->first()) {
                unset($logins[$i]);
            }
        }

        if (!preg_match('/^[a-zA-Z0-9\_\-]+$/', $login)) {
            $logins = null;
        }

        $data = [
            'result' => 'fail',
            'logins' => $logins,
            'domain' => $domain
        ];

        return $this->error($validator->errors(), $data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/register/check-email Проверка E-mail
     * @apiGroup Registration
     *
     * @apiParam {string} email Email
     *
     */
    public function checkEmail(Request $request): JsonResponse
    {
        $validEmail = Validator::make($request->all(), [
            'email' => 'required|email_extended'
        ], [
            'email.required' => 'Email обязателен для заполнения',
            'email.email_extended' => 'Неправильный email'
        ]);

        if ($validEmail->fails()) {
            return $this->error($validEmail->errors());
        }

        $emailExists = Validator::make($request->all(), [
            'email' => 'unique:mysqlu.user,email'
        ], [
            'email.unique' => 'Такой Email уже зарегистрирован'
        ]);

        if ($emailExists->fails()) {
            return $this->error($emailExists->errors(), null, 409);
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/register/check-phone Проверка телефона
     * @apiGroup Registration
     *
     * @apiParam {string} phone Phone
     *
     *
     */
    public function checkPhone(Request $request)
    {
        $inputData = $request->all();

        if (isset($inputData['phone'])) {
            $inputData['phone'] = preg_replace('/[^\+\d]+/', '', $inputData['phone']);
        }

        $validPhone = Validator::make($inputData, [
            'phone' => 'required|regex:/^\+(\d)+$/'
        ], [
            'phone.required' => 'Телефон обязателен для заполнения',
            'phone.regex' => 'Телефон должен содержать префикс страны'
        ]);

        if ($validPhone->fails()) {
            return $this->error($validPhone->errors());
        }

        $phoneExists = Validator::make($inputData, [
            'phone' => 'unique:mysqlu.user,phone'
        ], [
            'phone.unique' => 'Такой номер уже зарегистрирован в системе',
        ]);

        if ($phoneExists->fails()) {
            return $this->error($phoneExists->errors(), null, 409);
        }

        return $this->success();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/register/send-code Отправка кода
     * @apiGroup Registration
     *
     * @apiParam {Number} phone  User phone (required if email is empty)
     * @apiParam {string} email  User email (required if phone is empty)
     *
     *
     */
    public function sendCode(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'phone' => 'required_without:email',
            'email' => 'required_without:phone|email_extended',
        ], [
            'phone.required_without' => 'Телефон или e-mail обязателен для заполнения',
            'email.required_without' => 'Телефон или e-mail обязателен для заполнения',
            'email.email_extended' => 'Неправильный e-mail'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $viaEmail = 0;
        $viaSms = 0;
        $data = [];
        $codeLength = config('netgamer.registration.sms-code-length');
        $regexPhone = '/[^\+\d]+/';
        $codeError = 'Пользователь уже зарегистрирован';

        if (!empty($input['email'])) {
            $viaEmail = 1;

            $data[$viaEmail] = [
                'field' => 'email',
                'value' => $input['email'],
                'code' => generate_code($codeLength)
            ];

            $userExists = User::whereEmail($input['email'])->first();
            if ($userExists) {
                return $this->error($codeError);
            }
        }

        if (!empty($input['phone'])) {
            $viaSms = 2;
            $phone = preg_replace($regexPhone, '', $input['phone']);

            $data[$viaSms] = [
                'field' => 'phone',
                'value' => $phone,
                'code' => generate_code($codeLength)
            ];

            $userExists = User::wherePhone($phone)->first();
            if ($userExists) {
                return $this->error($codeError);
            }
        }

        if ($viaEmail == 0 && $viaSms == 0) {
            return $this->error('Неверный параметр отправки');
        }

        if (isset($data[$viaSms])) {
            $phone = preg_replace($regexPhone, '', $input['phone']);

            $smsExists = RegisterCode::whereField('phone')
                ->whereValue($phone)->first();

            if ($smsExists) {
                $smsExists->delete();
            }

            $smsData = RegisterCode::firstOrCreate($data[$viaSms]);
        }


        if (isset($data[$viaEmail])) {
            $emailExists = RegisterCode::whereField('email')
                ->whereValue($input['email'])->first();

            if ($emailExists) {
                $emailExists->delete();
            }

            $emailData = RegisterCode::firstOrCreate($data[$viaEmail]);
        }

        if ($viaSms == 2 && isset($smsData)) {
            $message = 'Registration code: ' . $smsData->code;
            send_sms($input['phone'], $message);
            $smsData->update(['sent' => 1]);
        }

        if ($viaEmail == 1 && isset($emailData)) {
            sendEmail($input['email'], 'Регистрация', ['code' => $emailData->code], 'register-code');
            $emailData->update(['sent' => 1]);
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/register/check-code  Проверка кода
     * @apiGroup Registration
     *
     * @apiParam {Number} phone  User phone (required if email is empty)
     * @apiParam {string} email User email (required if phone is empty)
     * @apiParam {string} code Sms code (required)
     *
     */
    public function checkCode(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'phone' => 'required_without:email',
            'email' => 'required_without:phone|email',
        ], [
            'phone.required_without' => 'Телефон или e-mail обязателен для заполнения',
            'email.required_without' => 'Телефон или e-mail обязателен для заполнения',
            'email.email' => 'Невалидный e-mail'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if ($this->loadRegisterCode($input)) {
            return $this->success();
        } else {
            return $this->error(['code' => 'Неверный код']);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/register Регистрация
     * @apiGroup Registration
     *
     * @apiParam {string} login        Username(required)
     * @apiParam {string} password        User password (required)
     * @apiParam {string} password_confirmation        Confirm password (required)
     * @apiParam {string} domain  Domain name (required)
     * @apiParam {Number} phone  User phone (required if email is empty)
     * @apiParam {string} email  User email (required if phone is empty)
     * @apiParam {string} code   Sms-Code (required)
     *
     */
    public function register(Request $request)
    {
        $input = $request->all();
        $site = $this->getSite(env('DOMAIN'));

        $validator = $this->validator($input);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $registerCode = '';
        if (!isset($input['email']) && isset($input['phone'])) {
            $registerCode = $this->loadRegisterCode($input);

            if (!$registerCode) {
                return $this->error(['code' => 'Невалидный код']);
            }
        }

        if (!isset($input['domain'])) {
            $input['domain'] = $input['login'] . '.' . env('DOMAIN');
        } else {
            $input['domain'] = $input['login'] . '.' . $input['domain'];
        }

        $phone = null;
        $email = null;

        if (!empty($input['phone'])) {
            $phone = preg_replace('/[^\+\d]+/', '', $input['phone']);

            if ($registerCode) {
                RegisterCode::whereField('phone')->where('value', $phone)->delete();
            }
        }

        if (!empty($input['email'])) {
            $email = $input['email'];

            if ($registerCode) {
                RegisterCode::whereField('email')->where('value', $email)->delete();
            }
        }

        $language = null;
        if ($site->siteDomain->language) {
            $language = $site->siteDomain->language_id;
        } else {
            $defaultLanguage = Language::whereAlias(config('app.locale'))->first();
            if ($defaultLanguage) {
                $language = $defaultLanguage->id;
            }
        }

        $user = User::firstOrCreate([
            'username' => $input['login'],
            'email' => $email,
            'password' => bcrypt($input['password']),
            'active' => 1,
            'phone' => $phone,
            'domain' => $input['domain'],
            'language_id' => $language
        ]);

        if (empty($user->image)) {
            $color = $user->getColor();

            $imageName = Str::random() . '.jpg';

            $user->generateImage(70, 70, $imageName, $color, 'avatar', username($user));

            $updateData['image'] = $imageName;
            $user->update($updateData);
        }

        $data = [
            'user' => $user,
            'password' => $input['password'],
            'domain' => env('DOMAIN')
        ];

        if (!empty($email)) {
            sendEmail($email, 'Данные о регистрации', $data, 'register-success');
        }

        $roles = Role::whereForRegistered(1)->get();

        if (count($roles) > 0) {
            foreach ($roles as $role) {
                $user->roles()->attach($role->id);
            }
        }

        \Auth::login($user, true);

        $userArray = $user->toArray();

        $this->setIsSystem(false);
        $this->setParams($userArray);
        $this->createActivity();

        return $this->success($userArray);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data, $except = [],
                                     $customErrors = [], $customMessages = [])
    {
        $default = [
            'login' => 'required|unique:mysqlu.user,username',
            'phone' => 'required_without:email',
            'email' => 'required_without:phone|email',
            'password' => 'required|confirmed|min:6',
            'domain' => 'required|exists:domain,name,domain_type,1'
        ];

        $messages = [
            'login.unique' => 'Такой логин уже существует',
            'login.required' => 'Логин обязателен для заполнения',
            'phone.required' => 'Телефон обязателен для заполнения',
            'code.required' => 'Код подтверждения обязателен для заполнения',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен быть минимум 6 символов',
            'phone.required_without' => 'Телефон или e-mail обязателен для заполнения',
            'email.required_without' => 'Телефон или e-mail обязателен для заполнения',
            'email.email' => 'Невалидный e-mail'
        ];

        $messagesMerged = array_merge($messages, $customMessages);

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return \Validator::make($data, $rules, $messagesMerged);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/register/v2 Регистрация: Версия 2
     * @apiGroup Registration
     *
     * @apiParam {Number} phone Номер телефона (required if email is empty)
     * @apiParam {string} email Email (required if phone is empty)
     * @apiParam {string} code Код подтверждения (required)
     * @apiParam {string} personal_domain персональный домен для пользователя
     */
    public function registerV2(Request $request): JsonResponse
    {
        $input = $request->all();

        $timestamp = time();

        if (isset($input['personal_domain'])) {
            $personalDomain = Domain::active()->whereDomainType(Domain::DOMAIN_TYPE_PERSONAL)
                ->whereName($input['personal_domain'])->first();
        } else {
            $personalDomain = self::getRandomPersonal();
        }

        if (!$personalDomain) {
            return $this->error("Персональный домен не найден");
        }

        $password = generate_code(config('netgamer.registration.password_length'));
        $lastUser = DB::connection('mysqlu')->table('user')->latest('id')->first();
        $login = null;

        if ($lastUser) {
            $newLogin = function ($user) {
                $username = $user->id + rand(2, config('auth.password_length'));
                return 'u' . $username;
            };

            while (true) {
                $login = $newLogin($lastUser);
                $user = User::whereUsername($login)->first();
                if (!$user) {
                    break;
                }
            }
        }

        $input['login'] = $login;
        $input['password'] = $password;
        $input['password_confirm'] = $timestamp;
        $input['domain'] = $personalDomain->name;

        $validator = $this->validator($input, ['password'], ['code' => 'required']);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $registerCode = '';
        if (isset($input['email']) || isset($input['phone'])) {
            $registerCode = $this->loadRegisterCode($input);

            if (!$registerCode) {
                return $this->error(['code' => 'Код не найден']);
            }
        }

        $input['domain'] = $input['login'] . '.' . $input['domain'];

        $phone = null;
        $email = null;

        if (!empty($input['phone'])) {
            $phone = preg_replace('#[^0-9\+]+#', '', $input['phone']);

            if ($registerCode) {
                RegisterCode::whereField('phone')->where('value', $phone)->delete();
            }
        }

        if (!empty($input['email'])) {
            $email = $input['email'];

            if ($registerCode) {
                RegisterCode::whereField('email')->where('value', $input['email'])->delete();
            }
        }

        $pvc = DomainVolume::createPvc();

        $user = User::query()->firstOrCreate([
            'username' => $input['login'],
            'email' => $email,
            'password' => bcrypt($input['password']),
            'active' => 1,
            'phone' => $phone,
            'domain' => $input['domain'],
            'language_id' => Language::default()->id
        ]);

        $blogSite = BlogSite::query()->firstOrCreate([
            'domain' => $input['domain'],
            'domain_id' => $personalDomain->id,
            'domain_volume_id' => $pvc->id,
            'user_id' => $user->id
        ]);

        BlogSection::query()->firstOrCreate([
            'title' => 'Содержание сайта',
            'parent_id' => null,
            'site_id' => $blogSite->id,
            'user_id' => $user->id
        ]);

        self::domainInstall($user->domain, $user->username, $pvc, 'personal', self::ourDomain($user->domain));

        $cryptedString = encrypt([
            'login' => $input['login'],
            'password' => $input['password']
        ]);

        if (empty($user->image)) {
            $color = $user->getColor();

            $imageName = Str::random() . '.jpg';

            $user->generateImage(70, 70, $imageName, $color, 'avatar', username($user));

            $updateData['image'] = $imageName;
            $user->update($updateData);
        }

        $data = [
            'user' => $user,
            'password' => $input['password'],
            'domain' => env('DOMAIN')
        ];

        if (!empty($email)) {
            sendEmail($email, 'Данные о регистрации', $data, 'register-success');
        }

        if (!empty($phone)) {
            $message = strtoupper(env('DOMAIN')) . "\nLogin: " . $user->username . "\nPass: " . $input['password'];
            send_sms($phone, $message);
        }

        $roles = Role::whereForRegistered(1)->get();

        if (count($roles) > 0) {
            $user->syncRoles($roles);
        }

        $user->syncAllPermissions($user);

        $data = $user->toArray();
        $data = array_merge($data, ['hash' => $cryptedString]);

        return $this->success($data);
    }
}
