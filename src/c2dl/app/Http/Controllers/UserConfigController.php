<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

class UserConfigController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Redirect to home
     *
     * @return RedirectResponse
     */
    public function colorset(): RedirectResponse
    {
        $_cookie_colorset = request()->query('name');
        $_colorset = 'system';
        if ($_cookie_colorset == 'dark') {
            $_colorset = $_cookie_colorset;
        } else if ($_cookie_colorset == 'light') {
            $_colorset = $_cookie_colorset;
        }
        return redirect('/cc')->cookie('c2dl_colorset', $_colorset, 31536000, null, null, null, false);
    }

}
