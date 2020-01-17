<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModController extends Controller
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

    static public function getModList()
    {
        $list = [];

        $mod_list_raw = file_get_contents(
            'https://raw.githubusercontent.com/CCDirectLink/CCModDB/master/mods.json'
        );

        $mod_list_json = json_decode($mod_list_raw, true);

        if (!isset($mod_list_json['mods'])) {
            return [];
        }

        foreach ($mod_list_json['mods'] as $mod) {
            array_push($list, new \App\DTO\DataEntry($mod));
        }

        return $list;
    }

    /**
     * Show the mod view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $mod_list = ModController::getModList();

        return view('mods', ['title' => 'CCDirectLink - CrossCode Mods', 'mod_list' => $mod_list]);
    }
}
