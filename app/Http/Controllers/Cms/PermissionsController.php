<?php

namespace App\Http\Controllers\Cms;

use App\Models\Permission;
use App\Models\SectionRole;
use App\Models\SectionUser;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use Illuminate\Http\Request;
use App\Utils\CmsFilter;
use App\Http\Requests;
use Illuminate\Http\Response;
use Validator;

class PermissionsController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Права и действия', 'permissions.index'];

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = 'Права и действия';

        $breadcrumbs = $this->breadcrumbs;

        $roles = Permission::with(['roles']);

        $fields = $this->setFields($roles);

        $filter = new CmsFilter(Permission::class, 'permissions.index');

        $filter->addField('name', 'Название')
            ->addField('description', 'Описание')
            ->addButton('Создать', 'permissions.create');

        $filter = $filter->render();

        return view('cms.permissions.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Permission();
        $action = 'permissions.store';
        $permissions = Permission::with('roles')->orderBy('name', 'asc')->get();
        $rolePermissions = [];
        $formPermissions = [];

        return view('cms.permissions.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'permissions', 'rolePermissions', 'formPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            Permission::create($inputData);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('permissions.index');
        }
    }

    public static function getValidator($data)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $messages = [
            'name.required' => 'Напишите псевдоним',
            'description.required' => 'Напишите название'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = 'Редактирование права';

        $form = Permission::findOrFail($id);
        $template = $form;

        $this->breadcrumbs[] = ['Редактирование права'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'permissions.update';

        return view('cms.permissions.edit', compact('form', 'title', 'breadcrumbs', 'action', 'template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $field = Permission::findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $field->update($inputData);
            session()->flash('success', 'Запись сохранена');
            return redirect()->route('permissions.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $sectionUser = SectionUser::find($id);

        if ($sectionUser) {
            SectionRole::where('user_id', $sectionUser->user_id)
                ->where('section_id', $sectionUser->section_id)->delete();

            SectionUser::find($id)->delete();
        }

        Permission::find($id)->delete();

        session()->flash('success', 'Права удалены!');

        return redirect()->route('permissions.index');
    }
}
