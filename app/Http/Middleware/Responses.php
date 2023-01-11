<?php

namespace App\Http\Middleware;

use App\Traits\Response;
use Closure;

class Responses
{
    use Response;

    public function handle($request, Closure $next)
    {
        /**
         * @todo обработка заголовков ошибок для постмана
         */
        if (php_sapi_name() != 'cli') {
            if ($request->headers->get('postman-token')) {
                return $next($request);
            }
        }

        return $next($request);
    }
}