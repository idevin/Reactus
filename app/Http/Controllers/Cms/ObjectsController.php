<?php

namespace App\Http\Controllers\Cms;

use App\Models\Neo4j;
use App\Models\NeoCatalog;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use App\Utils\Sorter;
use Everyman\Neo4j\Client;
use Everyman\Neo4j\Cypher\Query;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Validator;

class ObjectsController extends CmsController
{
    use DomainTrait;
    use Media;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Обьекты', 'objects.index'];
    }

    public function relations(): array
    {
        $neo4jClient = config('database.connections.neo4j');
        $connectionString = $neo4jClient['username'] . ':' . $neo4jClient['password'] . '@' . $neo4jClient['host'];

        $neo4j = new Client($connectionString, $neo4jClient['port']);

        $app = function () use ($neo4j) {
            $nodes = array();
            $edges = array();
            $cypher = new Query($neo4j, 'MATCH (p:Object) RETURN p');
            $result = $cypher->getResultSet();

            foreach ($result as $row) {

                $data = $row['data']->getProperties();

                $nodes[] = [
                    'id' => $row['data']->getId(),
                    'label' => $data['name']
                ];
            }

            $cypher = new Query($neo4j, 'MATCH (a)-[:HAS]->(b) RETURN a, b');
            $result = $cypher->getResultSet();
            $id = 1;

            foreach ($result as $row) {
                $edges[] = [
                    'id' => 'e' . $id++,
                    'source' => $row['b']->getId(),
                    'target' => $row['a']->getId(),
                    'label' => ''
                ];
            }
            return ['nodes' => $nodes, 'edges' => $edges];
        };

        return $app();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index(): Factory|Response|View|Application
    {
        $title = 'Прототипы каталогов';

        $breadcrumbs = $this->breadcrumbs;

        $fields = NeoCatalog::query();
        Sorter::setOrder($fields, 'ord');

        $perPage = Sorter::getPerPage('limit', 100);
        $fields = $fields->paginate($perPage);

        $filter = new CmsFilter(NeoCatalog::class, 'objects.index');

        $filter->addButton('Создать', 'objects.create');

        $filter = $filter->render();

        return view('cms.objects.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $objectFound = NeoCatalog::query()->whereAlias(NeoCatalog::getAlias($inputData['name']))->first();

            if ($objectFound) {
                return redirect()->back()->withInput($inputData)->withErrors('Такой каталог уже есть');
            }

            unset($inputData['_token']);

            try {
                NeoCatalog::query()->firstOrCreate($inputData);
            } catch (Exception $e) {

                return redirect()->back()->withInput($inputData)->withErrors($e->getData()['message']);
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('objects.index');
        }
    }

    public static function getValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Напишите название',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Application|Factory|Response|View
     */
    public function edit(int $id): Factory|Response|View|Application
    {
        $title = 'Редактирование';

        $form = NeoCatalog::query()->findOrFail($id);

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'objects.update';

        return view('cms.objects.edit', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function create(Request $request): Factory|Response|View|Application
    {
        $title = 'Создать прототип каталога';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new NeoCatalog();
        $action = 'objects.store';

        return view('cms.objects.new_form', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $object = NeoCatalog::query()->findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $alias = NeoCatalog::getAlias(trim($object->name));

            $objectFound = NeoCatalog::query()->whereAlias($alias)->where('id', '<>', $id)->first();

            if ($objectFound) {
                return redirect()->back()->withInput($inputData)->withErrors('Такой каталог уже есть');
            }

            unset($inputData['_token']);

            $object->update($inputData);

            session()->flash('success', 'Запись сохранена');
            return redirect()->route('objects.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $object = NeoCatalog::query()->find($id);

        if ($object) {
           Neo4j::client()->run("MATCH (n:Catalog) WHERE ID(n)={$object->id} DETACH DELETE n");
        }

        session()->flash('success', 'Записи удалены!');

        return redirect()->route('objects.index');
    }

    public function updateNode(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData, ['alias'], ['id' => 'required'],
            ['id.required' => 'Не задан ID']);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $object = NeoCatalog::whereId($inputData['id'])->first();

            if ($object) {
                $inputData['alias'] = slugify($inputData['name']);
                $object->update($inputData);
            } else {
                return redirect()->back()->withInput($inputData)->withErrors('Обьект не найден');
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('objects.index');
        }
    }
}
