<?php

namespace App\Http\Middleware;

use App\Settings;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSiteIsOnline
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

        if(Settings::where('key', 'site_online')->first()->value === '1' || ($request->user() && $request->user()->isAdmin()))
        {
            if($request->user()->isAdmin())
                flash("Site is currently offline and only available to administrators")->error();

            return $next($request);
        }

        if(!$request->routeIs('login'))
            return redirect('login');

        return abort(503);
    }
}
