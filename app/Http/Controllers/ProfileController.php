<?php

namespace App\Http\Controllers;

use App\Models\BlogSite;
use App\Models\Community;
use App\Models\Field;
use App\Models\FieldUserGroup;
use App\Models\FieldUserValue;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Section;
use App\Traits\Site;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Log;

class ProfileController extends Controller
{
    use Section;
    use \App\Traits\User;
    use Activity;

    public static User|null $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function index(): Factory|Redirector|View|RedirectResponse|Application
    {
        $user = User::whereDomain(getenv('DOMAIN'))->first();
        $hostData = preg_split('/./', getenv('DOMAIN'));
        $username = $hostData[0];
        $http = getSchema();

        if (empty($user)) {
            if (!empty($hostData)) {
                $user = User::whereUsername($username)->first();
                if (!$user || !$user->active) {
                    return redirect($http . $hostData[1] . '.' . $hostData[2] . '/404');
                }
            }
        }

        if ($user && Auth::user() && Auth::user()->id == $user->id) {
            Auth::login($user, true);
        }

        if ($user->domain == getenv('DOMAIN')) {
            return $this->showPublic();
        } else {
            return redirect($http . $hostData[1] . '.' . $hostData[2] . '/404');
        }
    }

    /**
     * @return Factory|View
     */
    public function showPublic(): Factory|View|RedirectResponse
    {
        $redirect = false;

        if (Auth::user() && !Auth::user()->hasPermission('profile_access')) {
            $redirect = $this->getRedirect();
        }

        if ($redirect) {
            return redirect($this->getDomain() . '/404');
        }

        $title = username(Auth::user());
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('title', 'ssr'));
    }

    public function getRedirect(): bool
    {
        $message = username(Auth::user()) . ': у вас нет прав для доступа к профилю';
        session()->flash('error', $message);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars($message);
        }

        return true;
    }

    public function getDomain(): string
    {
        $http = getSchema();
        $domain = main_domain(env('DOMAIN'));

        return $http . $domain;
    }

    public function sections():View|Factory|Redirector|RedirectResponse|Application
    {
        $site = $this->getSite(env('DOMAIN'), BlogSite::class);

        $user = $this->publicUser();

        if (!$user) {
            return redirect(getSchema() . env('DOMAIN') . '/404');
        }

        $ssr = Site::ssr();
        return view('ProfileLayout', compact('site', 'ssr'));
    }

    public function show(): View|Factory|Redirector|RedirectResponse|Application
    {
        $redirect = false;
        $user = $this->publicUser();

        if (Auth::user() && !Auth::user()->hasPermissionAll('profile_access')) {
            $redirect = $this->getRedirect();
        }

        if ($redirect) {
            return redirect($this->getDomain() . '/404');
        }

        $title = username($user);
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('title', 'ssr'));
    }

    public function security()
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $publicUser = $this->publicUser();
        $domain = main_domain(env('DOMAIN'));
        $http = getSchema();

        $redirect = null;
        $redirect = true;

        if ($authUser) {
            if ($authUser->hasPermission('profile_access') || $authUser->id == $publicUser->id) {
                $redirect = false;
            }
        }

        if ($redirect == true) {
            session()->flash('error', 'У вас нет прав для доступа к профилю');
            return redirect($http . $domain . '/404');
        }

        return $this->getProfilePage();
    }

    private function getProfilePage()
    {
        $ssr = Site::ssr();
        return view('ProfileLayout', compact('ssr'));
    }

    public function articles()
    {
        return $this->getProfilePage();
    }

    public function blog()
    {
        return $this->getProfilePage();
    }

    public function activity()
    {
        return $this->getProfilePage();
    }

    public function projects()
    {
        return $this->getProfilePage();
    }

    public function cards(): \Illuminate\Contracts\View\View|Factory|Redirector|RedirectResponse|Application
    {
        $user = Auth::user();
        $publicUser = $this->publicUser();

        if (($user && $publicUser->id != $user->id) || !$user) {
            return redirect(getSchema() . $publicUser->domain);
        }

        return $this->getProfilePage();
    }

    private function getAbstractFields($user, $all = null): array
    {
        $fieldUserGroups = [];
        $fieldGroupsArray = [];
        $fieldUserValues = [];

        if ($user) {
            if ($all) {
                $fieldGroups = Field::with('field_group')
                    ->where('field_group_id', '!=', config('netgamer.user_field_group'))->get();

                $params = ['user_id' => $user->id];
            } else {
                $site = get_site();
                $params = ['user_id' => $user->id];
                $fieldGroups = Field::with(['field_group']);

                if ($site) {
                    $fieldGroups = $fieldGroups->where('site_id', $site->id);
                    $params['site_id'] = $site->id;
                }

                $fieldGroups = $fieldGroups->get();
            }

            $fieldUserValues = FieldUserValue::where($params)
                ->with('field_user_group')
                ->with('field')->get();

            $fieldUserGroups = FieldUserGroup::where(['user_id' => $user->id])->get();

            $userGroup = null;

            if (!empty($fieldGroups)) {
                foreach ($fieldGroups as $field) {

                    $field->value = $field->getFieldValue($fieldUserValues);

                    if ($field->field_type == Field::FIELD_TYPE_FILE && $field->value) {

                        $field->value->file = get_file($field->value->value);
                    }

                    foreach ($fieldUserGroups as $fieldUserGroup) {
                        if ($fieldUserGroup->field_group_id == $field->field_group_id) {
                            $userGroup = $fieldUserGroup;
                            break;
                        }
                    }

                    $fieldGroupsArray[$field->field_group_id]['user_group'] = $userGroup;
                    $fieldGroupsArray[$field->field_group_id]['group'] = $field->field_group;

                    $path = '';

                    if (isset($field->field_group) && $field->field_group->isRoot()) {
                        $path = $field->field_group->name;
                    } else {
                        $root = $field->field_group->getRoot();
                        $children = $field->field_group->getDescendantsAndSelf();
                        $path .= $root->name;
                        if (count($children) > 0) {
                            foreach ($children as $child) {
                                $path .= ' -> ' . $child->name;
                            }
                        }
                    }

                    $fieldGroupsArray[$field->field_group_id]['group']->path = $path;
                    $fieldGroupsArray[$field->field_group_id]['fields'][] = $field;
                }
            }
        }

        return [
            $fieldUserGroups,
            $fieldUserValues,
            $fieldGroupsArray
        ];
    }
}