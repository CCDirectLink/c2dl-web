<?php

namespace App\Http\Controllers;

use App\DTO\ModInfo;
use Illuminate\Contracts\Support\Renderable;

class ToolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public static function getToolList(int $page = 1): ModInfo
    {
        try {
            $tool_list_raw = file_get_contents(
                'https://raw.githubusercontent.com/CCDirectLink/CCModDB/stable/tools.json'
            );
            $tool_list_json = json_decode($tool_list_raw, true);
        }
        catch (\Throwable $e)
        {
            return new ModInfo();
        }

        return new ModInfo($tool_list_json, $page);
    }

    /**
     * Show tools
     *
     * @return Renderable
     */
    public function show() : Renderable
    {
        $result = ToolController::getToolList();

        return view('tools', ['tool_info' => $result]);
    }
}
