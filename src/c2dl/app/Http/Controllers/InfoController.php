<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
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

    static public function teamList()
    {
        $team_list = [
            new \App\DTO\User([ 0, 'Streetclaw', '<ul><li>CCDirectLink Admin</li>' .
                    '<li>c2dl.info Host & Developer</li><li>CrossCode Discord Mod</li></ul>' ]),
            new \App\DTO\User([ 1, 'Keanu', 'c2dl.info Admin & Developer' ]),
            new \App\DTO\User([ 2, 'ac2pic', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li></ul>' ]),
            new \App\DTO\User([ 3, '2767mr', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li></ul>' ]),
            new \App\DTO\User([ 4, 'Nnubes256', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li>'.
                '<li>CrossCode Discord Mod</li></ul>' ]),
            new \App\DTO\User([ 5, 'omega12', 'CCDirectLink Admin' ]),
            new \App\DTO\User([ 6, 'Polliwham', 'CCDirectLink Admin' ])
        ];

        return $team_list;
    }

    /**
     * Show the about view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        $team_list = InfoController::teamList();

        return view('about', ['title' => 'About CCDirectLink', 'team_list' => $team_list]);
    }

    /**
     * Show the impressum view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function impressum()
    {
        return view('impressum', ['title' => 'CCDirectLink - CrossCode Impressum']);
    }

    /**
     * Show the privacy view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function privacy()
    {
        return view('privacy', ['title' => 'CCDirectLink - About Privacy']);
    }
}
