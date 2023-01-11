<?php

namespace App\Http\Controllers\Cms;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Section as SectionModel;
use App\Models\SectionRole;
use App\Models\SectionUser;
use App\Models\User;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Section;
use App\Traits\Site;
use Illuminate\Http\Request;
use App\Utils\CmsFilter;
use App\Http\Requests;
use Illuminate\Http\Response;
use Validator;

class SectionUsersController extends CmsController
{
    use DomainTrait;
    use Site;
    use CustomValidators;
    use Section;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Управление разделами', 'section_users.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = 'Разделы';

        $breadcrumbs = $this->breadcrumbs;

        $sectionUsers = SectionUser::with(['user', 'section']);

        $fields = $this->setFields($sectionUsers);

        $filter = new CmsFilter(SectionUser::class, 'section_users.index');

        $filter->addField('user::username', 'Пользователь')
            ->addField('section::title', 'Название раздела')
            ->addButton('Создать', 'section_users.create');

        $filter = $filter->render();

        $groupedFields = [];

        foreach ($sectionUsers->get() as $sectionUser) {
            if ($sectionUser) {
                $groupedFields[$sectionUser->user_id] = $sectionUser->user;
            }
        }

        return view('cms.section_users.index',
            compact('fields', 'title', 'filter', 'breadcrumbs', 'groupedFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $title = 'Новый пользователь';

        $this->breadcrumbs[] = ['Создание'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new SectionUser();
        $action = 'section_users.store';

        $template = $form;
        $users = User::selectOptions(null, true);
        $roles = Role::selectOptions(null, true);
        $sections = $this->getAllSections(SectionModel::class);

        return view('cms.section_users.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'template', 'users', 'roles', 'sections'));
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
            foreach ($inputData['user_id'] as $i => $user) {
                if (!empty($user)) {

                    $existantUser = SectionUser::where('user_id', $user)
                        ->where('section_id', $inputData['section_id'])->first();

                    if (!$existantUser) {
                        SectionUser::firstOrCreate([
                            'user_id' => $user,
                            'section_id' => $inputData['section_id']
                        ]);

                        foreach ($inputData['role_id'] as $j => $role) {
                            if (!empty($role)) {
                                SectionRole::firstOrCreate([
                                        'section_id' => $inputData['section_id'],
                                        'user_id' => $user,
                                        'role_id' => $role
                                    ]
                                );
                            }
                        }
                    }
                }
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('section_users.index');
        }
    }

    public static function getValidator($data)
    {
        $rules = [
            'user_id' => 'required|array',
            'role_id' => 'required|array',
            'section_id' => 'required'
        ];

        return self::siteSectionUsersValidator($rules, $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = 'Управление разделами';

        $form = SectionUser::findOrFail($id);
        $template = $form;

        $this->breadcrumbs[] = ['Редактирование прав для раздела'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'section_users.update';
        $users = User::selectOptions(null, true);
        $roles = Role::selectOptions(null, true);
        $sections = $this->getAllSections(SectionModel::class);

        return view('cms.section_users.edit', compact('form', 'title', 'breadcrumbs', 'action', 'template', 'users', 'roles', 'sections'));
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
        $field = SectionUser::findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            foreach ($inputData['user_id'] as $i => $user) {
                if (!empty($user)) {

                    if ($field->user_id == $user) {

                        $sectionRoles = SectionRole::where([
                            'user_id' => $field->user_id,
                            'section_id' => $field->section_id
                        ]);

                        $sectionRoles->delete();

                        $field->update([
                            'section_id' => $inputData['section_id']
                        ]);

                        foreach ($inputData['role_id'] as $j => $role) {
                            if (!empty($role)) {
                                SectionRole::create([
                                        'section_id' => $inputData['section_id'],
                                        'user_id' => $field->user_id,
                                        'role_id' => $role
                                    ]
                                );
                            }
                        }
                    } else {
                        $existantUser = SectionUser::where('user_id', $user)
                            ->where('section_id', $inputData['section_id'])->first();

                        if (!$existantUser) {
                            SectionUser::create([
                                'user_id' => $user,
                                'section_id' => $inputData['section_id']
                            ]);

                            foreach ($inputData['role_id'] as $j => $role) {
                                if (!empty($role)) {
                                    SectionRole::create([
                                            'section_id' => $inputData['section_id'],
                                            'user_id' => $user,
                                            'role_id' => $role
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
            }

            session()->flash('success', 'Запись сохранена');
            return redirect()->route('section_users.index');
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
        $sectionUser = SectionUser::findOrFail($id);

        SectionRole::where('user_id', $sectionUser->user_id)
            ->where('section_id', $sectionUser->section_id)->delete();

        SectionUser::findOrFail($id)->delete();

        session()->flash('success', 'Права удалены!');

        return redirect()->route('section_users.index');
    }
}
