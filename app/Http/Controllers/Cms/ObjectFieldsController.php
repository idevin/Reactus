<?php

namespace App\Http\Controllers\Cms;

use App\Models\FieldGroup;
use App\Models\Neo4j;
use App\Models\NeoCatalog;
use App\Models\NeoCatalogField;
use App\Models\NeoCatalogFieldGroup;
use App\Models\NeoCatalogFieldValue;
use App\Models\ObjectField;
use App\Models\ObjectFieldValue;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use App\Utils\Sorter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Validator;

class ObjectFieldsController extends CmsController
{
    use Site;

    public static array $fieldGroups = [
        1 => FieldGroup::class
    ];

    public static array $validateNodes = [
        ObjectField::FIELD_TYPE_MULTISELECT,
        ObjectField::FIELD_TYPE_SELECT,
        ObjectField::FIELD_TYPE_RADIO
    ];

    use DomainTrait;
    use Site;
    use CustomValidators;
    use Utils;

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Поля каталогов', 'object_fields.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(): View|Factory|Application
    {
        $title = 'Поля';

        $filter = new CmsFilter(NeoCatalogField::class, 'object_fields.index');

        $filter->addButton('Создать', 'object_fields.create');

        $filter = $filter->render();

        $breadcrumbs = $this->breadcrumbs;

        $fieldGroups = NeoCatalogFieldGroup::query()->orderBy('sort')->with('fields');
        Sorter::setOrder($fieldGroups, 'ord');

        $perPage = Sorter::getPerPage('limit', 100);
        $fieldGroups = $fieldGroups->paginate($perPage);

        $fieldGroups = Utils::transformUrl($fieldGroups);

        $groupedFields = [];

        function getName($children, &$name)
        {
            foreach ($children as $child) {

                if (count($child->children) > 0) {
                    $name .= getName($child->children, $name);
                } else {
                    $name .= $child->title;
                }
            }

            return $name;
        }

        foreach ($fieldGroups as $fieldGroup) {

            if ($fieldGroup->fields && count($fieldGroup->fields) > 0) {
                $title = $fieldGroup->title;
                $groupedFields[$fieldGroup->id]['field_group'] = $fieldGroup;
                $groupedFields[$fieldGroup->id]['fields'] = $fieldGroup->fields->sortBy('sort_order');
                $groupedFields[$fieldGroup->id]['title'] = $title;
            }
        }

        $fields = $fieldGroups;

        return view('cms.object_fields.index', compact('fields', 'filter', 'title', 'breadcrumbs', 'groupedFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request): View|Factory|Application
    {
        $title = 'Новое поле';

        $this->breadcrumbs[] = ['Создание поля'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new NeoCatalogField();
        $action = 'object_fields.store';

        $field_types = $this->getFieldTypes();
        $session = $request->getSession()->all();

        $fieldGroups = NeoCatalogFieldGroup::query()->where('field_group_id', null)->orderBy('id', 'desc')->get();

        $field_groups = NeoCatalogFieldGroup::getTree($fieldGroups);

        $catalogs = NeoCatalog::query()->orderBy('alias')->get();

        if (!empty($catalogs)) {
            $catalogs = $catalogs->pluck('name', 'id')->toArray();
        }

        $oldInput = $session['_old_input'] ?? null;
        $validateNodes = self::$validateNodes;
        $relations = $this->relations();

        $feedbackGroups = FieldGroup::whereForModule(1)->get();
        $feedbackSelect = [null => 'Выберите форму обратной связи...'];

        if (count($feedbackGroups) > 0) {
            $feedbackSelect = array_merge($feedbackSelect, $feedbackGroups->pluck('name', 'id')->toArray());
        }

        $field_values = collect();

        return view('cms.object_fields.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'field_types', 'oldInput', 'field_values',
                'validateNodes', 'field_groups', 'relations', 'feedbackSelect', 'catalogs'));
    }

    private function getFieldTypes(): array
    {
        return collect(NeoCatalogField::$fieldTypes)->sortBy('name')->pluck('name', 'id')->toArray();
    }

    public function relations(): array
    {
        return NeoCatalog::query()->orderBy('alias')->get()->pluck('name', 'id')->toArray();
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

        $customErrors = [];
        $customMessages = [];

        $validator = static::getValidator($inputData, [], $customErrors, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $data = [
                'name' => $inputData['name'],
                'field_type' => $inputData['field_type'],
                'placeholder' => $inputData['placeholder'],
                'required' => isset($inputData['required']) ? 1 : 0,
                'use_in_filter' => isset($inputData['use_in_filter']) ? 1 : 0,
                'use_in_catalog_list' => isset($inputData['use_in_catalog_list']) ? 1 : 0,
                'alias' => !empty(trim($inputData['alias'])) ? $inputData['alias'] : md5(time()),
                'sort_order' => (int)$inputData['sort_order'],
            ];

            $field = NeoCatalogField::query()->create($data);

            self::createFieldValues($inputData, $field);

            $fieldGroup = NeoCatalogFieldGroup::query()->find($inputData['field_group_id']);

            if ($fieldGroup) {
                $found = $fieldGroup->fields()->find($field->id);

                if (!$found) {
                    $fieldGroup->fields()->attach($field);
                }
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('object_fields.index');
        }
    }

    public static function getValidator(&$data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'name' => 'required',
            'field_type' => 'required',
            'field_group_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Поле имя обязательно для заполнения',
            'field_type.required' => 'Не выбран тип поля',
            'field_group_id.required' => 'Выберите группу полей'
        ];

        $default = array_merge($default, $customErrors);
        $messages = array_merge($messages, $customMessages);

        $rules = collect($default)->except($except)->toArray();

        return Validator::make($data, $rules, $messages);
    }

    public static function createFieldValues($inputData, $field)
    {
        $inputData['values'] = array_filter($inputData['values']);

        if (!empty($inputData['values'])) {

            if($field->field_type != $inputData['field_type']) {
                $query = "MATCH (n:Field), (field)-[r:RELATED]->(m:Value) 
                WHERE id(n) = {$field->id} DELETE r,m";

                Neo4j::client()->run($query);
            }

            $ids = Utils::mapIds($inputData['values']);

            if (!empty($ids)) {
                $idStr = '[' . implode(',', $ids) . ']';

                $query = "MATCH (n:Field), (field)-[r:RELATED]->(m:Value) 
                WHERE id(n) = {$field->id} and NOT id(m) IN {$idStr} DELETE r,m";

                Neo4j::client()->run($query);
            }

            foreach ($inputData['values'] as $value) {
                if (!empty($value['value'])) {

                    $data = [
                        'value' => $value['value'],
                        'sort_order' => isset($value['sort_order']) ? (int)$value['sort_order'] : 0
                    ];

                    if (!empty($value['id'])) {
                        $fieldValue = NeoCatalogFieldValue::query()->find($value['id']);
                        $fieldValue?->update($data);
                    } else {
                        $fieldValue = NeoCatalogFieldValue::query()->create($data);
                        $field->values()->attach($fieldValue);
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
     * @return \Illuminate\Contracts\View\View|Application|Factory
     */
    public function edit(int $id): Application|Factory|\Illuminate\Contracts\View\View
    {
        $title = 'Редактирование поля';

        $form = NeoCatalogField::query()->find($id);
        $this->breadcrumbs[] = ['Редактирование поля'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'object_fields.update';

        $field_types = $this->getFieldTypes();
        $session = request()->getSession()->all();
        $oldInput = $session['_old_input'] ?? null;
        $validateNodes = self::$validateNodes;

        $fields = NeoCatalogFieldGroup::query()->orderBy('id', 'desc')->get();

        $field_groups = NeoCatalogFieldGroup::getTree($fields);

        $relations = $this->relations();

        $nodes = null;

        if (!empty($form->value) && $form->field_type['id'] == NeoCatalogField::FIELD_TYPE_RANGE) {
            $nodes = json_decode($form->value);
        }

        if (!empty($form->value) && $form->field_type['id'] == NeoCatalogField::FIELD_TYPE_DATE_PERIOD) {
            $value = json_decode($form->value);
            $form->dates0 = $value[0];
            $form->dates1 = $value[1];
        }

        $feedbackGroups = FieldGroup::whereForModule(1)->get();
        $feedbackSelect = [null => 'Выберите форму обратной связи...'];

        if (count($feedbackGroups) > 0) {
            $feedbackSelect = array_merge($feedbackSelect, $feedbackGroups->pluck('name', 'id')->toArray());
        }

        $catalogs = NeoCatalog::query()->orderBy('alias')->get();

        if (!empty($catalogs)) {
            $catalogs = $catalogs->pluck('name', 'id')->toArray();
        }

        $field_values = $form->values;

        return view('cms.object_fields.edit', compact('form', 'title', 'breadcrumbs', 'action', 'field_values',
            'field_groups', 'field_types', 'oldInput', 'validateNodes', 'relations', 'nodes', 'feedbackSelect', 'catalogs'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $inputData = $request->all();

        $field = NeoCatalogField::query()->find($id);

        if (!$field) {
            session()->flash('success', 'Запись не найдена');
            return redirect()->route('object_fields.index');
        }

        $customErrors = [];
        $customMessages = [];

        $validator = static::getValidator($inputData, [], $customErrors, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $data = [
                'name' => $inputData['name'],
                'field_type' => $inputData['field_type'],
                'placeholder' => $inputData['placeholder'],
                'required' => isset($inputData['required']) ? 1 : 0,
                'use_in_filter' => isset($inputData['use_in_filter']) ? 1 : 0,
                'use_in_catalog_list' => isset($inputData['use_in_catalog_list']) ? 1 : 0,
                'alias' => !empty(trim($inputData['alias'])) ? $inputData['alias'] : md5(time()),
                'sort_order' => (int)$inputData['sort_order']
            ];

            self::createFieldValues($inputData, $field);

            if ($field->fieldGroup && $field->fieldGroup->id != (int)$inputData['field_group_id']) {

                $objectFieldGroup = NeoCatalogFieldGroup::query()
                    ->find((int)$inputData['field_group_id']);

                $oldObjectFieldGroup = $field->fieldGroup;

                if ($objectFieldGroup) {
                    $oldObjectFieldGroup->fields()->detach($field);
                    $objectFieldGroup->fields()->attach($field);
                }
            }

            $field->update($data);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('object_fields.index');
    }

    public function destroy($id): RedirectResponse
    {
        $field = NeoCatalogField::query()->find($id);

        if ($field) {
            Neo4j::client()->run("OPTIONAL MATCH (n:Field)--(r) WHERE ID(n)={$field->id} DETACH DELETE r, n");
        }

        $field->delete();

        session()->flash('success', 'Поле удалено!');

        return redirect()->route('object_fields.index');
    }

    private function getSites()
    {
        $sites = [];

        $repeat = function ($item) {
            return (int)$item['depth'] > 1 ? str_repeat('&#8735;', round($item['depth'] / ($item['depth'] + 0.9))) : null;
        };

        $nodes = self::getSiteNodes(\App\Models\Site::root(), false);

        if ($nodes) {
            foreach ($nodes->toArray() as $item) {
                $item['domain'] = sprintf('%s %s',
                    str_repeat('&nbsp;', abs($item['depth'] * 3 - 1)) . $repeat($item), //'&#8212; 8211'
                    $item['domain']
                );

                $sites[$item['id']] = $item['domain'];
            }
        }

        return $sites;
    }

    /**
     * @param $class
     * @return array
     * @internal param int $depth
     */
    private function getFieldGroups($class)
    {
        $fieldGroupsArray = [];

        foreach ($class::all('id', 'name')->toArray() as $fieldGroup) {
            $fieldGroupsArray[$fieldGroup['id']] = $fieldGroup['name'];
        }
        return $fieldGroupsArray;
    }

    private function getFieldValues($field)
    {
        return $field->field_values->toArray();
    }

    private function createFieldGroup($name, $fieldGroupNumber)
    {
        $name = trim($name);
        $fieldGroupClass = static::$fieldGroups[$fieldGroupNumber];
        $oFieldGroup = $fieldGroupClass::where(['name' => $name])->get()->first();

        if (empty($oFieldGroup)) {
            $oFieldGroup = $fieldGroupClass::create(['name' => $name]);
        }

        return $oFieldGroup;
    }

    private function saveObjectFieldValues($inputData, $objectField)
    {
        ObjectFieldValue::whereObjectFieldId($objectField->id)->delete();

        if (!empty($inputData['values']) && $inputData['field_type'] == ObjectField::FIELD_TYPE_RANGE) {
            foreach ($inputData['values'] as $index => $value) {
                if (isset($value)) {
                    ObjectFieldValue::firstOrCreate([
                        'object_field_id' => $objectField->id,
                        'value' => (int)$value
                    ]);
                }
            }
        }

        if (!empty($inputData['data_node_id'])) {
            ObjectFieldValue::firstOrCreate([
                'object_field_id' => $objectField->id,
                'data_node_id' => (int)$inputData['data_node_id']
            ]);
        }
    }
}
