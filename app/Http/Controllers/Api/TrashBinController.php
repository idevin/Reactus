<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Section;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\TrashBin;
use Auth;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TrashBinController extends Controller
{
    /**
     * @activity done
     */
    use TrashBin;
    use Activity;

    public static array $allowedTypes = ['article', 'section'];

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Section::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['deleteForever', 'massDelete', 'massDeleteArticles',
            'massDeleteSections', 'undelete']);
    }

    /**
     * @param Request $request
     * @return array
     * @api {GET} /api/trash Список удаленных обьектов
     * @apiGroup Trash Bin
     *
     * @apiParam {integer} token Токен пользователя
     *
     */
    public function index(Request $request)
    {
        $site = $this->getSite(env('DOMAIN'));

        $rootSection = Section::roots()->bySite($site->id)->first();

        return $this->showTrash($request, $rootSection->id);
    }

    /**
     * @param Request $request
     * @return array|false|JsonResponse|string
     * @api {POST} /api/trash/delete_forever Удаление обьекта навсегда
     * @apiGroup Trash Bin
     *
     * @apiParam {string} token Токен пользователя
     * @apiParam {integer} id ID обьекта
     * @apiParam {string} type тип обьекта (берется из origin.type)
     */
    public function deleteForever(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');

        $allowedTypes = ['article', 'section'];

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        if (!$type || !in_array($type, $allowedTypes)) {
            return $this->error('Неверный тип обьекта');
        }

        return $this->$type($request, $id);
    }

    /**
     * @param Request $request
     * @return array|false|JsonResponse|string
     * @api {POST} /api/trash/undelete Восстановление обьекта
     * @apiGroup Trash Bin
     *
     * @apiParam {string} token Токен пользователя
     * @apiParam {integer} id ID обьекта
     * @apiParam {string} type тип обьекта (берется из origin.type)
     */
    public function undelete(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        if (!$type || !in_array($type, self::$allowedTypes)) {
            return $this->error('Неверный тип обьекта');
        }

        return $this->$type($request, $id, true);
    }


    /**
     * @param Request $request
     * @param $sectionName
     * @param $id
     * @return JsonResponse
     * @api {GET} /api/section/{title}-{id}/trash Корзина для раздела
     * @apiGroup Trash Bin
     *
     * @apiParam {string} token Токен пользователя
     */
    public function showBySection(Request $request, $sectionName, $id)
    {
        return $this->show($request, $sectionName, $id);
    }

    public function show(Request $request, $sectionName, $id = null)
    {
        return $this->showTrash($request, $id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/trash/sections/mass_delete Массовое удаление разделов
     * @apiGroup Trash Bin
     *
     * @apiParam {string} token Токен пользователя
     * @apiParam {array} ids[] массив ID разделов
     *
     */
    public function massDeleteSections(Request $request)
    {
        $ids = $request->get('ids', null);
        if (empty($ids)) {
            return $this->error('Не задан параметр ids');
        }

        $this->massDelete(Section::class, $ids);

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/trash/articles/mass_delete Массовое удаление статей
     * @apiGroup Trash Bin
     *
     * @apiParam {string} token Токен пользователя
     * @apiParam {array} ids[] массив ID статей
     *
     */
    public function massDeleteArticles(Request $request)
    {
        $ids = $request->get('ids', null);
        if (empty($ids)) {
            return $this->error('Не задан параметр ids');
        }

        $this->massDelete(Article::class, $ids);

        return $this->success();
    }

    protected function article(Request $request, $id, $undelete = null)
    {
        $this->objectAction(Article::class, $id, $undelete);
        $sectionId = $request->get('section_id');

        return $this->showTrash($request, $sectionId);
    }

    protected function section(Request $request, $id, $undelete = null)
    {
        $this->objectAction(Section::class, $id, $undelete);
        $sectionId = $request->get('section_id');

        if($undelete == true) {
            Article::query()->withTrashed()->whereSectionId($sectionId)->restore();
            Section::query()->withTrashed()->whereParentId($sectionId)->restore();
        }

        Section::rebuild();

        return $this->showTrash($request, $sectionId);
    }

    protected function objectAction($object, $id, $undelete = null)
    {
        $abstractObject = $object::withTrashed()->whereNotNull('deleted_at')->find($id);

        if ($abstractObject) {
            $this->setIsSystem(false);
            $this->setParams($abstractObject->toArray());
            $this->createActivity();

            if ($undelete == true) {
                $abstractObject->restore();
            } else {
                $abstractObject->forceDelete();
            }

            return true;
        }

        return false;
    }

    protected function massDelete($object, $ids)
    {
        $objects = $object::withTrashed()->whereNotNull('deleted_at')->whereIn('id', $ids);

        $this->setIsSystem(false);
        $this->setParams($objects->get()->toArray());
        $this->createActivity();

        $objects->forceDelete();
    }
}