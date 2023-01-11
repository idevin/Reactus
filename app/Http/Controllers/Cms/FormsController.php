<?php

namespace App\Http\Controllers\Cms;

use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\FieldUserValue;
use App\Models\FieldValue;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\FieldGroup as FieldGroupTrait;
use App\Traits\Site;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class FormsController extends CmsController
{

    public static array $fieldGroups = [
        1 => FieldGroup::class
    ];

    use DomainTrait;
    use Site;
    use CustomValidators;
    use FieldGroupTrait;

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Формы', 'forms.index'];
    }

    /**
     * @return Factory|View
     */
    public function index(): Factory|View
    {
        $title = 'Поля для форм';

        $filter = new CmsFilter(Field::class, 'forms.index');

        $filter->addField('name', 'Имя')
            ->addField('site::domain', 'Сайт')
            ->addField('field_group::name', 'Группа полей')
            ->addButton('Создать', 'forms.create');

        $filter = $filter->render();

        $breadcrumbs = $this->breadcrumbs;

        $fieldGroups = FieldGroup::query();
        $fields = $this->setFields($fieldGroups);

        $groupedFields = [];

        function getName($children, &$name)
        {
            foreach ($children as $child) {

                if (count($child->children) > 0) {
                    $name .= getName($child->children, $name);
                } else {
                    $name .= $child->name;
                }
            }
            return $name;
        }

        foreach ($fields as $fieldGroup) {
            if (count($fieldGroup->fields) > 0) {
                $name = $fieldGroup->name;
                $groupedFields[$fieldGroup->id]['field_group'] = $fieldGroup;
                $groupedFields[$fieldGroup->id]['fields'] = $fieldGroup->fields;
                $groupedFields[$fieldGroup->id]['name'] = getName($fieldGroup->children, $name);
            }
        }

        return view('cms.forms.index',
            compact('fields', 'filter', 'title', 'breadcrumbs', 'groupedFields'));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function create(Request $request): Factory|View
    {
        $title = 'Новое поле';

        $this->breadcrumbs[] = ['Создание поля'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Field();
        $action = 'forms.store';

        $field_groups = FieldGroup::getTree(true);

        $field_types = $this->getFieldTypes();

        return view('cms.forms.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'field_groups', 'field_types'));
    }

    private function getFieldTypes()
    {
        return array_map(function ($data) {
            return $data['name'];
        }, Field::$fieldTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $data = self::getData($inputData);

            $field = Field::query()->firstOrCreate($data);

            self::createFieldValues($inputData, $field);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('forms.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'field_type' => 'required',
            'field_group_id' => 'required'
        ], [
            'name.required' => 'Поле имя обязательно для заполнения',
            'field_type.required' => 'Не выбран тип поля',
            'field_group_id' => 'Выберите группу форм'
        ]);
    }

    #[ArrayShape(['name' => "mixed", 'field_type' => "mixed", 'field_group_id' => "mixed",
        'placeholder' => "mixed", 'required' => "int"])]
    private function getData($inputData)
    {
        return [
            'name' => $inputData['name'],
            'field_type' => $inputData['field_type'],
            'field_group_id' => $inputData['field_group_id'],
            'placeholder' => $inputData['placeholder'],
            'required' => isset($inputData['required']) ? 1 : 0
        ];
    }

    public static function createFieldValues($inputData, $field)
    {
        if (!empty($inputData['values'])) {

            $ids =  Utils::mapIds($inputData['values']);
            FieldValue::whereFieldId($field->id)->whereNotIn('id', $ids)->delete();

            foreach ($inputData['values'] as $value) {
                if (!empty($value['value'])) {
                    $data = [
                        'value' => $value['value'],
                        'sort_order' => $value['sort_order'] ?? null
                    ];

                    if (!empty($value['id'])) {
                        $fieldValue = FieldValue::query()->find($value['id']);
                        $fieldValue?->update($data);
                    } else {
                        $data['field_id'] = $field->id;
                        FieldValue::query()->create($data);
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $title = 'Формы';

        $form = Field::findOrFail($id);
        $this->breadcrumbs[] = ['Редактирование формы'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'forms.update';
        $sites = $this->getSites();

        $field_groups = FieldGroup::getTree(true);

        $field_types = $this->getFieldTypes();
        $field_values = $this->getFieldValues($form);

        return view('cms.forms.edit',
            compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'field_groups', 'field_types', 'field_values'));
    }

    private function getFieldValues($field)
    {
        return $field->field_values->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $field = Field::query()->find($id);

        if (!$field) {
            session()->flash('success', 'Запись не найдена');
            return redirect()->route('forms.index');
        }

        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $data = self::getData($inputData);

            if (!$field) {
                $field = Field::query()->create($data);
            } else {
                $field->update($data);
            }

            self::createFieldValues($inputData, $field);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('forms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        FieldUserValue::where('field_id', $field->id)->delete();
        FieldValue::where('field_id', $field->id)->delete();
        $field->delete();

        session()->flash('success', 'Поле удалено!');

        return redirect()->route('forms.index');
    }
}
