<?php

namespace App\Http\Controllers\Cms;

use App\Models\FieldGroup;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class FormGroupsController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Группы форм', 'form_groups.index'];
    }

    /**
     * @return Factory|View|\Illuminate\View\View|Application
     */
    public function index(): Factory|View|\Illuminate\View\View|Application
    {
        $title = 'Группы для форм';

        $filter = new CmsFilter(FieldGroup::class, 'form_groups.index');

        $filter = $filter->addField('name', 'Название')
            ->addButton('Создать', 'form_groups.create')->render();

        $field = FieldGroup::query();
        $fields = $this->setFields($field);

        $breadcrumbs = $this->breadcrumbs;

        FieldGroup::rebuild();
        $treeData = FieldGroup::get()->toHierarchy();

        return view('cms.form_groups.index',
            compact('fields', 'filter', 'title', 'breadcrumbs', 'treeData'));
    }

    public function updateTree(Request $request)
    {
        parent::saveTree($request, FieldGroup::class);
        session()->flash('success', 'Запись сохранена');
        return redirect()->route('form_groups.index');
    }

    public function create(): Factory|View|Application
    {
        $title = 'Новая группа полей';

        $this->breadcrumbs[] = ['Создание'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new FieldGroup();
        $action = 'form_groups.store';

        return view('cms.form_groups.new_form', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
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

            FieldGroup::query()->create(self::getData($inputData));

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('form_groups.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $title = 'Группа полей';

        $form = FieldGroup::query()->find($id);
        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'form_groups.update';

        return view('cms.form_groups.edit', compact('form', 'title', 'breadcrumbs', 'action'));
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

        if($inputData['parent_id'] == $id) {
            $validator->errors()->add('name', 'Группа форм ссылается на саму же себя');
        }

        if ($validator->errors()->count() > 0) {
            return redirect()->back()->withInput($inputData)->withErrors($validator->errors());
        } else {

            $fieldGroup = FieldGroup::query()->find($id);

            $fieldGroup->update(self::getData($inputData));

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('form_groups.index');
        }
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $field = FieldGroup::query()->findOrFail($id);
        $field->delete();

        session()->flash('success', 'Запись удалена!');

        return redirect()->route('form_groups.index');
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'name' => 'required'
        ]);
    }

    #[ArrayShape(['name' => "mixed", 'multi_field' => "int", 'parent_id' => "int|null", 'for_module' => "int"])]
    public static function getData($inputData): array
    {
        return [
            'name' => $inputData['name'],
            'multi_field' => isset($inputData['multi_field']) ? (int)$inputData['multi_field'] : 0,
            'parent_id' => !empty($inputData['parent_id']) ? (int)$inputData['parent_id'] : null,
            'for_module' => isset($inputData['for_module']) ? 1 : 0
        ];
    }
}
