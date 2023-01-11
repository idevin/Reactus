<?php

namespace App\Http\Controllers\Cms;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

class RolesController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Роли', 'roles.index'];
    }

    public function create(): Factory|View|Application
    {
        $title = 'Новая роль';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Role();
        $action = 'roles.store';
        $permissions = Permission::with('roles')->orderBy('name', 'asc')->get();
        $rolePermissions = [];
        $formPermissions = [];

        return view('cms.roles.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'permissions',
                'rolePermissions', 'formPermissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $inputData = $request->all();

        list($validator, $permissionIds) = self::getPermissionsValidator($inputData);

        forget('guest_role');

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $role = Role::query()->create(collect($inputData)->only('name', 'description', 'for_registered')->toArray());
            $role->syncPermissions($permissionIds);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('roles.index');
        }
    }

    public static function getPermissionsValidator($inputData): array
    {
        $permissions = $inputData['permissions'];
        $permissionIds = [];

        foreach ($permissions as $id => $permission) {
            if (isset($permission['own']) || isset($permission['other'])) {
                $permissionIds[$id] = [
                    'own' => isset($permission['own']) ? 1 : 0,
                    'other' => isset($permission['other']) ? 1 : 0
                ];
            }
        }

        $inputData['permissionIds'] = $permissionIds;

        return [static::getValidator($inputData), $permissionIds];
    }

    public static function getValidator($data)
    {
        $rules = [
            'description' => 'required',
            'name' => 'required'
        ];

        $messages = [
            'description.required' => 'Напишите описание',
            'name.required' => 'Напишите название роли'
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function index(): Factory|View|\Illuminate\View\View|Application
    {
        $title = 'Роли';

        $breadcrumbs = $this->breadcrumbs;

        $permissions = Role::with('permissions');

        $fields = $this->setFields($permissions);

        $filter = new CmsFilter(Role::class, 'roles.index');

        $filter->addField('description', 'Название')
            ->addButton('Создать', 'roles.create');

        $filter = $filter->render();

        return view('cms.roles.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    public function edit($userId): Factory|View|Application
    {
        $title = 'Роли';
        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'roles.update';

        $form = Role::query()->findOrFail($userId);
        $permissions = Permission::with('roles')->orderBy('name')->get();
        $builderPermissions = $form->permissions();
        $rolePermissions = $builderPermissions->get()->pluck('id')->toArray();
        $formPermissions = $builderPermissions->get()->pluck('pivot')->keyBy('permission_id')->toArray();

        return view('cms.roles.edit', compact('form', 'title', 'breadcrumbs', 'action', 'permissions', 'rolePermissions', 'formPermissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        /** @var Role $field */
        $field = Role::query()->findOrFail($id);
        $inputData = $request->all();

        list($validator, $permissionIds) = self::getPermissionsValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $field->syncPermissions($permissionIds);

            User::syncAllPermissions();

            $field->update([
                'name' => $inputData['name'],
                'description' => $inputData['description'],
                'for_registered' => $inputData['for_registered'] ?? null,
                'is_anon' => $inputData['is_anon'] ?? null
            ]);

            session()->flash('success', 'Запись сохранена');

            forget('guest_role');

            return redirect()->route('roles.index');
        }
    }

    public function destroy($id): RedirectResponse
    {
        $role = Role::query()->findOrFail($id);

        try {
            $role->delete();
            session()->flash('success', 'Запись удалена!');
        } catch (Exception $e) {
            debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Невозможно удалить роль: ' . $e->getMessage());
        }

        return redirect()->route('roles.index');
    }
}