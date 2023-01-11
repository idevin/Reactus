<?php namespace App\Http\Middleware;

use App\Models\Domain;
use App\Models\DomainMirror;
use App\Models\Site;
use Cache;
use Closure;
use Illuminate\Http\Request;
use Redirect;

/**
 * Class ActiveDomainMiddleware
 * @package App\Http\Middleware
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class ActiveDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() != 'GET' || $request->ajax()) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('ACTIVE: NO REQ METHOD');
            }

            return $next($request);
        }

        /** @var Site $site */
        $site = get_site();

        if (empty($site)) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('ACTIVE: EMPTY SITE');
            }

            return $next($request);
        }

        /** @var Domain $domain */
        $domain = $site->siteDomain;
        if (empty($domain)) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('ACTIVE: EMPTY DOMAIN');
            }

            return $next($request);
        }

        if ($domain->domain_type == Domain::DOMAIN_TYPE_SYSTEM) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('ACTIVE: TECH DOMAIN');
            }

            $domainMirror = DomainMirror::getByDomainMirrorId($domain->id);

            if (!$domainMirror || !$domainMirror->domain) {
                return $next($request);
            }

            $deletedSite = Cache::get(Site::class . '.' . $domainMirror->domain->name . '.deleted');

            if (!$deletedSite) {
                return $this->redirectTo($request, $domainMirror->domain->name, 'NOT DELETED DOMAIN: REDIRECT 301');
            }

            $mainDomain = $domainMirror->domain;
            if ($mainDomain->site) {
                putenv('DOMAIN=' . $mainDomain->site->domain);
            }

            return $next($request);
        }

        $deletedSite = Cache::get(Site::class . '.' . idnToAscii($site->domain) . '.deleted');

        if ($deletedSite) {
            $domainMirror = DomainMirror::whereDomainId($domain->id)->first();
            if ($domainMirror) {
                return $this->redirectTo($request, $domainMirror->domainMirror->name, 'DELETED DOMAIN: REDIRECT 301');
            }
        }
        return $next($request);
    }

    private function redirectTo($request, $domain, $info)
    {
        $redirectPath = getSchema();
        $redirectPath .= $domain;
        $redirectPath .= $request->getPathInfo();
        $redirectPath .= !empty($request->getQueryString()) ? '?' . $request->getQueryString() : '';

        if (env('APP_DEBUG_VARS') == true) {
            debugvars($info);
        }

        return Redirect::to($redirectPath, 301, $request->headers->all());
    }
}