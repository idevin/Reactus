<?php

namespace App\Http\Controllers\Cms;

use App\Exceptions\RoleDoesNotExist;
use App\Models\Role;
use App\Models\Site as SiteModel;
use App\Models\SiteRole;
use App\Models\SiteUser;
use App\Models\User;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Validator;

class SiteUsersController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Управление сайтами', 'site_users.index'];

    }

    /**
     * @return View|Factory|\Illuminate\View\View|Application
     */
    public function index(): View|Factory|\Illuminate\View\View|Application
    {
        $title = 'Управление сайтами';

        $breadcrumbs = $this->breadcrumbs;

        $siteUsers = SiteUser::with(['user', 'site']);

        $fields = $this->setFields($siteUsers);

        $filter = new CmsFilter(SiteUser::class, 'site_users.index');

        $filter->addButton('Создать', 'site_users.create');

        $filter = $filter->render();
        $groupedFields = [];

        if (count($fields) > 0) {
            foreach ($fields as $field) {
                $groupedFields[$field->user_id] = $field->user;
            }
        }

        return view('cms.site_users.index',
            compact('fields', 'title', 'filter', 'breadcrumbs', 'groupedFields'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $title = 'Создать';

        $this->breadcrumbs[] = ['Создание права'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new SiteUser();
        $action = 'site_users.store';

        $template = $form;
        $users = User::selectOptions(null, true);
        $roles = Role::selectOptions(null, true);
        $sites = SiteModel::selectOptions(null, true);

        return view('cms.site_users.new_form', [
                'form' => $form,
                'title' => $title,
                'breadcrumbs' => $breadcrumbs,
                'action' => $action,
                'template' => $template,
                'users' => $users,
                'roles' => $roles,
                'sites' => $sites
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Redirector|RedirectResponse|Application|null
     */
    public function store(Request $request): Redirector|RedirectResponse|Application|null
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            foreach ($inputData['user_id'] as $userId) {
                if (!empty($userId)) {

                    $result = $this->checkSiteUser($userId, $inputData);

                    if (is_a($result, RedirectResponse::class)) {
                        return $result;
                    }

                    self::createUserAndRoles($userId, $inputData);
                }
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('site_users.index');
        }
    }

    public static function getValidator($data)
    {
        $rules = [
            'user_id' => 'required|array',
            'role_id' => 'required|array',
            'site_id' => 'required'
        ];

        return self::siteSectionUsersValidator($rules, $data);
    }

    public function checkSiteUser($user, $inputData, $id = null): Redirector|RedirectResponse|Application|null
    {
        $siteUser = SiteUser::query()->where('user_id', $user)
            ->where('site_id', $inputData['site_id'])->first();
        if ($siteUser) {

            $data = [];

            $rules = [
                'site_id' => 'required'
            ];

            $messages = [
                'site_id.required' => 'Настройки для пользователя "' .
                    username($siteUser->user) . '" и сайта "' . $siteUser->site->domain . '" уже есть'
            ];

            $validator = Validator::make($data, $rules, $messages);

            if ($id) {
                $route = route('site_users.edit', ['site_users' => $id]);
            } else {
                $route = route('site_users.create');
            }

            return redirect($route)->withErrors($validator);
        } else {
            return null;
        }
    }

    public static function createUserAndRoles($userId, $inputData)
    {
        SiteUser::query()->firstOrCreate([
            'user_id' => $userId,
            'site_id' => $inputData['site_id'],
        ]);

        foreach ($inputData['role_id'] as $roleId) {
            if (!empty($roleId)) {
                SiteRole::query()->firstOrCreate([
                        'site_id' => $inputData['site_id'],
                        'user_id' => $userId,
                        'role_id' => $roleId
                    ]
                );
            }
        }
    }

    /**
     * @param int $id
     */
    public function show(int $id)
    {
        //
    }

    /**
     * @param int $id
     * @return Factory|View|Application
     */
    public function edit(int $id): Factory|View|Application
    {
        $title = 'Редактировать';

        $form = SiteUser::query()->findOrFail($id);
        $template = $form;

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'site_users.update';
        $users = User::selectOptions(null, true);
        $roles = Role::selectOptions(null, true);
        $sites = SiteModel::selectOptions(null, true);

        return view('cms.site_users.edit',
            compact('form', 'title', 'breadcrumbs', 'action', 'template', 'sites', 'users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Redirector|RedirectResponse|Application|null
     */
    public function update(Request $request, int $id): Redirector|RedirectResponse|Application|null
    {
        $field = SiteUser::query()->findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            foreach ($inputData['user_id'] as $userId) {
                if (!empty($userId)) {

                    if ($field->user_id == $userId) {

                        if ($field->site_id != $inputData['site_id']) {
                            $result = $this->checkSiteUser($userId, $inputData, $id);

                            if (is_a($result, RedirectResponse::class)) {
                                return $result;
                            }
                        }

                        $siteRoles = SiteRole::query()->where('user_id', $field->user_id)
                            ->where('site_id', $field->site_id);

                        $siteRoles->delete();

                        $field->update([
                            'site_id' => $inputData['site_id']
                        ]);

                        foreach ($inputData['role_id'] as $roleId) {
                            if (!empty($roleId)) {
                                SiteRole::query()->firstOrCreate([
                                        'site_id' => $inputData['site_id'],
                                        'user_id' => $field->user_id,
                                        'role_id' => $roleId
                                    ]
                                );
                            }
                        }

                    } else {

                        $result = $this->checkSiteUser($userId, $inputData, $id);

                        if (is_a($result, RedirectResponse::class)) {
                            return $result;
                        }

                        self::createUserAndRoles($userId, $inputData);
                    }
                }
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('site_users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws RoleDoesNotExist
     */
    public function destroy(int $id): RedirectResponse
    {
        $siteUser = SiteUser::query()->findOrFail($id);
        $currentRoles = $siteUser->roles()->get();

        if (count($currentRoles) > 0) {
            $user = User::query()->find($siteUser->user_id);
            if ($user) {
                $currentRoles->map(function ($currentRole) use ($user) {
                    $user->removeRole($currentRole);
                });
            }
        }

        $siteUser->delete();

        SiteRole::query()->where(['user_id' => $siteUser->user_id, 'site_id' => $siteUser->site_id])->delete();

        session()->flash('success', 'Права удалены!');

        return redirect()->route('site_users.index');
    }
}
