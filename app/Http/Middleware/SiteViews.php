<?php

namespace App\Http\Middleware;

use App\Traits\Domain;
use App\Traits\Response;
use Closure;
use Cookie;


class SiteViews
{
    use Response;
    use Domain;

    public function handle($request, Closure $next)
    {
        $cName = '__n_v__';
        $response = $next($request);


        if (!$request->cookie($cName)) {
            $secure = self::secureCookie();
            $cookie = Cookie::make($cName, 1, 2628000, '/', '.' . env('DOMAIN'),
                $secure[0], true, false, $secure[1]);

            $response->withCookie($cookie);

            $site = get_site();

            if ($site) {
                $site->increment('views');
            }
        }

        return $response;
    }
}