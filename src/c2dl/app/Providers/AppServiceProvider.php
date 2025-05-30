<?php

namespace App\Providers;

use App\Http\Controllers\BrowserController;
use App\Http\ViewComposers\ColorsetComposer;
use Illuminate\Cookie\Middleware\EncryptCookies;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {

        EncryptCookies::except('c2dl_colorset');

        // Color set
        view()->composer('*', ColorsetComposer::class);

        // Components
        Blade::aliasComponent('components.newscard', 'newscard');
        Blade::aliasComponent('components.pageheader', 'pageheader');
        Blade::aliasComponent('components.icons', 'icons');

        Blade::aliasComponent('components.menudrawer', 'menudrawer');
        Blade::aliasComponent('components.menucontainer', 'menucontainer');

        Blade::aliasComponent('components.modentry', 'modentry');
        Blade::aliasComponent('components.toolentry', 'toolentry');

        Blade::aliasComponent('components.teamcard', 'teamcard');
        Blade::aliasComponent('components.socialcard', 'socialcard');

        Blade::if('isNotTextBrowser', function () {
            return !BrowserController::isTextBrowser();
        });
    }
}
