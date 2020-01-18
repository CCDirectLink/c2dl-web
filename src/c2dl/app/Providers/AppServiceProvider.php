<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return base_path().'/public/www-c2dl';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Components
        Blade::component('components.newscard', 'newscard');
        Blade::component('components.pageheader', 'pageheader');

        Blade::component('components.menudrawer', 'menudrawer');
        Blade::component('components.menucontainer', 'menucontainer');

        Blade::component('components.dataentry', 'dataentry');
        Blade::component('components.teamcard', 'teamcard');
        Blade::component('components.socialcard', 'socialcard');

        // Svg
        Blade::component('svgdata.hamburger', 'hamburgersvg');
    }
}
