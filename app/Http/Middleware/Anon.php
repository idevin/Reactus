<?php

namespace App\Http\Middleware;

use App\Traits\HasRoles;
use App\Traits\Response;
use Auth;
use Closure;
use Illuminate\Http\JsonResponse;
use Route;


class Anon
{
    use HasRoles;
    use Response;

    public function handle($request, Closure $next)
    {
        if (php_sapi_name() != 'cli') {
            if (Auth::guest() && !self::canAnon('site_access')) {
                $currentRoute = isset(Route::current()->action['as']) ?
                    Route::current()->action['as'] : null;

                if (get_class($next($request)) == JsonResponse::class) {

                    if (!in_array($currentRoute, config('app.guest_allowed_routes'))) {

                        if (env('APP_DEBUG_VARS') == true) {
                            debugvars('SITE ACCESS ERROR: ' . $currentRoute);
                        }

                        return $this->error('Site Access');
                    }
                }
            }
        }

        return $next($request);
    }
}