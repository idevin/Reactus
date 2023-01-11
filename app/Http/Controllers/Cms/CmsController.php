<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Section;
use App\Utils\Tree;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use LogicException;
use Session;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public static string $orderField = 'id';
    public static string $orderDirection = 'desc';
    public static int $limit = 100;
    public array $breadcrumbs = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function setBreadcrumb($class)
    {
        $parts = preg_split('#\\\#', $class);
        $controller = last($parts);
        $name = str_replace('Controller', '', $controller);
        $name = Str::snake($name);

        $this->breadcrumbs[] = [trans($name), strtolower($name) . '.index'];
    }

    public function saveTree(Request $request, $modelClass): bool|Redirector|RedirectResponse|Application
    {
        $inputData = $request->all();

        if (!empty($inputData['items'])) {
            $json = json_decode($inputData['items'], true);
        } else {
            return redirect(route('sites.index'));
        }

        (new Tree($modelClass, $json))->update();

        return true;
    }


    /**
     * @return Factory|View
     * @internal param Request|\Symfony\Component\HttpFoundation\Request $request
     */
    public function index()
    {
        $site = $this->getSite(env('DOMAIN'));

        $commentsCount = $site->comments->count();
        $sectionsCount = Section::bySite($site->id)->count();
        $articlesCount = Article::bySite($site->id)->count();

        return view('cms.index', compact('commentsCount', 'site', 'sectionsCount', 'articlesCount'));
    }

    public function setOrderBy($request = null)
    {
        if (isset($request['ord'])) {

            self::$orderField = preg_replace('#[^a-z_\.]#', '', $request['ord']);

            if (!strstr($request['ord'], '-')) {
                self::$orderDirection = 'asc';
            } else {
                self::$orderDirection = 'desc';
            }
        }
    }

    public function redirectToSites($text = null)
    {
        if ($text == null) {
            $text = 'Сначала добавьте сайт';
        }

        Session::flash('error', $text);
        return redirect(route('sites.index'));
    }

    public function setFields($model, $limit =  Article::defaultLimit)
    {
        $request = request()->all();

        $this->setOrderBy($request);

        if (isset($request['limit'])) {
            $limit = (int)$request['limit'];
            if ($limit > 0 && in_array($limit, Article::$adminLimits)) {
                self::$limit = $request['limit'];
            }
        }

        $model = $model->orderBy(self::$orderField, self::$orderDirection);

        if (!empty($request['search'])) {
            $requestData = collect($request)->except(['search', 'page', 'limit', 'ord'])->toArray();

            $modelTable = $model->getModel()->getTable();
            $modelDb = $model->getConnection()->getConfig('database');

            foreach ($requestData as $field => $searchValue) {

                if (!empty($searchValue)) {

                    if (strstr($field, '::')) {
                        $relationFields = preg_split('/::/', $field);
                        $attribute = $relationFields[count($relationFields) - 1];

                        for ($i = 0; $i < count($relationFields) - 1; $i++) {
                            $alias = null;
                            $localModel = null;
                            $foreignModel = ucfirst(Str::camel($relationFields[$i]));
                            if (preg_match('/\|/', $foreignModel)) {
                                list($localModel, $alias) = preg_split('/\|/', $foreignModel);
                                $foreignModel = $localModel;
                            }

                            $foreignModel = '\\App\\Models\\' . $foreignModel;
                            $db = (new $foreignModel)->getConnection()->getConfig('database');

                            if ($alias) {
                                $join = $alias;
                                $innerKey = strtolower($localModel);
                                $searchKey = $alias;
                                $otherJoin = $alias;
                                $select = $alias;
                            } else {
                                $join = $relationFields[$i];
                                $innerKey = $relationFields[$i];
                                $searchKey = $relationFields[$i];
                                $otherJoin = $relationFields[$i];
                                $select = $relationFields[$i];
                            }

                            $model = $model->join($db . '.' . $join,
                                $modelDb . '.' . $modelTable . '.' . $innerKey . '_id', '=', $db .
                                '.' . $otherJoin . '.id');

                            if (strstr($attribute, ',')) {
                                $attributesSelect = null;
                                $attributes = preg_split('/\,/', $attribute);

                                foreach ($attributes as $v) {
                                    $attributesSelect[] = $db . '.' . $select . '.' . $v;
                                }
                                $attributesSelect[] = $modelTable . '.*';


                                $where = function ($query) use ($db, $searchKey, $attributes, $searchValue) {
                                    foreach ($attributes as $a) {
                                        $query = $query->orWhere($db . '.' . $searchKey . '.' . $a, 'like', '%' . $searchValue . '%');
                                    }
                                    return $query;
                                };

                            } else {
                                $attributesSelect = [$db . '.' . $select . '.' . $attribute, $modelTable . '.*'];
                                $where = function ($query) use ($db, $searchKey, $attribute, $searchValue) {
                                    return $query->where($db . '.' . $searchKey . '.' . $attribute, 'like', '%' . $searchValue . '%');
                                };
                            }

                            $model = $model->select($attributesSelect)->where($where);
                        }
                    }

                    if ($field != 'created_at' && !strstr($field, '::')) {
                        $model = $model->where($field, 'like', '%' . $searchValue . '%');
                    }

                    if ($field == 'created_at') {
                        $from = date('Y-m-d H:i:s',
                            strtotime(str_replace('-', '/', $searchValue['from'])));

                        $to = date('Y-m-d 23:59:59',
                            strtotime(str_replace('-', '/', $searchValue['to'])));

                        if (!empty($searchValue['from']) && empty($searchValue['to'])) {
                            $model = $model->where($modelTable . '.' . $field, '>=', $from);
                        }

                        if (!empty($searchValue['to']) && empty($searchValue['from'])) {
                            $model = $model->where($modelTable . '.' . $field, '<=', $to);
                        }

                        if (!empty($searchValue['from']) && !empty($searchValue['to'])) {

                            if ($searchValue['from'] == $searchValue['to']) {
                                $to = date('Y-m-d 23:59:59',
                                    strtotime(str_replace('-', '/', $searchValue['to'])));
                            }

                            $model = $model->where(function ($query) use ($from, $to, $modelTable, $field) {
                                $query->where($modelTable . '.' . $field, '>=', $from)
                                    ->where($modelTable . '.' . $field, '<=', $to);
                            });
                        }
                    }

                    $appends[$field] = $searchValue;
                }
            }
        }
        $page = isset($request['page']) ? $request['page'] : 1;
        $limit = isset($request['limit']) ? (int)$request['limit'] : $limit;

        if ($limit == $page * Article::defaultLimit) {
            self::setPageResolver($page);
        }

        if (($model->count() <= self::$limit)) {
            self::$limit = $model->count();
            self::setPageResolver(1);
        }

        $appends = [
            'page' => (int)$page,
            'search' => isset($request['search']) ? 1 : null,
            'limit' => (int)$limit,
            'ord' => isset($request['ord']) ? $request['ord'] : null
        ];

        $appends = array_merge($appends, $request);

        $model = $model->paginate((int)self::$limit)->appends($appends);

        return $model;
    }

    protected static function setPageResolver($page)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
    }
}
