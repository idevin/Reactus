<?php

namespace App\Http\Middleware;

use App\Traits\Response;
use Closure;
use Illuminate\Http\Request;

class UserMatches
{
    use Response;

    /**
     * For ['middleware'=>'user_matches'] routes
     *
     * @param  Request $request
     * @param Closure $next
     * @return mixed
     * @internal param null|string $guard
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->get('user');
        $domain = env('DOMAIN');

        if(!$user) {
            return $this->error('Вы должны быть авторизированы для этого действия');
        }

        if ($user->domain != $domain) {
            return $this->error('Вы не можете управлять другим профайлом');
        }
        return $next($request);
    }
}
