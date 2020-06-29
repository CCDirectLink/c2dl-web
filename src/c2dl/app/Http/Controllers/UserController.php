<?php

namespace App\Http\Controllers;
use App\Models\User;

class UserController extends Controller
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

    static public function getUser(int $userId = 0): ?\App\DTO\User
    {
        if ($userId == 0) {
            return new \App\DTO\User([ null, 'CCDirectLink' ]);
        }

        $_userList = User::where('active', 1)
            ->where('user_id', $userId)->get();

        if (sizeof($_userList) > 1) {
            throw new \Error('Multiple entries found');
        }

        if (sizeof($_userList) != 1) {
            return null;
        }

        if (isset($_userList[0])) {
            $_id = $_userList[0]->user_id;
            $_name = $_userList[0]->name;

            return new \App\DTO\User([ $_id, $_name ]);
        }

    }
}
