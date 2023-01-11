<?php

namespace App\Http\Middleware;

use App\Traits\Response;
use Closure;
use hisorange\BrowserDetect\Parser as BrowserObject;

class Browser
{
    use Response;

    public function handle($request, Closure $next)
    {
        if (php_sapi_name() != 'cli') {
            if (BrowserObject::isIEVersion(8) || BrowserObject::isIEVersion(9) ) {
                return redirect(getSchema() . env('DOMAIN') . '/unsupported-browser');
            }
        }

        return $next($request);
    }
}