<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NeoCard;
use App\Models\User;
use App\Models\UserCart;
use App\Traits\Activity;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCartController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(UserCart::class);
        $this->setUserActivity();
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/cart Корзина пользователя
     * @apiGroup Cart
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        return $this->success(self::getCartObjects($user));
    }

    public static function getCartObjects($user): array
    {
        $objects = UserCart::query()->byUser($user->id)->orderBy('created_at')->get();

        $total = 0;
        $totalItems = 0;

        foreach ($objects as $i => $o) {
            if ($o->object == null) {
                unset($objects[$i]);
            }
            if (!$o->price) {
                $o->price = 0;
            }
            $total += $o->price * $o->count;
            $totalItems += $o->count;
        }
        return compact('objects', 'total') + ['total_items' => $totalItems];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/cart/add Добавление в корзину
     * @apiGroup Cart
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} object_id  ID обьекта
     * @apiParam {integer} count количество продуктов
     */
    public function add(Request $request): JsonResponse
    {
        $result = $this->getUserAndCount($request);

        if (empty($result['count']) || $result['count'] <= 0) {
            return $this->error('Не задано количество продуктов');
        }

        $card = self::checkCard($result);

        if ($card['error']) {
            return $card['error'];
        }

        $price = $card['card']->price();

        if ($price instanceof JsonResponse) {
            $price = 0;
        }

        $object = UserCart::query()->byUser($result['user']->id)->whereObjectId($card['card']->id)->first();

        if ($object) {
            $totalCount = $result['count'] + $object->count;
            $object->update(['price' => $price, 'count' => $totalCount]);
        } else {
            UserCart::query()->firstOrCreate([
                'user_id' => $result['user']->id,
                'object_id' => $card['card']->id,
                'price' => $price,
                'count' => $result['count']
            ]);
        }

        return $this->success(self::getCartObjects($result['user']));
    }

    public function getUserAndCount($request): array
    {
        $user = Auth::user();

        $data = $request->all();
        $count = (int)$data['count'] ?? 0;
        $objectId = $data['object_id'] ?? null;

        return compact('user', 'count', 'objectId');
    }

    public function checkCard($result): array
    {
        $card = NeoCard::query()->find($result['objectId']);
        $error = null;

        if (!$card) {
            $error = $this->error('Продукт не найден');
        }

        return compact('card', 'error');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     * @api {POST} /api/cart/update Обновление продукта в корзине
     * @apiGroup Cart
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} object_id  ID обьекта
     * @apiParam {integer} count количество продуктов (0 < n > 0)
     */
    public function update(Request $request): JsonResponse
    {
        $result = $this->getUserAndCount($request);

        if (empty($result['count'])) {
            return $this->error('Не задано количество продуктов');
        }

        $card = self::checkCard($result);

        if ($card['error']) {
            return $card['error'];
        }

        $object = UserCart::query()->byUser($result['user']->id)->whereObjectId($card['card']->id)->first();

        if ($object) {
            $totalCount = $result['count'] + $object->count;
            if ($totalCount <= 0) {
                $object->delete();
                $object = null;
            } else {
                $object->update(['count' => $totalCount]);
            }
        } else {
            return $this->error('Продукт в корзине не найден');
        }

        return $this->success(self::getCartObjects($result['user']));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     * @api {POST} /api/cart/delete Удаление продукта из корзины
     * @apiGroup Cart
     * @apiParam {string} token Ключ пользователя
     * @apiParam {integer} id ID обьекта в корзине
     */
    public function delete(Request $request): JsonResponse
    {
        $user = Auth::user();

        $data = $request->all();
        $id = $data['id'] ?? null;

        $object = UserCart::query()->byUser($user->id)->find($id);

        if (!$object) {
            return $this->error('Продукт в корзине не найден');
        }

        $object->delete();

        return $this->success(self::getCartObjects($user));
    }

    /**
     * @return JsonResponse
     * @api {POST} /api/cart/checkout Оплата корзины
     * @apiGroup Cart
     * @apiParam {string} token Ключ пользователя
     */
    public function checkout(): JsonResponse
    {
        $user = Auth::user();

        return $this->success($user);
    }
}