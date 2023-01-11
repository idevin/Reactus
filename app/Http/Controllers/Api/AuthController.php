<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\PasswordHistory;
use App\Models\Site;
use App\Models\User;
use App\Models\UserSession;
use App\Models\UserSite;
use App\Traits\Activity;
use App\Traits\Domain as DomainTrait;
use ArrayCollection;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth as UserAuth;
use Illuminate\Support\Facades\Lang;
use Session;
use Validator;

class AuthController extends Controller
{
    /**
     * @activity done
     */
    use AuthenticatesUsers;
    use Activity;
    use DomainTrait;

    protected $username = 'login';

    public function __construct()
    {
        parent::__construct();
        $site = get_site();
        $this->setObject(User::class);
        $this->setObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setFromObject(Site::class);

        if ($site) {
            $this->setFromObjectId($site->id);
        }

        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['login', 'logout']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/login Логинизация
     * @apiGroup Auth
     *
     * @apiParam {string} login Телефон, имя пользователя или e-mail
     * @apiParam {string} password пароль
     * @apiParam {string} [hash] Хэш для авторизации
     */
    public function login(Request $request): JsonResponse
    {
        $hash = $request->input('hash');
        $content = [];
        $error = [$this->username => Lang::get('auth.failed')];

        if (!empty($hash)) {
            try {
                $hash = decrypt($hash);
                $request->request->add([
                    'login' => $hash['login'],
                    'password' => $hash['password']
                ]);

            } catch (DecryptException $e) {
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars($e->getMessage(), $e->getTrace());
                }
                return $this->error("Неверный Хеш");
            }
        }

        $validator = Validator::make($request->all(), [
            $this->username => 'required',
            'password' => 'required'
        ], [
            $this->username . '.required' => 'Вы не заполнили логин',
            'password.required' => 'Заполните пароль'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $updateData = [
            'last_login' => Carbon::now()->toDateTimeString()
        ];

        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = app(RateLimiter::class)->availableIn('login|' . $request->ip());

            return $this->error([
                $this->username => Lang::get('auth.throttle', ['seconds' => $seconds]),
            ]);
        }

        $startBLocks = microtime(true);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('GET USER');
        }

        $phone = preg_replace('/[^+\d]+/', '', $request->input('login'));

        $user = User::where(function ($query) use ($request, $phone) {
            $query->where('email', '=', $request->input('login'))
                ->orWhere('username', '=', $request->input('login'));

            if (!empty($phone)) {
                $query->orWhere('phone', '=', $phone);
            }
        });

        $user = $user->first();

        if (env('APP_DEBUG_VARS') == true) {
            $endBlocks = microtime(true);
            debugvars('GET USER END ' . ($endBlocks - $startBLocks));
        }

        if ($user) {

            if ($user->active == 0) {
                $error[$this->username] = 'Этот аккаунт не активный... Свяжитесь с администратором...';
            }

            if (Hash::check($request->input('password'), $user->password)) {
                if (empty($user->auth_token)) {
                    $authToken = User::authToken();

                    $user->auth_token = $authToken;
                    $updateData['auth_token'] = $authToken;
                }

                if (empty($user->image)) {

                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars('GET USER IMAGE');
                    }

                    $startBLocks = microtime(true);

                    $color = $user->getColor();
                    $imageName = $user->getImageName();

                    $user->generateImage(70, 70, $imageName, $color, 'storage', username($user));

                    $updateData['image'] = $imageName;

                    if (env('APP_DEBUG_VARS') == true) {
                        $endBlocks = microtime(true);
                        debugvars('GET USER IMAGE END ' . ($endBlocks - $startBLocks));
                    }
                }

                $user->update($updateData);

                $credentialsUrl = getSchema() . env('DEFAULT_DOMAIN') . getPort() .
                    route('api.credentials.token', ['token' => $user->auth_token, 'd' => env('DOMAIN')], false);

                $content['credentials'] = $credentialsUrl;

                $content['user'] = $user->toArray();

                $site = $this->getSite(env('DOMAIN'));

                if ($site) {
                    $userSite = UserSite::query()->where([
                        'user_id' => $user->id,
                        'site_id' => $site->id
                    ])->first();

                    if (!$userSite) {
                        $domain = Domain::whereName(idnToAscii($site->domain))->first();

                        UserSite::query()->firstOrCreate([
                            'user_id' => $user->id,
                            'site_id' => $site->id,
                            'admin' => $user->superadmin,
                            'logged' => 1,
                            'domain_id' => $domain->id
                        ]);

                    } else {
                        $userSite->update([
                            'logged' => 1,
                            'admin' => $user->superadmin
                        ]);
                    }
                } else {
                    $site = $this->getSite(main_domain(env('DOMAIN')));
                }

                $title = 'Добро пожаловать, ' . username($user);

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('SYNC USER PERMISSIONS');
                }

                $startBLocks = microtime(true);

                $user->syncAllPermissions($user);
                $siteClass = Site::class;
                if ($site->siteDomain && $site->siteDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {
                    $domainParts = preg_split('#\.#', env('DOMAIN'));

                    if (count($domainParts) == 3) {
                        $siteClass = BlogSite::class;
                    }
                }

                $content['user']['permissions'] = permissions($user, false, null, $siteClass);

                if (env('APP_DEBUG_VARS') == true) {
                    $endBlocks = microtime(true);
                    debugvars('SYNC USER PERMISSIONS END ' . ($endBlocks - $startBLocks));
                }

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('ADD USER ACTS');
                }

                $startBLocks = microtime(true);

                $site = get_site();
                $this->setObject(User::class);
                $this->setObjectId($user->id);
                $this->setFromObject(Site::class);
                $this->setFromObjectId($site->id);
                $this->setIsSystem(false);
                $this->setParams(['data' => ['user' => $user, 'site' => $site]]);
                $this->setTitle('activity.title.AuthController.login');
                $this->setDescription('activity.description.AuthController.login');
                $this->setActivityUser($user);
                $this->setActivityFromUser($user);
                $this->createActivity();

                if (env('APP_DEBUG_VARS') == true) {
                    $endBlocks = microtime(true);
                    debugvars('ADD USER ACTS END ' . ($endBlocks - $startBLocks));
                }

                UserSession::logged($user);

                $this->clearLoginAttempts($request);

                return $this->success($content, $title);

            } else {
                UserSession::try($user);
            }
        }

        $this->incrementLoginAttempts($request);

        if ($user) {
            UserSession::try($user);
        }

        return $this->error($error, null, 401);
    }

    /**
     * @param Request $request
     * @return JsonResponse|mixed
     * @api {GET} /api/logged Проверка авторизации
     * @apiGroup Auth
     *
     * @apiParam {string} [token] Токен пользователя
     */
    public function logged(Request $request)
    {
        $token = $request->get('token');

        $user = Auth::user();

        if (!$user) {
            return $this->error('Пользватель не авторизирован');
        }

        if ($token && $user->auth_token != $token) {
            return $this->error('Ошибка авторизации');
        }

        $userArray = $user->toArray();
        $userArray['permissions'] = permissions($user, false, null);

        return $this->success($userArray);
    }

    /**
     * @return JsonResponse|mixed
     * @api {POST} /api/logout Logout
     * @apiGroup Auth
     *
     */
    public function logout()
    {
        if (UserAuth::user()) {
            $userSite = UserSite::whereUserId(UserAuth::user()->id)->first();

            if ($userSite) {
                $userSite->update([
                    'logged' => 0
                ]);
            }

            UserAuth::user()->update([
                'last_logout' => Carbon::now()->toDateTimeString()
            ]);

            $site = get_site();
            $this->setObject(User::class);
            $this->setObjectId(UserAuth::user()->id);
            $this->setFromObject(get_class($site));
            $this->setFromObjectId($site->id);
            $this->setIsSystem(false);
            $this->setParams(['data' => ['user' => UserAuth::user(), 'site' => $site]]);
            $this->setTitle('activity.title.AuthController.logout');
            $this->setDescription('activity.description.AuthController.logout');
            $this->createActivity();

            $profileUserString = 'profileUser.' . UserAuth::user()->id;
            Session::forget($profileUserString);

            UserSession::loggedOut(UserAuth::user());
        }

        $url = getSchema() . env('DEFAULT_DOMAIN') . getPort() .
            '/credentials/logout?d=' . env('DOMAIN');

        Auth::logout();

        return $this->success(['credentials' => $url], 'Вы успешно вышли из системы');
    }


    public function resetPassword(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ['login' => 'required_if:phone,""']);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if ($request->has('phone')) {
            $phone = preg_replace('/[^0-9]+/', '', $input['phone']);
            $user = User::where('phone', $phone)->firstOrFail();
            $resetVia = PasswordHistory::RESET_PSW_VIA_SMS;
        } else {
            $user = User::where($this->getLoginField($input['login']), $input['login'])
                ->firstOrFail();
            $resetVia = PasswordHistory::RESET_PSW_VIA_EMAIL;
        }

        PasswordHistory::forceCreate([
            'password_hash' => $user->password,
            'reset_via' => $resetVia,
            'user_id' => $user->id
        ]);

        $psw = generate_password();

        // send sms or email
        switch ($resetVia) {
            case PasswordHistory::RESET_PSW_VIA_SMS:
                $message = sprintf('Новый пароль: %s', $psw);
                send_sms($user->phone, $message);
                break;

            case PasswordHistory::RESET_PSW_VIA_EMAIL:
                sendEmail($user->email, 'Восстановление пароля', ['password' => $psw], 'reset-password');
                break;

            default:
                $this->error(['code' => 'Неверный код']);
        }

        $user->password = bcrypt($psw);
        $user->save();

        return $this->success();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (!empty($data['phone'])) {
            $data['phone'] = preg_replace('/[^0-9]+/', '', $data['phone']);
        }

        return Validator::make($data, [
            'login' => 'required|unique:mysqlu.user,username',
            'email' => 'required_if:phone,""|email_extended|max:100|unique:mysqlu.user,email',
            'phone' => 'required_if:email,""|unique:mysqlu.user,phone',
            'code' => 'required',
            'password' => 'required|confirmed|min:6',
            'domain' => 'required|exists:domain,name,domain_type,1'
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['login'],
            'phone' => Arr::has($data, 'phone') ? preg_replace('/[^0-9]+/', '', $data['phone']) : '',
            'email' => Arr::has($data, 'email') ? $data['email'] : '',
            'domain' => $data['domain'],
            'password' => bcrypt($data['password']),
            'active' => 1,
            'auth_token' => User::authToken()
        ]);
    }

    protected function getCredentials(Request $request, $loginKey = 'username')
    {
        $data = $request->all();

        return [
            $loginKey => $data['login'],
            'password' => $data['password']
        ];
    }
}
