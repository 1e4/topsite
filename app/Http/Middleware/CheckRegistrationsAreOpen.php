<?php

namespace App\Http\Middleware;

use Closure;

class CheckRegistrationsAreOpen
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
        if(env('REGISTRATIONS_OPEN') === false)
            return abort(503);

        return $next($request);
    }
}
