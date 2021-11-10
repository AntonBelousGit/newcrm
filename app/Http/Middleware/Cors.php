<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, DELETE','PATCH','OPTIONS');
        $response->header('Access-Control-Allow-Headers', "Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, X-CSRF-TOKEN ,Access-Control-Request-Method, Access-Control-Request-Headers,X-Auth-Token, Authorization,");

        return $response;
    }
}
