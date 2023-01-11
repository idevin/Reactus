<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\Deployer\Classes\Deployer;
use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSession;
use App\Traits\Domain as DomainTrait;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

class UsersController extends CmsController
{

    use DomainTrait;

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Пользователи', 'cms.users.index'];
    }

    public function show()
    {

    }

    public function index(): Factory|View|Application
    {
        $title = 'Пользователи';

        $breadcrumbs = $this->breadcrumbs;

        $users = User::with('roles');

        $fields = $users = $this->setFields($users);

        $domains = Domain::personal()->get()->pluck('name', 'id');

        $filter = new CmsFilter(User::class, 'cms.users.index');

        $filter->addField('username', 'Ник')
            ->addField('email', 'E-mail')
            ->addField('phone', 'Телефон')
            ->addField('domain', 'Домен')
            ->addField('created_at', 'Дата создания')
            ->addField('superadmin', 'Суперадмин', 'checkbox');

        $filter = $filter->render();

        return view('cms.users.index',
            compact('fields', 'title', 'users', 'filter', 'breadcrumbs', 'domains'));
    }

    public function massChange(Request $request): RedirectResponse
    {
        $users = $request->get('ids');
        $domain = $request->get('domain');
        $objects = $request->get('o');

        if ($users) {
            if (!empty($domain) && is_string($users)) {

                $domain = Domain::find($domain);

                $userIds = explode(',', $users);
                $allUsers = (new User)->whereIn('id', $userIds)->get();
                foreach ($allUsers as $user) {

                    (new Deployer($user->domain, $user->blogSite->domainVolume, true))->v1();

                    $user->update([
                        'domain' => $domain->name
                    ]);
                }
            }
        }

        if (!empty($objects)) {
            $objects = explode(',', $objects);
            if (!empty($objects)) {
                try {
                    User::query()->whereIn('id', $objects)->delete();
                } catch (Exception $e) {
                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    }
                }
            }
        }

        session()->flash('success', 'Данные обновлены');

        return redirect()->route('cms.users.index');
    }

    public function edit($userId): Factory|View|Application
    {
        $title = 'Пользователи';
        $user = User::query()->findOrFail($userId);
        $roles = Role::query()->pluck('description', 'id')->all();

        $this->breadcrumbs[] = ['Редактирование пользователя'];
        $breadcrumbs = $this->breadcrumbs;

        $moderators = User::selectOptions($userId, true);

        $personalDomainsArray = [];

        Domain::personal()->get()->map(function ($domain) use ($user, &$personalDomainsArray) {
            $domainName = slugify($user->username) . '.' . $domain->name;
            $personalDomainsArray[$domain->id] = [
                'id' => $domainName,
                'name' => $domainName
            ];
        })->toArray();

        $personalDomains = $personalDomainsArray;

        return view('cms.users.edit', compact('user', 'title', 'breadcrumbs', 'roles', 'moderators', 'personalDomains'));
    }

    public function update(Request $request, $userId): RedirectResponse
    {
        $changePassword = false;
        $user = User::query()->findOrFail($userId);

        $data = $request->all();

        $rules = [
            'email' => 'required_if:phone,""|email_extended|max:100',
            'phone' => 'required_if:email,""'
        ];

        if (!empty($data['password_confirmation']) && !empty($data['password'])) {
            $rules['password'] = 'required|confirmed';
            $changePassword = true;
        } else {
            unset($data['password'], $data['password_confirmation']);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput($data)->withErrors($validator);
        }

        if (isset($data['active'])) {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
            UserSession::blocked($user);
        }

        if (isset($data['superadmin'])) {
            $data['superadmin'] = 1;
        } else {
            $data['superadmin'] = 0;
        }

        if ($changePassword == true) {
            $data['password'] = bcrypt($data['password_confirmation']);
        }

        if (!empty($data['phone'])) {
            $data['phone'] = preg_replace('#[^+\d]+#', '', $data['phone']);
        }

        $user->update($data);
        $roles = $request->get('roles', []);

        $user->roles()->sync($roles);
        $user->save();
        $site = BlogSite::query()->where('domain', $user->domain)->first();

        if ($site) {
            (new Deployer($user->domain, $user->blogSite->domainVolume, true))->v1();

            $site->update(['domain' => $user->domain]);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('cms.users.index');
    }

    /**
     * @param $userId
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($userId): RedirectResponse
    {
        $user = User::query()->findOrFail($userId);

        $error = '';
        if ($user->articles()->count()) {
            $error = 'Нельзя удалить пользователя! У этого пользователя есть статьи.';
        }

        if ($user->comments()->count()) {
            $error = 'Нельзя удалить пользователя! У этого пользователя есть комментарии.';
        }

        if ($error) {
            session()->flash('error', $error);
        } else {
            $user->delete();
            Deployer::uninstall($user->username, 'personal');
            session()->flash('success', 'Пользователь удален');
        }

        return redirect()->route('cms.users.index');
    }
}
