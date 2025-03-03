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
    public function __construct() {}

    public static function getUser(int $userId = 0): ?\App\DTO\User
    {
        if ($userId == 0) {
            return new \App\DTO\User(0, 'CCDirectLink');
        }

        $_userList = User::where('active', 1)
            ->where('user_id', $userId)->get();

        if (sizeof($_userList) > 1) {
            throw new \Error('Multiple entries found');
        }

        if ((sizeof($_userList) != 1)
            && (!isset($_userList[0]))) {
            return null;
        }

        $_id = $_userList[0]->user_id;
        $_name = $_userList[0]->name;
        return new \App\DTO\User($_id, $_name);
    }
}
