<?php

namespace App\Traits;


use App\Models\User as UserModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait User
{

    public static function validateUserLogin($data)
    {
        return \Validator::make($data, [
            'login' => 'required|regex:/^[a-zA-Z0-9\-]+$/|unique:mysqlu.user,username|min:4|max:30'
        ], [
            'login.required' => 'Логин обязателен для заполнения',
            'login.unique' => 'Такой логин уже существует',
            'login.regex' => 'Найдены неверные символы. Логин может содержать буквы, цифры и знак "-"',
            'login.min' => 'Минимальное количество символов: 4',
            'login.max' => 'Максимальное значение символов: 30'
        ]);
    }

    public function publicUser($cached = true, $username = null): Builder|UserModel|null
    {
        $fullDomain = getenv('HTTP_HOST');

        if (!$username) {
            $username = preg_split('#\.#', $fullDomain)[0];
        }

        $user = UserModel::whereUsername($username)
            ->whereDomain($fullDomain)->active()->first();

        if (!$user) {
            return null;
        }

        $profileUserString = 'profileUser.' . $user->id;

        if ($cached == true) {
            if (!\Session::get($profileUserString)) {
                \Session::put($profileUserString, $user);
            } else {
                $user = \Session::get($profileUserString);
            }
        }

        return $user;
    }

    protected function getUser($request = null, $cCookie = null): Model|Collection|array|UserModel|Authenticatable|null
    {
        $userData = Auth::user();

        if ($userData) {
            return $userData;
        }

        if (!$request) {
            $request = request();
        }

        $requestCookie = $request->cookie('c');

        if ($cCookie) {
            $requestCookie = $cCookie;
        }

        if (!empty($requestCookie)) {
            $cookie = decrypt($requestCookie, false);
        } else {
            return null;
        }

        $credentials = $cCookie ? $cCookie : $cookie;

        if ($credentials) {
            return UserModel::query()->find($credentials);
        } else {
            return null;
        }
    }
}