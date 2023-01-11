<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\Site;
use App\Models\User;
use App\Traits\Activity;
use ArrayCollection;
use Auth;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ForgotController extends Controller
{
    /**
     * @activity done
     */
    use AuthenticatesUsers;
    use Activity;

    protected string $username = 'login';

    public function __construct()
    {
        parent::__construct();
        $this->setDefaultActivity();
        $this->setIsSystem(true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/forgot/send-code Отправка кода
     * @apiGroup Forgot password
     *
     * @apiParam {string} username  User username|email|phone
     *
     *
     */
    public function sendCode(Request $request)
    {
        $message = 'Код успешно отправлен ';
        $username = $request->input('username');
        $phone = preg_replace('/[^\+\d]+/', '', $username);
        $email = $username;

        $validator = $this->sendCodeValidator($request->all());

        if ($validator->fails()) {
            return $this->error($validator->messages());
        }

        $user = User::orWhere('username', trim($username));

        if (!empty($phone)) {
            $user = $user->orWhere('phone', $phone);
        }

        $user = $user->orWhere('email', $email)->first();

        if (!$user) {
            return $this->error('Такой пользователь не найден');
        }

        $cCode = function ($user) {

            $code = PasswordReset::whereUserId($user->id)->get()->first();

            if ($code) {
                $code->delete();
            }

            $code = PasswordReset::create([
                'phone' => !empty($user->phone) ? $user->phone : null,
                'email' => (strstr($user->email, '@')) ? $user->email : null,
                'token' => generate_code(),
                'user_id' => $user->id
            ]);

            return $code;
        };

        if (!empty($user->phone)) {
            $message .= 'на телефон';
            $phone = preg_replace('/[^0-9]+/', '', $user->phone);
            send_sms($phone, $cCode($user)->token);

        } elseif (!empty($user->email)) {

            $message .= 'на e-mail ' . $user->email;
            sendEmail($user->email, 'Восстановление пароля на сайте ' . env('DOMAIN'),
                ['token' => $cCode($user)->token], 'forgot-password-code');

        } else {
            return $this->error('Такой пользователь не найден');
        }

        return $this->success($message);
    }

    protected function sendCodeValidator($data)
    {
        return Validator::make($data, [
            'username' => 'required'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/forgot/check-code  Проверка кода
     * @apiGroup Forgot password
     * @apiParam {string} code  User code
     *
     */
    public function checkCode(Request $request)
    {
        $code = $request->input('code', null);
        if ($code) {
            $reset = PasswordReset::where('token', $code)->get()->first();
            if (!$reset) {
                return $this->error('Код не найден');
            }
        } else {
            return $this->error(['code' => 'Невалидный код']);
        }

        return $this->success([], 'Код найден');
    }

    // TODO: Refactoring AjaxAuthController has this method

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/forgot/check-login  Проверка логина
     * @apiGroup Forgot password
     * @apiParam {string} login  Логин пользователя
     *
     */
    public function checkLogin(Request $request)
    {
        $login = $request->input('login');

        if ($login) {
            $phone = preg_replace('/[^\+\d]+/', '', $login);
            $user = User::orWhere('email', '=', $login)
                ->orWhere('username', '=', $login);

            if (!empty($phone)) {
                $user = $user->orWhere('phone', '=', $phone);
            }

            $user = $user->first();
            if (!$user) {
                return $this->error(['user' => 'Такой пользователь не найден...']);
            }
        } else {
            return $this->error(['user' => 'Параметр логин отсутствует']);
        }

        return $this->success($user->only(['phone_hidden', 'email_hidden']));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @api {POST} /api/forgot/change-password  Смена пароля
     * @apiGroup Forgot password
     * @apiParam {string} username  User username|email|phone (required)
     * @apiParam {string} code  User code
     * @apiParam {string} password password
     * @apiParam {string} password_confirmation password confirmation
     *
     */
    public function forgot(Request $request)
    {
        $emailPhoneUsername = $request->input('username');
        $code = $request->input('code');
        $password = $request->input('password');
        $validator = $this->forgotValidator($request->all());

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $user = User::orWhere('email', '=', $emailPhoneUsername)
            ->orWhere('username', '=', $emailPhoneUsername);

        $phone = preg_replace('/[^\+0-9]+/', '', $emailPhoneUsername);

        if (!empty($phone)) {
            $user = $user->orWhere('phone', '=', $phone);
        }

        $user = $user->get()->first();

        if (!$user) {
            return $this->error(['user' => 'Пользователь не найден']);
        }

        $oCode = PasswordReset::where('token', $code)->get()->first();

        if (!$oCode) {
            return $this->error(['code' => 'Такой код не найден']);
        }

        $user->update([
            'password' => bcrypt($password), 'active' => 1
        ]);

        PasswordReset::where('token', $code)->delete();

        if ($user->email) {

            sendEmail($user->email, 'Новый пароль на сайте ' . env('DOMAIN'),
                ['password' => $password], 'forgot-password-password');

        } elseif ($user->phone) {

            $phone = preg_replace('/[^\+0-9]+/', '', $user->phone);
            send_sms($phone, 'Пароль на сайте ' . env('DOMAIN') . ' изменен');

        } else {
            return $this->error('Данные пользователя не найдены');
        }

        return $this->success($user, 'Пароль обновлен.');
    }

    protected function forgotValidator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
            'code' => 'required'
        ]);
    }
}
