<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the home view
     *
     * @return Renderable
     */
    public function show(): Renderable
    {
        return view('home');
    }
}
