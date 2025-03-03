<?php

namespace App\Http\Controllers;

use App\DTO\ModInfo;
use Illuminate\Contracts\Support\Renderable;

class ModController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public static function getModList(int $page = 1): ModInfo
    {
        try {
            $mod_list_raw = file_get_contents(
                'https://raw.githubusercontent.com/CCDirectLink/CCModDB/stable/npDatabase.min.json'
            );
            $mod_list_json = json_decode($mod_list_raw, true);
        }
        catch (\Throwable $e)
        {
            return new ModInfo();
        }

        return new ModInfo($mod_list_json, $page);
    }

    /**
     * Show mods
     *
     * @param int $page
     * @return Renderable
     */
    public function show(int $page = 1) : Renderable
    {
        $result = ModController::getModList($page);

        return view('mods', ['mod_info' => $result]);
    }
}
