<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Site as SiteModel;
use App\Models\User;
use App\Models\UserSite;
use App\Traits\Activity;
use App\Traits\Domain as DomainTrait;
use App\Traits\User as UserTrait;
use Auth;
use Cookie;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CredentialsController extends Controller
{
    use UserTrait;
    use Activity;
    use DomainTrait;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(SiteModel::class);
    }

    public function token($token, Request $request): Response|Application|ResponseFactory|null
    {
        $domain = $request->get('d');
        $user = User::whereAuthToken($token)->first();
        $response = null;
        $cookies = [];

        $personal = $user?->domain;

        $checkDomain = Domain::whereName(trim(main_domain($domain)))->first();

        if (!$checkDomain) {
            return null;
        }

        if ($user && $checkDomain->domain_type == Domain::DOMAIN_TYPE_THEMATIC) {

            $data = $user->getUserString();
            $site = SiteModel::whereDomain($domain)->first();
            $cookieSite = $site ? ('.' . idnToAscii($site->domain)) : '.' . $domain;
            $cookies = $this->getAuthCookies($data, $cookieSite);

        } elseif ($user && $checkDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {

            $data = $user->getUserString();
            $site = SiteModel::whereDomain(main_domain($domain))->first();
            $cookieSite = $site ? ('.' . idnToAscii($site->domain)) : '.' . $domain;
            $cookies = $this->getAuthCookies($data, $cookieSite);

            $personal = $user->domain;
            $this->loggedPersonal($user, true, $domain);

        } else {
            $site = SiteModel::whereDomain(main_domain($domain))->first();
            if (!$site) {
                return null;
            }

            $cookieSite = '.' . idnToAscii($site->domain);

            $cookies[] = Cookie::forget('g', '/', '.' . $cookieSite);

            $cookies[] = self::cCookie($cookieSite, $user->getUserString());
            $cookies[] = self::gCookie($cookieSite, 3);
        }

        $sites = $this->getAuthSites($user);
        $sites = $sites->unique();

        try {
            $response = response(view(theme('credentials.login'),
                compact('sites', 'personal', 'user'))->render());
        } catch (Throwable $e) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars($e->getMessage(), $e->getTrace());
            }
        }

        foreach ($cookies as $cookie) {
            $response = $response->withCookie($cookie);
        }

        return $response;
    }

    private function getAuthCookies($data, $cookieSite): array
    {
        $cookies[] = Cookie::forget('c', '/', $cookieSite);
        $cookies[] = Cookie::forget('g', '/', $cookieSite);

        $cookies[] = Cookie::forget('c', '/', '.' . env('DEFAULT_DOMAIN'));
        $cookies[] = Cookie::forget('g', '/', '.' . env('DEFAULT_DOMAIN'));

        $cookies[] = self::cCookie($cookieSite, $data);
        $cookies[] = self::gCookie($cookieSite, 2);

        $cookies[] = self::cCookie(env('DEFAULT_DOMAIN'), $data);
        $cookies[] = self::gCookie(env('DEFAULT_DOMAIN'), 2);

        return $cookies;
    }

    private function loggedPersonal($user, $logged = false, $domainId = null)
    {
        $domain = Domain::find($domainId);

        if ($domain && $user) {
            $oUserSiteExists = UserSite::where(['user_id' => $user->id, 'domain_id' => $domain->id])->get();

            if (count($oUserSiteExists) > 0) {
                foreach ($oUserSiteExists as $oSite) {
                    $oSite->update(['logged' => $logged, 'admin' => $user->superadmin]);
                }
            } else {
                UserSite::create([
                    'user_id' => $user->id, 'domain_id' => $domain->id,
                    'logged' => $logged, 'site_id' => null, 'admin' => $user->superadmin
                ]);
            }
        }

        if ($user) {
            UserSite::where(['user_id' => $user->id])->update(['logged' => $logged]);
        }

        if ($user && $logged == true) {
            Auth::login($user, true);
            Session::put('user', $user);
        }
    }

    public function check(Request $request): Redirector|Application|RedirectResponse
    {
        $credentials = Cookie::get('c');
        $referer = $request->input('r');
        $site = $request->input('d');
        $oSite = SiteModel::query()->where(['domain' => trim($site)])->first();

        if (!isset($oSite)) {
            return redirect(getSchema() . $site . getPort());
        }

        $cookies = [];

        $url = getSchema() . ($oSite ? $oSite->domain : $site) . getPort() .
            route('api.credentials.guest', ['c' => $credentials], false);

        if ($credentials) {
            $domain = Domain::where('name', main_domain($site))->first();

            if (isset($domain) && $domain->domain_type == Domain::DOMAIN_TYPE_THEMATIC) {
                $cookies[] = self::cCookie($oSite->domain, $credentials);

                $url = $this->authUrl($credentials, $oSite);

            } else {
                $decryptedCredentials = decrypt($credentials, false);
                $cookies[] = self::cCookie($site, $decryptedCredentials);

                $url = $this->authPersonalUrl($decryptedCredentials, $site);
                $referer = null;
            }
        }

        if ($referer) {
            if (strpos($url, '?') == false) {
                $url = $url . '?r=' . $referer;
            } else {
                $url = $url . '&r=' . $referer;
            }
        }

        return redirect($url)->withCookies($cookies);
    }

    private function authUrl($credentials, $oSite): string
    {
        $url = getSchema() . $oSite->domain . getPort() .
            route('api.credentials.guest', ['c' => $credentials], false);

        $credentials = decrypt($credentials, false);

        $user = User::find($credentials);

        if ($user) {
            $userSite = $this->authStatus($user, $oSite);

            if ($userSite->logged == 1) {
                $url = getSchema() . $oSite->domain . getPort() .
                    route('api.credentials.login_thematic', ['token' => $user->auth_token], false);
            }
        }

        return $url;
    }

    protected function authStatus($user, $oSite)
    {
        $data = ['user_id' => $user->id, 'site_id' => $oSite->id];

        $userSite = UserSite::where($data)->get()->first();

        if (!$userSite) {
            $userSiteAny = UserSite::where(['user_id' => $user->id])->get()->first();
            if ($userSiteAny) {
                $logged = $userSiteAny->logged;
            } else {
                $logged = 1;
            }

            $data['logged'] = $logged;

            $userSite = UserSite::firstOrCreate($data);
        } else {
            $userSite->update([
                'logged' => 1,
                'admin' => $user->superadmin
            ]);
        }

        return $userSite;
    }

    private function authPersonalUrl($decryptedCredentials, $site): string
    {
        $url = getSchema() . $site . getPort() . route('api.credentials.guest', ['c' => ''], false);

        $user = User::query()->find($decryptedCredentials);

        if ($user) {
            $url = getSchema() . $site . getPort() .
                route('api.credentials.login_thematic', ['token' => $user->auth_token], false);
        }

        return $url;
    }

    public function login($token)
    {
        $user = User::whereAuthToken($token)->get()->first();
        $cookies = [];

        if ($user) {
            $cookies[] = self::cCookie(env('DOMAIN'), $user->getUserString());
            $cookies[] = self::gCookie(env('DOMAIN'), 2);

            Auth::login($user, true);

            $site = SiteModel::whereDomain(env('DOMAIN'))->first();

            if ($site) {
                $this->logged($user, $site, true);
            } else {
                $domain = Domain::whereName(env('DOMAIN'))->first();

                if ($domain) {
                    $this->loggedPersonal($user, true, $domain->id);
                }
            }
        }
        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Logged in');
        }
        return redirect(getSchema() . env('DOMAIN') . getPort())->withCookies($cookies);
    }

    private function logged($user, $site, $logged = 0)
    {
        if ($site && $user) {
            $oUserSiteExists = UserSite::query()->where(['user_id' => $user->id, 'site_id' => $site->id])->get();

            if (count($oUserSiteExists) > 0) {
                foreach ($oUserSiteExists as $oSite) {
                    $oSite->update(['logged' => $logged, 'admin' => $user->superadmin]);
                }
            } else {
                $domain = Domain::query()->where('name', idnToAscii($site->domain))->get()->first();

                UserSite::firstOrCreate([
                    'user_id' => $user->id,
                    'site_id' => $site->id,
                    'logged' => $logged,
                    'admin' => $user->superadmin,
                    'domain_id' => $domain->id
                ]);
            }
        }

        if ($user) {
            UserSite::query()->where(['user_id' => $user->id])->update(['logged' => $logged]);
        }

        if ($user && $logged == true) {
            Auth::login($user, true);
            Session::put('user', $user);
        }
    }

    /**
     * @return ResponseFactory|Response
     */
    public function eraseGuestCookie()
    {
        $cookie = Cookie::forget('g');

        return response('')->withCookie($cookie);
    }

    public function guest(Request $request)
    {
        Auth::logout();

        $cookies[] = self::gCookie(env('DOMAIN'), 1);
        $cookies[] = Cookie::forget('c');
        $referer = $request->input('r');
        $url = getSchema() . env('DOMAIN') . getPort();

        if ($referer) {
            $url = $referer;
        }

        return redirect($url)->withCookies($cookies);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function logout(Request $request): Response|Application|ResponseFactory
    {
        $domain = $request->get('d');

        $user = $this->getUser($request);

        $personal = [];

        if ($domain) {

            $checkDomain = Domain::whereName(main_domain($domain))->first();
            $site = null;

            if ($checkDomain) {
                if ($checkDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {
                    $site = SiteModel::whereDomain(main_domain($domain))->first();
                } else {
                    $site = SiteModel::whereDomain($domain)->first();
                }
            } else {
                $info = 'Logout: domain not found';

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars($info);
                }

                $this->setIsSystem(1);
                $this->setIsApi(1);
                $this->setActivityError($info);
                $this->createActivity();
            }

//            if ($user && $site) {
////                $this->logged($user, $site);
//            } else {
//                $info = 'Logout: can not find User or Site';
//
//                if (env('APP_DEBUG_VARS') == true) {
//                    debugvars($info);
//                }
//
//                $this->setIsSystem(1);
//                $this->setIsApi(1);
//                $this->setActivityError($info);
//                $this->createActivity();
//            }
        }
        $sites = $this->getAuthSites(Auth::user());
        return response(null)
            ->setContent(view(theme('credentials.logout'), compact('sites', 'personal', 'user'))->render())
            ->withCookie(Cookie::forget('c'));
    }

    public function nativeLogout(): Response|Application|ResponseFactory
    {
        Auth::logout();

        return response(null)->setContent('')->withCookie(Cookie::forget('c'))
            ->withCookie(self::gCookie(main_domain(env('DOMAIN')), 1));
    }
}