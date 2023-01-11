<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;


class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        $hosts = [];
        $scheme = $request->secure() ? 'https' : 'http';
        $domains = Domain::thematic()->get()->pluck('name');

        foreach ($domains as $name) {
            $hosts[] = "$scheme://$name";
        }

        $response = $next($request);

        if ($request->headers->has('Origin')) {
            $origin = $request->headers->get('Origin');

            if (in_array($origin, $hosts)) {

                $response->headers->set("Access-Control-Allow-Origin", $origin);
                $response->headers->set("Access-Control-Allow-Credentials", "true");

            } else {
                $response->headers->set("Access-Control-Allow-Origin", "*");
            }
        }

        $response->headers->set("Access-Control-Allow-Methods",
            "POST, GET, OPTIONS, PUT, DELETE");

        $response->headers->set("Access-Control-Allow-Headers",
            "Accept, X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization, Content-Length");

        return $response;
    }
}
