<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Activity;
use App\Traits\Utils;
use ArrayCollection;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeletableObjectsController extends Controller
{
    /**
     * @activity done
     */
    use Activity;
    use Utils;

    public function __construct()
    {
        parent::__construct();
        $this->setDefaultActivity();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @apiGroup Deletables
     * @api {GET} /api/deletable_objects Список удаляемых обьектов
     * @apiParam {string} token ключ приложения
     */
    public function index(Request $request)
    {
        $data = $request->all(['token']);

        if (!isset($data['token'])) {
            return $this->error('Не задан ключ приложения');
        }

        if ($data['token'] !== env('APP_KEY')) {
            return $this->error('Неверный ключ');
        }

        $softDeletable = self::getSoftDeletables();

        return $this->success($softDeletable);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     *
     * @api {POST} /api/deletable_objects/destroy Удаление обьекта (Soft delete)
     * @apiGroup Deletables
     * @apiParam {string} object Тип обьекта для удаления (из /api/deletable_objects)
     * @apiParam {integer} id ID обьекта
     * @apiParam {string} token ключ приложения
     */
    public function destroy(Request $request)
    {
        $data = $request->all(['id', 'token', 'object']);

        if (!isset($data['id']) || !isset($data['token']) || !isset($data['object'])) {
            return $this->error('Не заданы все параметры');
        }

        if ($data['token'] !== env('APP_KEY')) {
            return $this->error('Неверный ключ');
        }

        $softDeletable = self::getSoftDeletables();

        if (!in_array($data['object'], $softDeletable)) {
            return $this->error('Обьект не найден');
        } else {
            $object = app($data['object'])->find($data['id']);

            if (!$object) {
                return $this->error('Обьект не найден');
            }

            if (method_exists($object, 'preForceDelete')) {
                $object->preForceDelete();
            }

            $object->forceDelete();
        }

        return $this->success();
    }

}
