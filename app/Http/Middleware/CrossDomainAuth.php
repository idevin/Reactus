<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use App\Models\Site;
use App\Models\User;
use App\Models\UserSite;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site as SiteTrait;
use Auth;
use Closure;
use Cookie;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Session;

class CrossDomainAuth
{
    use AuthenticatesUsers, SiteTrait, DomainTrait;

    public function authenticated(): bool
    {
        return true;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $nextRequest = $next($request);

        $crawlerDetector = new CrawlerDetect();

        if ($crawlerDetector->isCrawler($request->header('User-Agent'))) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars($request->header('User-Agent'));
            }

            return $nextRequest;
        }

        $cookies = parse_cookies($request->headers->get('cookie'));
        $noAuth = $request->get('na');

        if (Auth::user()) {
            $userSite = $this->authStatus(Auth::user());

            if ($userSite && $userSite->logged == 0) {
                $userSite->update(['logged' => 1, 'admin' => Auth::user()->superadmin]);
            }

        } else {
            /**
             * 0 - check
             * 1 - guest
             * 2 - auth done
             * 3 - checked and found no records
             */

            $guest = Cookie::get('g');

            if (!$guest) {
                $guest = $cookies['g'] ?? null;
            }

            $credentials = Cookie::get('c');

            $uri = getSchema() . getenv('DOMAIN') . getenv('REQUEST_URI');

            $url = getSchema() . env('DEFAULT_DOMAIN') .
                route('api.credentials.check', ['d' => env('DOMAIN'), 'c' => $credentials, 'r' => $uri], false);

            if (!$guest && !$noAuth) {
                $gCookie = self::gCookie(env('DEFAULT_DOMAIN'), 1);
                return redirect($url)->withCookie($gCookie);
            }
        }

        return $nextRequest;
    }

    protected function authStatus($user, $domain = null)
    {
        $domain = $domain ? $domain : env('DOMAIN');

        $oSite = Site::where(['domain' => $domain])->get()->first();

        if ($oSite) {
            $data = ['user_id' => $user->id, 'site_id' => $oSite->id];
        } else {
            $data = ['user_id' => $user->id];
        }

        $userSite = UserSite::where($data)->get()->first();

        if (!$userSite) {
            $userSiteAny = UserSite::where($data)->get()->first();

            if ($userSiteAny) {
                $logged = $userSiteAny->logged;
            } else {
                $logged = true;
            }

            $data['logged'] = $logged;
            if ($oSite) {
                $domain = Domain::where('name', $oSite->domain)->first();

                if ($domain) {
                    $data['domain_id'] = $domain->id;
                }

                $data['admin'] = $user->superadmin;
            }
            $userSite = UserSite::create($data);
        }

        return $userSite;
    }
}
