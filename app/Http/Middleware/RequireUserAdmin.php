<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireUserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            abort(404);
        }

        return $next($request);
    }
}
