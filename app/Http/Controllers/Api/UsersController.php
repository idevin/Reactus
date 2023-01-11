<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Deployer\Classes\Deployer;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Domain as DomainTrait;
use ArrayCollection;
use Auth;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @activity done
     */
    use AuthenticatesUsers;
    use Activity;
    use DomainTrait;

    protected string $username = 'login';

    public function __construct()
    {
        parent::__construct();
        $this->setDefaultActivity();
    }


    /**
     * POST /api/users/destroy
     * @param Request $request
     * @return false|JsonResponse|string
     */
    public function destroy(Request $request): bool|JsonResponse|string
    {
        $data = $request->all(['id', 'token']);

        if (!isset($data['id']) || !isset($data['token'])) {
            return $this->error('Не заданы все параметры');
        }

        if ($data['token'] !== env('APP_KEY')) {
            return $this->error('Неверный ключ');
        }

        $user = User::find((int)$data['id']);

        if ((int)$user->superadmin === 1) {
            return $this->error('Нельзя удалить аккаунт администратора');
        }

        if (!$user) {
            return $this->error('Пользователь не найден');
        }

        try {
            /**
             * @TODO проверить алиасы персоналок, домен в контейнере может не сходиться со строкой в методе
             * @done Все должно удаляться верно, например: personal-uXYZ
             */

            Deployer::uninstall('u' . (int)$data['id'], 'personal');

            $user->delete();

        } catch (Exception $e) {
            return $this->error('Невозможно удалить пользователя: ' . $e->getMessage());
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     *
     * @api {GET} /api/users/search Поиск по пользователю
     * @apiGroup Users
     * @apiParam {string} token Хэш пользователя
     * @apiParam {string} term Ключевое слово
     */
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('term');

        if (!$term) {
            return $this->error('Не задано ключевое слово');
        }

        if (mb_strlen($term) < 3) {
            return $this->error('Ключевое слово должно быть больше 3 символов');
        }

        $term = trim(strip_tags($term));

        $users = User::query()->where('username', 'LIKE', '%' . $term . '%')
            ->orderBy('username', 'ASC')->limit(10)->get();

        if (count($users) > 0) {
            $users = $users->map(function ($user) {
                return $user->only(['id', 'username', 'first_name', 'last_name', 'thumbs']);
            });
        }

        return $this->success($users);
    }
}
