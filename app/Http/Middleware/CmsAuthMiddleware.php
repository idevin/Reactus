<?php

namespace App\Http\Middleware;

use App\Traits\Response;
use App\Traits\Site;
use Auth;
use Closure;

class CmsAuthMiddleware
{
    use Site;
    use Response;

    public function handle($request, Closure $next, $guard = null)
    {
        $defaultDomain = env('DEFAULT_DOMAIN');
        $site = get_site();

        if (!$site) {
            return redirect('/404');
        }

        $siteDomain = idnToAscii($site->domain);

        if ($siteDomain !== $defaultDomain) {
            return redirect('/404');
        }

        if (Auth::guest() || !Auth::user()->superadmin) {
            if ($request->ajax()) {
                return $this->error('Доступ запрещен');
            } else {
                session()->flash('error', 'Вы не авторизированы');
                $params = [];
                return redirect()->guest(route('cms.login', $params));
            }
        }

        return $next($request);
    }
}
