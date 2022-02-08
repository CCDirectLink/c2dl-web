<?php

namespace App\Http\Controllers;

use App\DTO\User;

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
            new User(0, 'Nnubes256', ['CCDirectLink admin', 'c2dl.info management', 'CrossCode Discord moderator']),
            new User(1, '2767mr', ['CCDirectLink admin', 'c2dl.info management']),
            new User(2, 'ac2pic', ['CCDirectLink admin', 'c2dl.info management']),
            new User(3, 'omega12', ['CCDirectLink admin', 'c2dl.info management']),
            new User(4, 'Streetclaw', ['CCDirectLink admin', 'c2dl.info management', 'CrossCode Discord moderator']),
        ];

        return $admin_list;
    }

    static public function publicMemberList()
    {
        $public_member_list = [
            new User(0, 'Keanu', ['CCDirectLink member', 'c2dl.info management']),
            new User(1, 'dmitmel', 'CCDirectLink member'),
            new User(2, 'Vankerkom', 'CCDirectLink member'),
            new User(3, 'Alwinfy', ['CCDirectLink member', 'Article editor']),
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
