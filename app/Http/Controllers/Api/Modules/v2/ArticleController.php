<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Http\Controllers\Controller;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleStrokeModule;
use App\Models\Section;
use App\Traits\Activity;
use App\Traits\Article as ArticleTrait;
use App\Traits\Media;
use App\Traits\Module;
use Auth;
use Session;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @activity done
     */
    public static $user = null;

    use ArticleTrait;
    use Module;
    use Media;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        $this->setObject(ModuleArticle::class);
        $this->setUserActivity();
    }


    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse|string
     * @api {GET} /api/modules/article/sort Сортировка модуля статей
     * @apiGroup Module articles
     *
     * @apiParam {integer} id ID модуля статьи
     * @apiParam {integer} module_id ID модуля читаемое
     * @apiParam {integer} sort_by сортировка (1 - по кол-ву просмотров, 2 - по рейтингу, 3 - по кол-ву коментариев, 4 - под дате публикации)
     * @piaParam {integer} view вид блока (1 - вертикальный блок, 2 - горизонтальный блок)
     * @apiParam {integer} sort_order сортировка читаемого (1 - по возрастанию, 2 - по убыванию)
     *
     */
    public function sort(Request $request)
    {

        return $this->success();
    }


    /**
     * @param Request $request
     * @return JSON|false|\Illuminate\Http\JsonResponse|string
     * @api {GET} /api/modules/articles/search Поиск раздела для модуля статьи
     * @apiGroup Module articles
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {string} term Строка для поиска
     *
     *
     */
    public function search(Request $request)
    {
        $site = $this->getSite(env('DOMAIN'));

        $term = $request->get('term');

        if ($term) {
            $sections = Section::where('title', 'like', "%$term%")
                ->where('site_id', $site->id)
                ->orderBy('title')->get()
                ->makeHidden(['attached', 'origin', 'last_article_id', 'last_article', 'tags',
                    'subsections_cnt', 'children']);
        } else {
            return $this->error('Не задана строка для поиска...');
        }

        $result = compact('sections');

        return $this->success($result);
    }
}