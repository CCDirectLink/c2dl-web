<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ColorsetComposer
{

    public function compose(View $view): void
    {
        $cookie_colorset = request()->cookie('c2dl_colorset', 'system');
        if ($cookie_colorset == 'dark') {
            $view->with('colorset', 'c2dl-colorset-dark');
        } else if ($cookie_colorset == 'light') {
            $view->with('colorset', 'c2dl-colorset-light');
        } else {
            $view->with('colorset', 'c2dl-colorset-system');
        }

    }

}
