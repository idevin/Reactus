<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use App\Models\Site;
use App\Traits\Site as SiteTrait;
use Cache;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Route;

class CheckSite
{
    use SiteTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $siteOrigin = $this->getSite(env('DOMAIN'));
        $mainDomain = $this->getSite(main_domain(env('DOMAIN')));

        $siteRoot = Site::root()->first();

        if (!$siteRoot) {
            return $next($request);
        }

        $isPersonal = ($mainDomain && $mainDomain->siteDomain &&
            $mainDomain->siteDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL);


        if ((env('DOMAIN') == $siteRoot->domain) || $isPersonal) {
            return $next($request);
        }

        if (!$siteOrigin) {
            $http = getSchema();

            $domainRoot = main_domain(env('DOMAIN'));
            $siteRootDomain = $this->getSite($domainRoot);

            if (!$siteRootDomain) {
                $domainRoot = $siteRoot->domain;
            } else {
                $domainRoot = $siteRootDomain->domain;
            }

            forget(SiteTrait::getSiteCacheKey());

            return redirect($http . $domainRoot . '/404');
        }

        $siteCache = Cache::get(SiteTrait::getSiteCacheKey());
        $error = null;

        if ($siteCache->siteDomain && $siteCache->siteDomain->language) {
            $alias = $siteCache->siteDomain->language->alias;
            App::setLocale($alias);
        }


        if (!$siteCache) {
            $domain = Domain::query()->where('name', main_domain(env('DOMAIN')))->first();

            if ($domain) {

                $siteCache = $request->session()->get('site');

                if (!$siteCache) {
                    $site = Site::whereDomain(env('DOMAIN'))->get()->first();

                    if (!$site) {
                        $error = 'Сайт не найден...';
                    } else {

                        remember(SiteTrait::getSiteCacheKey(), function () use ($site) {
                            return $site;
                        });

                        $request->session()->put('site', $site);
                    }
                }

            } else {
                $error = 'Сайт не найден...';
            }
        } else {
            $request->session()->put('site', $siteCache);
        }

        if (!$error) {
            return $next($request);
        } else {
            return $next($request)->setContent(error404($error, true));
        }
    }
}
