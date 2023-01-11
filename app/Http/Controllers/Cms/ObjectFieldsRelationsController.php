<?php

namespace App\Http\Controllers\Cms;

use App\Models\FieldGroup;
use App\Models\NeoUserFieldGroup;
use App\Models\NeoCatalog;
use App\Models\NeoCatalogField;
use App\Models\NeoCatalogFieldGroup;
use App\Models\ObjectField;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\FieldGroup as FieldGroupTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class ObjectFieldsRelationsController extends CmsController
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

        $this->breadcrumbs[] = ['Связи обьектов', 'object_fields_relations.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $title = 'Управление';

        $fields = NeoCatalog::query()->orderBy('alias')->where('user_id', null)->paginate(100);

        $filter = new CmsFilter(NeoCatalog::class, 'object_fields_relations.index');

        $filter->addButton('Создать', 'object_fields_relations.create');

        $filter = $filter->render();

        $breadcrumbs = $this->breadcrumbs;

        return view('cms.object_fields_relations.index',
            compact('filter', 'title', 'breadcrumbs', 'fields'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $title = 'Новый Каталог + группа полей';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new NeoCatalogField();
        $action = 'object_fields_relations.store';

        $oFieldGroups = NeoCatalogFieldGroup::query()->where('field_group_id', null)->orderBy('id', 'desc')->get();

        $field_groups = NeoCatalogFieldGroup::getTree($oFieldGroups);

        $allNodes = NeoCatalog::query()->orderBy('alias')->where('user_id', null)->get()->pluck('name', 'id')->toArray();

        return view('cms.object_fields_relations.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'field_groups', 'allNodes'));
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

            $fieldGroup = NeoCatalogFieldGroup::query()->whereId((int)$inputData['field_group_id'])->first();

            $catalog = NeoCatalog::query()->find((int)$inputData['catalog_id']);

            $found = $catalog->fieldGroups()->find($fieldGroup->id);

            if (!$found) {
                $catalog->fieldGroups()->attach($fieldGroup);
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('object_fields_relations.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'field_group_id' => 'required',
            'catalog_id' => 'required',
        ], [
            'field_group_id.required' => 'Выберите группу полей',
            'catalog_id.required' => 'Выберите каталог',
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $fieldGroup = NeoCatalogFieldGroup::query()->find($id);
        $catalog = NeoCatalog::query()->find($request->get('catalog_id'));

        if ($catalog && $fieldGroup) {
            $catalog->fieldGroups()->detach($fieldGroup);
        }

        session()->flash('success', 'Связь удалена!');

        return redirect()->route('object_fields_relations.index');
    }
}
