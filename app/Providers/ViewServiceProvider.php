<?php

namespace App\Providers;

use App\Category;
use App\Settings;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
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
        $settings = Settings::where('key', 'like', 'seo_%')->get();

        config()->set('seotools.meta.defaults.title',
            $settings->where('key', 'seo_title')->first()->value ?? config('app.name', 'TopSite'));

        SEOTools::setDescription($settings->where('key',
                'seo_description')->first()->value ?? 'No description given');

        View::composer([
            'layouts.app'
        ], function ($view) {
            $view->with('categories', Category::all());
        });
    }
}
