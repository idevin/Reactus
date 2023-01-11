<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\Response;
use App\Traits\Utils;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Api
{
    use Response;
    use Utils;
    use Utils;

    private static function error($data)
    {
        if (\Request::isXmlHttpRequest()) {

            $response = new class {
                use Response;
            };

            return $response->error($data['error']);
        } else {
            return response($data, 401);
        }
    }

    /**
     * For ['middleware'=>'api'] routes
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @internal param null|string $guard
     */
    #[NoReturn]
    public function handle(Request $request, Closure $next): mixed
    {
        $token = self::getToken($request);

        $data = [
            'error' => 'Вы не авторизированы...',
            'success' => false,
            'notice' => ''
        ];

        if (!$token) {
            return static::checkXmlHttpRequest($data);
        } else {
            $user = User::whereAuthToken($token)->first();

            if (!$user) {
                return static::error($data);
            } else {
                $request->request->set('user', $user);
                Auth::login($user, true);
            }

            return $next($request);
        }
    }
}
