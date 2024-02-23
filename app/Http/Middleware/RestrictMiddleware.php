<?php

namespace App\Http\Middleware;

use App;

use Closure;

class RestrictMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action

        $response = $next($request);

        // Post-Middleware Action

        return $response;

        $restrictedIps = ['127.0.0.1', '102.129.158.0'];
        if(in_array($request->ip(), $restrictedIps)){
          App::abort(403, 'Request forbidden');
        }
        return $next($request);
    }


}
