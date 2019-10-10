<?php

namespace App\Providers;

use App\Category;
use App\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'layouts.admin',
            'layouts.app',
        ], function ($view) {
            $view->with('title', Settings::where('key', 'site_name')->first()->value);
        });

        View::composer([
            'layouts.app'
        ], function ($view) {
            $view->with('categories', Category::all());
        });
    }
}
