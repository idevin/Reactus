<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Neo4j;
use App\Models\NeoCard;
use App\Models\NeoField;
use App\Models\NeoUserFieldGroup;
use App\Models\NeoCatalogField;
use App\Models\NeoCatalogFieldGroup;
use App\Models\NeoUserCard;
use App\Models\User as UserModel;
use App\Traits\Activity;
use App\Traits\Objects;
use App\Traits\User;
use Auth;
use GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laudis\Neo4j\Exception\Neo4jException;
use Symfony\Component\HttpFoundation\Request;

class ObjectsRelationsController extends Controller
{
    /**
     * @activity done
     */
    use User;
    use Activity;
    use Objects;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(NeoUserCard::class);
        $this->setFromObject(UserModel::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['connect', 'disconnect']);
    }

    /**
     * @return false|JsonResponse|string
     * @internal param Request $request
     * @api {GET} /api/object_relations/list Получение списка готовых карточек
     * @apiGroup Object Relations
     *
     * @apiParam {string} token Токен ключ пользователя
     */
    public function cardsList(): bool|JsonResponse|string
    {
        $user = Auth::user();
        $userData = NeoUserCard::query()->whereUserId($user->id)->first();

        if (!$userData) {
            return $this->error('Карточки не найдены');
        }

        if (count($userData->cards) == 0) {
            return $this->error('Данные для карточек не найдены');
        }

        $data = $userData->cards->makeHidden(['url']);

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/object_relations/get_card Получение конкретной карточки
     * @apiGroup Object Relations
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} id ID карточки
     *
     * @internal param Request $request
     */
    public function getCard(Request $request): bool|JsonResponse|string
    {
        $user = Auth::user();
        $userData = NeoUserCard::whereUserId($user->id)->first();
        $id = $request->get('id');

        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        if (!$userData) {
            return $this->error('Карточки не найдены');
        }

        if (count($userData->cards) == 0) {
            return $this->error('Данные для карточек не найдены');
        }

        $card = $userData->cards()->with(['fieldUserGroups' => function ($query) {
            $query->with(['fields']);
        }])->find($id);

        if (!$card) {
            return $this->error('Карточка не найдена');
        }

        $objectFields = NeoCatalogField::whereUseInCatalogList(1)->get();

        NeoField::$objectFields = $objectFields;

        $card->fieldUserGroups->map(function ($group) use (&$fieldGroupIds) {
            $fieldGroupIds[] = $group->object_field_group_id;
        });

        if ($fieldGroupIds) {
            $fieldGroups = NeoCatalogFieldGroup::query()->whereIn('id', array_unique($fieldGroupIds));
            NeoUserFieldGroup::$fieldGroups = $fieldGroups->get();

            foreach ($card->fieldUserGroups as $fieldUserGroup) {

                foreach ($fieldUserGroup->fields as $field) {
                    if ($field->field && $field->field->use_in_catalog_list == 1) {
                        $data['fields'][] = $field->makeHidden('select_fields');
                    }
                }
            }
        }


        $tree = $this->getTree($card);

        return $this->success($tree);
    }

    public function findChildren($startNode, $queryRecords)
    {
        $tree = [];

        foreach ($queryRecords as $index => $record) {

            $card = $record->get('x');
            $startNode2 = $record->get('start_node');
            $endNode = $record->get('end_node');

            if ($endNode == $startNode) {
                $tree[] = ['id' => $record->get('id(x)')] + $card;
                $children = $this->findChildren($startNode2, $queryRecords);
                if (!empty($children)) {
                    $tree[$index]['children'] = $children;
                }
            }
        }
        return $tree;
    }

    public function getTree($card)
    {
        $tree = [];
        try {
            $query = Neo4j::client()->run("MATCH p=((s:Card)-[*0..]->(x:Card)) " . " 
            WHERE id(s)=" . $card->id . " return x, id(x) as start_node, id(startNode(last(relationships(p)))) as end_node");

            foreach ($query as $index => $record) {
                $startNode = $record->get('start_node');
                $endNode = $record->get('end_node');
                $card = $record->get('x');

                if (empty($endNode)) {
                    $tree[] = ['id' => $record->get('id(x)')] + $card;
                }

                $children = $this->findChildren($startNode, $query->records());
                if (!empty($children)) {
                    $tree[$index]['children'] = $children;
                }
            }

        } catch (Neo4jException $e) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('ERROR:', [$e->getTrace()]);
            }
        }

        return $tree;
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @internal param Request $request
     * @api {POST} /api/object_relations/connect Создание связи
     * @apiGroup Object Relations
     *
     * @apiParam {integer} from_id связь от карточки
     * @apiParam {integer} to_id связь до карточки
     * @apiParam {integer} relation тип связи с карточками (0-родитель, 1-ребенок, 2-брат/сестра, 3-муж/жена)
     *
     */
    public function connect(Request $request): JsonResponse|bool|string
    {
        $fromId = $request->get('from_id');
        $toId = $request->get('to_id');
        $relation = $request->get('relation');

        $userData = NeoUserCard::query()->whereUserId(Auth::user()->id)->first();

        if (!$userData) {
            return $this->error('Данные пользователя не найдены');
        }

        $validator = self::validateObject($fromId, $toId, $relation);

        if(!is_array($validator)) {
            return $validator;
        }

        switch ($relation) {
            case 0:

                $neoCard = NeoCard::query()->create([
                    'name' => "",
                    'no_parent' => true,
                    'hidden' => true,
                ]);

                $validator['fromCard']->parents()->attach($neoCard);
                $validator['toCard']->parents()->attach($neoCard);
                break;
            case  1:

                if ($validator['fromCard']->child && $validator['fromCard']->child->no_parent == true
                    && $validator['fromCard']->child->hidden == true) {
                    $connectTo = $validator['fromCard']->child;
                    $connectToChildren = $validator['fromCard']->children()->get();
                }

                $parentRelatedNode = $validator['fromCard']->parents()->first();

                break;
            case  2:
                $validator['fromCard']->children()->attach($validator['toCard']);
                break;
            case  3:
                $fromExists = $validator['fromCard']->child()->first();
                $toExists = $validator['toCard']->child()->first();

                if ($fromExists && $toExists && $fromExists->id == $toExists->id) {
                    return $this->error('Такая связь уже есть');
                } else {
                    $neoCard = NeoCard::query()->create([
                        'name' => "",
                        'no_parent' => true,
                        'hidden' => true
                    ]);

                    $userData->cards()->attach($neoCard);
                    $neoCard->children()->attach($validator['fromCard']);
                    $neoCard->children()->attach($validator['toCard']);
                }

                break;
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success();
    }

    /**
     * @param Request $request
     * @return JsonResponse|bool|string
     * @throws ValidationException
     * @internal param Request $request
     * @api {POST} /api/object_relations/disconnect Удаление связи
     * @apiGroup Object Relations
     *
     * @apiParam {integer} fromId связь от карточки
     * @apiParam {integer} toId связь до карточки
     * @apiParam {integer} relation тип связи с карточками (0-родитель, 1-ребенок, 2-брат/сестра, 3-муж/жена)
     *
     */
    public function disconnect(Request $request): JsonResponse|bool|string
    {
        $fromId = $request->get('from_id');
        $toId = $request->get('to_id');
        $relation = $request->get('relation');

        $validator = self::validateObject($fromId, $toId, $relation);

        if(!is_array($validator)) {
            return $validator;
        }

        switch ($relation) {
            case 0:
                $validator['fromCard']->parents()->detach($validator['toCard']);
                break;
            case 1:
                $validator['fromCard']->children()->detach($validator['toCard']);
                break;
            case 2:
                $validator['fromCard']->brother_sisters()->detach($validator['toCard']);
                break;
            case 3:
                $validator['fromCard']->wife_husbands()->detach($validator['toCard']);
                break;
        }

        $this->setIsSystem(false);
        $this->createActivity();

        return $this->success();
    }
}