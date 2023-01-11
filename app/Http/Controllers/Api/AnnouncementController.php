<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\BlogArticle;
use App\Models\BlogSection;
use App\Models\Domain;
use App\Models\Section;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Announceable;
use App\Traits\Utils;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCompiler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Route;

/**
 * Class ApiAnnouncement
 * @package App\Http\Controllers\Api
 */
class AnnouncementController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Announcement::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActionsExcluded(['create', 'update', 'delete']);
    }

    public function form()
    {
        return $this->success(['classes' => Announcement::$classesList]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/announcement/create Создание анонса
     * @apiGroup Announcements
     *
     * @apiParam {integer} object_id ID объекта
     * @apiParam {integer} announce_id ID анонса
     * @apiParam {string} object_type Тип объекта
     * @apiParam {string} announce_type Тип анонса
     *
     * @apiParam {string} title название
     * @apiParam {string} description описание
     *
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function create(Request $request): bool|JsonResponse|string
    {
        $requestData = $request->all();
        $validator = $this->validator($requestData);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $site = $this->getSite(env('DOMAIN'));

        $o = app($requestData['object_type'])::bySite($site->id)->find($requestData['object_id']);

        if (!$o) {
            return $this->error(__('announcement.object_not_found'));
        }

        $announce = app($requestData['announce_type'])::query()->find($requestData['announce_id']);

        if (!$announce) {
            return $this->error(__('announcement.not_found'));
        }

        if (!Announcement::hasRelation($o, $announce)) {

            $announcementData = [
                'title' => $requestData['title'],
                'object_type' => $requestData['object_type'],
                'object_id' => $requestData['object_id'],
                'description' => $requestData['description'] ?? null,
                'site_id' => $site->id,
                'announce_type' => $requestData['announce_type'],
                'announce_id' => $requestData['announce_id']
            ];

            $announcement = Announcement::firstOrCreate($announcementData);
        } else {
            return $this->error(__('announcement.exists'));
        }

        $this->setIsSystem(false);
        $this->setParams($announcement->toArray());
        $this->createActivity();

        return $this->success($announcement);
    }

    /**
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {

        if (!empty($data['title'])) {
            $data['title'] = Utils::cleanChars($data['title']);
        }

        if (!empty($data['description'])) {
            $data['description'] = Utils::cleanChars($data['description']);
        }

        return Validator::make($data, [
            'title' => 'required',
            'description' => 'required',
            'object_type' => [
                'required',
                Rule::in(Announcement::$classesList)
            ],
            'object_id' => 'required|numeric',
            'announce_id' => 'required|numeric',
            'announce_type' => [
                'required',
                Rule::in(Announcement::$classesList)
            ]
        ], [
            'title.required' => __('announcement.validation.title'),
            'object_type.required' => __('announcement.validation.object_type'),
            'object_id.required' => __('announcement.validation.object_id'),
            'object_type.in' => __('announcement.validation.object_id', ['objects' => implode(', ', Announcement::$classesList)]),
            'description.required' => __('announcement.validation.description'),
            'announce_id.required' => __('announcement.validation.announce_id'),
            'announce_type.required' => __('announcement.validation.announce_type'),
            'announce_type.in' => __('announcement.validation.object_id', ['objects' => implode(', ', Announcement::$classesList)]),
            'announce_id.numeric' => __('announcement.validation.announce_id_int'),
            'object_id.numeric' => __('announcement.validation.object_id_int'),
        ]);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/announcement/search Поиск по анонсу
     * @apiGroup Announcements
     *
     * @apiParam {string} object_type Тип обьекта
     * @apiParam {string} term строка поиска
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function search(Request $request): bool|JsonResponse|string
    {
        $requestData = $request->all();

        $validator = Validator::make($requestData, [
            'object_type' => [
                'required',
                Rule::in(Announcement::$classesList)
            ],
            'term' => 'required|min:3'
        ], [
            'object_type.required' => __('announcement.validation.object_type'),
            'term.required' => __('announcement.validation.term'),
            'object_type.in' => __('announcement.validation.objects', ['objects' => implode(', ', Announcement::$classesList)]),
            'term.min' => _('announcement.validation.term_min')
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $foundByUrl = null;

        $url = parse_url($requestData['term']);

        if (isset($url['host']) && isset($url['path'])) {
            $matchedRoute = null;
            $matchedMatch = null;
            $routes = Route::getRoutes()->getRoutes();

            foreach ($routes as $route) {
                $route->compiled = (new RouteCompiler($route))->compile();

                if (is_null($route->getCompiled())) {
                    continue;
                }

                preg_match($route->getCompiled()->getRegex(), rawurldecode($url['path']), $matches);

                if (!empty($matches)) {
                    $matchedRoute = $route;

                    foreach ($matches as $i => $match) {
                        if (is_numeric($i)) {
                            unset($matches[$i]);
                        }
                        if ($match == $url['path']) {
                            unset($matches[$i]);
                        }
                    }

                    $matchedMatch = $matches;
                }
            }

            if ($matchedRoute) {
                list($controller, $action) = explode('@', $matchedRoute->getActionName());
                if ($controller && $action) {
                    $method = 'url' . last(preg_split('/\\\/', $controller));
                    $foundByUrl = Announceable::{$method . ucfirst($action)}($matchedMatch);
                }
            }
        }

        if ($foundByUrl) {
            $data = collect();
            $data[] = app($foundByUrl['announce_type'])->query()->find($foundByUrl['announce_id']);
        } else {
            $data = $this->searchForAnnouncement($requestData);
        }

        return $this->success($data);
    }

    private function searchForAnnouncement($requestData)
    {
        $method = lcfirst(str_replace('\\', '', $requestData['object_type']));

        return $this->$method($requestData['term']);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();

        $this->setIsSystem(false);
        $this->setParams($data);
        $this->createActivity();

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/announcement/delete Удаление анонса
     * @apiGroup Announcements
     *
     * @apiParam {integer} id ID анонса (не обязательно)
     *
     * @apiParam {string} object_type Тип обьекта
     * @apiParam {integer} object_id ID обьекта
     * @apiParam {string} announce_type Тип анонса
     * @apiParam {integer} announce_id ID анонса
     *
     * @apiParam {string} token Ключ пользователя
     */
    public function delete(Request $request): bool|JsonResponse|string
    {
        $id = $request->get('id');
        $announceId = $request->get('announce_id');
        $site = get_site();

        if ($announceId) {
            /**
             * Удаление нескольких записей
             */
            $announces = Announcement::query()->bySite($site->id)->whereAnnounceId($announceId)->get();

            if (count($announces) > 0) {
                $this->setIsSystem(false);
                $this->setParams($announces->all());
                $this->createActivity();

                $announces->map(function ($announce) {
                    $announce->delete();
                });
            } else {
                return $this->error(__('announcement.not_found'));
            }
        } elseif ($id) {
            /**
             * Удаление одной записи
             */
            $announce = Announcement::query()->bySite($site->id)->whereId($id)->first();

            if ($announce) {
                $this->setIsSystem(false);
                $this->setParams($announce->toArray());
                $this->createActivity();
                $announce->delete();
            } else {
                return $this->error(__('announcement.not_found'));
            }

        } else {
            return $this->error(__('announcement.params_required'));
        }

        return $this->success();
    }

    /**
     * @param $term
     * @return mixed
     */
    private function appModelsArticle($term): mixed
    {
        return $this->getSearchArticle($term, Article::class);
    }

    public function getSearchArticle($term, $articleclass)
    {
        $term = self::getTerm($term);

        $data = $articleclass::query()->published()->active()
            ->where(function ($query) use ($term) {
                $query->where('title', 'like', $term);
            })->get();

        if (count($data) > 0) {
            $data = $this->filterByDomain($data);
        }

        return $data;
    }

    public static function getTerm($term): string
    {
        return '%' . htmlspecialchars($term) . '%';
    }

    public function filterByDomain($data)
    {
        $data = $data->filter(function ($item) {
            if ($item->site && $item->site->siteDomain->domain_type == Domain::DOMAIN_TYPE_THEMATIC &&
                $item->site->siteDomain->active == 1) {
                return true;
            }
            return false;
        });
        return $data->values();
    }

    /**
     * @param $term
     * @return mixed
     */
    private function appModelsBlogArticle($term): mixed
    {
        return $this->getSearchArticle($term, BlogArticle::class);
    }

    /**
     * @param $term
     * @return mixed
     */
    private function appModelsSection($term): mixed
    {
        return $this->getSearchSection($term, Section::class);
    }

    private function getSearchSection($term, $sectionClass)
    {
        $term = self::getTerm($term);

        $data = $sectionClass::query()->where(function ($query) use ($term) {
            $query->where('title', 'like', $term);
        })->get();

        if (count($data) > 0) {
            $data = $this->filterByDomain($data);
        }

        return $data;
    }

    /**
     * @param $term
     * @return mixed
     */
    private function appModelsBlogSection($term): mixed
    {
        return $this->getSearchSection($term, BlogSection::class);
    }

    private function appModelsNeoCard($term): array
    {
        return [];
    }
}