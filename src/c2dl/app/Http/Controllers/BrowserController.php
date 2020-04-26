<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrowserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Trrue if text brrowser
     *
     * @return boolean Text Browser
     */
    static public function isTextBrowser()
    {
        $_userAgent = request()->header('user-agent');
        if (preg_match('~^((E)?Links|Lynx|w3m)~', $_userAgent)) {
            return true;
        }
        return false;
    }
}
