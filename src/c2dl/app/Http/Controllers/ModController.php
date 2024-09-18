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

    static public function getModList(int $page = 1): \App\DTO\ModInfo
    {
        try {
            $mod_list_raw = file_get_contents(
                'https://raw.githubusercontent.com/CCDirectLink/CCModDB/stable/npDatabase.min.json'
            );
            $mod_list_json = json_decode($mod_list_raw, true);
        }
        catch (\Throwable $e)
        {
            return new \App\DTO\ModInfo();
        }

        return new \App\DTO\ModInfo($mod_list_json, $page);
    }

    /**
     * Show mods
     *
     * @param Request $request
     * @param int $news_id
     * @param int $page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request,
                         int $page = 1) : \Illuminate\Contracts\Support\Renderable
    {
        $result = ModController::getModList($page);

        return view('mods', ['mod_info' => $result]);
    }
}
