<?php namespace App\Http\Controllers\Api\Modules\v2;

use App\Cacher\Collection\ModuleCompAdvantagesCollection;
use App\Cacher\Item\ModuleCompAdvantagesItem;
use App\Http\Controllers\Controller;
use App\Models\Modules\ModuleCompetitiveAdvantages;
use App\Models\Modules\ModuleCompetitiveAdvantagesItems;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Media;
use App\Traits\Module;
use App\Traits\Utils;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Session;

class CompetitiveAdvantagesController extends Controller
{
    /**
     * @activiy done
     */
    public static User|null $user = null;

    use Module;
    use Media;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        Session::forget('site');

        $this->setObject(ModuleCompetitiveAdvantages::class);
        $this->setUserActivity();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws ValidationException
     * @api {POST} /api/modules/v2/competitive-advantages/items/delete Удаление преймуществ (v2)
     * @apiGroup Module Competitive Advantages
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} advantages_id ID модуля преймуществ
     * @apiParam {integer} ids ID блоков в модуле
     */
    public function delete(Request $request): bool|JsonResponse|string
    {
        $data = $request->all();
        $result = $this->validateAdvantages($data);

        if (get_class($result) !== ModuleCompetitiveAdvantages::class) {
            return $result;
        }

        $result->items()->whereIn('id', $data['ids'])->delete();

        return $this->success();
    }

    public function validateAdvantages(array $data):
    Model|Collection|Builder|JsonResponse|bool|array|string|ModuleCompetitiveAdvantages
    {
        if (empty($data['advantages_id'])) {
            return $this->error('Не задан ID модуля (advantages_id)');
        }

        if (empty($data['ids']) || !is_array($data['ids'])) {
            return $this->error('Не заданы ID преймущества (ids)');
        }

        $advantages = ModuleCompetitiveAdvantages::query()->find($data['advantages_id']);

        if (!$advantages) {
            return $this->error('Модуль не найден');
        }

        return $advantages;
    }

    /**
     * @param Request $request
     * @return Model|Collection|Builder|JsonResponse|bool|array|string|ModuleCompetitiveAdvantages
     * @api {POST} /api/modules/v2/competitive-advantages/items/copy Копирование преймуществ (v2)
     * @apiGroup Module Competitive Advantages
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} advantages_id ID модуля преймуществ
     * @apiParam {integer} ids ID блоков в модуле
     */
    public function copy(Request $request):
    Model|Collection|Builder|JsonResponse|bool|array|string|ModuleCompetitiveAdvantages
    {
        $data = $request->all();
        $result = $this->validateAdvantages($data);

        if (get_class($result) !== ModuleCompetitiveAdvantages::class) {
            return $result;
        }

        $items = $result->items()->whereIn('id', $data['ids'])->orderBy('sort_order', 'asc')
            ->get()->makeHidden('id');

        $result->items()->insert($items->toArray());
        $items = $result->items()->get();

        $items = Utils::updateSortOrder($items);

        return $this->success($items);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception|Exception
     * @api {POST} /api/modules/v2/competitive-advantages/items/add_or_update Создание обновление преймущества (v2)
     * @apiGroup Module Competitive Advantages
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} advantages_id ID модуля преймуществ
     * @apiParam {integer} id ID блока в модуле (без ID создание, с ID обновление)
     * @apiParam {string} content_options опции контента
     * @apiParam {string} name имя блока
     * @apiParam {string} description описание
     * @apiParam {integer} sort_order номер по порядку
     */
    public function addOrUpdate(Request $request)
    {
        $data = $request->all();

        if (empty($data['advantages_id'])) {
            return $this->error('Не задан ID модуля (advantages_id)');
        }

        $advantages = ModuleCompetitiveAdvantages::query()->find($data['advantages_id']);

        if (!$advantages) {
            return $this->error('Модуль не найден');
        }

        $itemData = [
            "content_options" => $data['content_options'] ?? null,
            "name" => $data['name'] ?? null,
            "description" => $data['description'] ?? null,
            "advantages_id" => $advantages->id,
            "sort_order" => $data['sort_order'] ?? 1
        ];

        if (!isset($data['id'])) {
            $compItem = ModuleCompetitiveAdvantagesItems::create($itemData);
        } else {
            $compItem = $advantages->items()->find($data['id']);

            if ($compItem) {
                $compItem->update($itemData);
                $compItem->refresh();
            } else {
                return $this->error('Не удалось обновить блок');
            }
        }

        return $this->success($compItem);
    }
}