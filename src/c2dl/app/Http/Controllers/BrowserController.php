<?php

namespace App\Http\Controllers;

class BrowserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * True if text browser
     *
     * @return boolean Text Browser
     */
    public static function isTextBrowser(): bool
    {
        $_userAgent = request()->header('user-agent');
        if (preg_match('~^((E)?Links|Lynx|w3m)~', $_userAgent)) {
            return true;
        }
        return false;
    }
}
