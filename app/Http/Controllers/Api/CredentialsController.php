<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Credentials;
use App\Models\User;
use App\Traits\Activity;
use Auth;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;

class CredentialsController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Credentials::class);
        $this->setUserActivity();
    }

    public function user(): JsonResponse|bool|string
    {
        $user = Auth::user();
        if (!$user) {
            return $this->error('Вы не авторизированы...');
        } else {
            return $this->success($user);
        }
    }

    /**
     * @api {GET} /api/credentials/user/{id} Получение данных пользователя
     * @apiGroup Auth
     * @apiParam {integer} [id] ID пользователя
     * @param $id
     * @return JsonResponse|string
     */
    public function userById($id)
    {
        if (!$id) {
            return $this->error('Неверный ID...');
        } else {
            $user = User::find($id);
            if (!$user) {
                return $this->error('Пользователь не найден...');
            } else {
                return $this->success($user->toArray());
            }
        }
    }
}