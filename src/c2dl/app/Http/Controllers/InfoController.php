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

    static public function adminList()
    {
        $admin_list = [
            new \App\DTO\User([ 0, 'Nnubes256', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li>'.
                '<li>CrossCode Discord Mod</li></ul>' ]),
            new \App\DTO\User([ 1, '2767mr', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li></ul>' ]),
            new \App\DTO\User([ 2, 'ac2pic', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li></ul>' ]),
            new \App\DTO\User([ 3, 'omega12', '<ul><li>CCDirectLink Admin</li><li>c2dl.info Management</li></ul>' ]),
            new \App\DTO\User([ 4, 'Streetclaw', '<ul><li>CCDirectLink Admin</li>' .
                    '<li>c2dl.info Host & Management</li><li>CrossCode Discord Mod</li></ul>' ]),
        ];

        return $admin_list;
    }

    static public function publicMemberList()
    {
        $public_member_list = [
            new \App\DTO\User([ 0, 'Keanu', '<ul><li>CCDirectLink Member</li><li>c2dl.info Management</li></ul>' ]),
            new \App\DTO\User([ 1, 'dmitmel', 'CCDirectLink Member' ]),
            new \App\DTO\User([ 2, 'Vankerkom', 'CCDirectLink Member' ]),
        ];

        return $public_member_list;
    }

    /**
     * Show the about view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        $team_list = [
            'admin' => InfoController::adminList(),
            'publicMember' => InfoController::publicMemberList(),
        ];

        return view('about', ['team_list' => $team_list]);
    }

    /**
     * Show the impressum view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function impressum()
    {
        return view('impressum');
    }

    /**
     * Show the privacy view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function privacy()
    {
        return view('privacy');
    }
}
