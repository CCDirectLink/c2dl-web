<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the home view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        return view('home');
    }
}
