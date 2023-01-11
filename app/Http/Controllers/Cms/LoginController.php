<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected static ?User $user = null;
    protected string $redirectTo = '/cms';
    protected string $redirectAfterLogout = '/cms/login';
    protected string $username = 'login';

    public function __construct()
    {
        parent::__construct();

        if (\Auth::user() && \Auth::user()->superadmin == 1) {
            self::$user = \Auth::user();
        }
    }

    public function index()
    {
        if (self::$user) {
            session()->flash('error', 'Вы уже залогинены...');
            return redirect(route('cms.index'));
        }

        return view('cms.login.index');
    }

    public function postLogin(Request $request)
    {
        $inputData = $request->all();
        $remember = isset($inputData['remember']);

        unset($inputData['_token']);
        unset($inputData['remember']);
        unset($inputData["/cms/login"]);

        $validator = $this->createValidator($inputData);

        if ($validator->fails()) {

            return redirect(route('cms.login'))->withInput($inputData)->withErrors($validator->errors());
        } else {
            $inputData['superadmin'] = 1;

            if (!empty($inputData['r'])) {
                $redirect = redirect($inputData['r']);
            } else {
                $redirect = redirect(route('cms.index'));
            }

            $user = Auth::attempt(['username' => $inputData['username'], 'password' => $inputData['password']]);

            if ($user == true) {

                $user = User::whereUsername($inputData['username'])
                    ->where('superadmin', 1)
                    ->get()->first();

                if ($user) {
                    if ($user->allreadyLogged()) {

                        session()->flash('error', 'Вы уже залогинены...');

                    } else {
                        \Auth::loginUsingId($user->id, $remember);
                        session()->flash('success', 'Вы успешно вошли!');

                    }
                    return $redirect;
                } else {
                    return $this->wrongLogin();
                }
            } else {
                return $this->wrongLogin();
            }
        }
    }

    protected function createValidator($data)
    {
        return Validator::make($data, [
            'username' => 'required|exists:mysqlu.user,username',
            'password' => 'required'
        ], [
            'username.required' => 'Ошибка авторизации',
            'username.exists' => 'Ошибка авторизации',
            'password.required' => 'Ошибка авторизации',
        ]);
    }

    public function wrongLogin(): Redirector|Application|RedirectResponse
    {
        $validator = Validator::make([], [
            'username' => 'required',
        ], ['username.required' => 'Неверные логин пароль']);

        return redirect(route('cms.login'))->withErrors($validator->errors());
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        $user = \Auth::user();

        $user?->logout();

        \Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    protected function getCredentials(Request $request): array
    {
        $data = $request->only('login', 'password');

        return [
            $this->getLoginField($data['login']) => $data['login'],
            'password' => $data['password']
        ];
    }

    protected function getLoginField($login): string
    {
        if (is_email($login)) {
            return 'email';
        }
        if (is_phone($login)) {
            return 'phone';
        }

        return 'username';
    }
}