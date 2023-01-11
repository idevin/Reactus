<?php

namespace App\Http\Controllers\Cms;

use App\Models\Neo4j;
use App\Models\NeoCatalogFieldGroup;
use App\Models\ObjectFieldGroup;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use App\Utils\Sorter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class ObjectFieldGroupsController extends CmsController
{
    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Группы полей каталога', 'object_field_groups.index'];
    }

    #[ArrayShape(['title' => "mixed", 'description' => "mixed", 'sort_order' => "int"])]
    public static function getData(array $inputData): array
    {
        return [
            'title' => $inputData['title'],
            'description' => $inputData['description'],
            'sort_order' => (int)$inputData['sort_order']
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $title = 'Поля';

        $breadcrumbs = $this->breadcrumbs;

        $fields = NeoCatalogFieldGroup::query()->orderBy('sort', 'desc')->where('field_group_id', null);
        Sorter::setOrder($fields, 'ord');

        $iPaginationPerPage = Sorter::getPerPage('limit', 100);
        $fields = $fields->paginate($iPaginationPerPage);

        $filter = new CmsFilter(NeoCatalogFieldGroup::class, 'object_field_groups.index');

        $filter->addButton('Создать', 'object_field_groups.create');

        $filter = $filter->render();

        return view('cms.object_field_groups.index',
            compact('fields', 'title', 'breadcrumbs', 'filter'));
    }

    public function updateTree(Request $request)
    {
        parent::saveTree($request, ObjectFieldGroup::class);
        session()->flash('success', 'Запись сохранена');
        return redirect()->route('object_field_groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $title = 'Новая группа полей';

        $this->breadcrumbs[] = ['Создание'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new NeoCatalogFieldGroup();
        $action = 'object_field_groups.store';
        $oFieldGroups = NeoCatalogFieldGroup::query()->where('user_id', null)->orderBy('id', 'desc')->get();

        return view('cms.object_field_groups.new_form', compact('form', 'title',
            'breadcrumbs', 'action', 'oFieldGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $data = self::getData($inputData);

            NeoCatalogFieldGroup::query()->firstOrCreate($data);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('object_field_groups.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'title' => 'required',
            'description' => 'required'
        ], [
            'title.required' => 'Название обязательно для заполнения',
            'description.required' => 'Описание обязательно для заполнения',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $title = 'Группа полей';

        $form = NeoCatalogFieldGroup::query()->find($id);
        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'object_field_groups.update';

        $oFieldGroups = NeoCatalogFieldGroup::query()->where('user_id', null)->orderBy('id', 'desc')->get();

        return view('cms.object_field_groups.edit', compact('form', 'title',
            'breadcrumbs', 'action', 'oFieldGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $fieldGroup = NeoCatalogFieldGroup::query()->find($id);

            $data = self::getData($inputData);

            $fieldGroup->update($data);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('object_field_groups.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $fieldGroup = NeoCatalogFieldGroup::query()->find($id);

        if ($fieldGroup) {
            Neo4j::client()->run("MATCH (n:FieldGroup) WHERE ID(n)={$fieldGroup->id} DETACH DELETE n");
        }

        session()->flash('success', 'Запись удалена!');

        return redirect()->route('object_field_groups.index');
    }
}
