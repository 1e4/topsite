<?php

namespace App\Providers;

use App\Game;
use App\Observers\GameObserver;
use App\Settings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Game::observe(GameObserver::class);

        View::composer([
            'layouts/admin.blade.php',
            'layouts/app.blade.php',
        ], function($view) {
            $view->share('title', Settings::where('key', 'site_name')->first()->value);
        });

    }
}
