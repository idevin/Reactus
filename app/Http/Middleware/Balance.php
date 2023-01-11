<?php

namespace App\Http\Middleware;

use App\Traits\Order;
use App\Traits\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Balance
{
    use Response;

    /**
     * For ['middleware'=>'balance']
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @internal param null|string $guard
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $uuid = $request->input('uuid');
        $orderId = $request->input('orderId');

        if (!$request->isJson() && $uuid && $orderId && Auth::user()) {
            /**
             * Обновление баланса
             */
            Order::process($orderId, $uuid);
        }

        return $next($request);
    }
}
