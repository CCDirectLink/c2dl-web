<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
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

    static public function getToolList(int $page = 1): \App\DTO\ModInfo
    {
        try {
            $tool_list_raw = file_get_contents(
                'https://raw.githubusercontent.com/krypciak/CCModDB/master/tools.json'
            );
            $tool_list_json = json_decode($tool_list_raw, true);
        }
        catch (\Throwable $e)
        {
            return new \App\DTO\ModInfo();
        }

        return new \App\DTO\ModInfo($tool_list_json, $page);
    }

    /**
     * Show tools
     *
     * @param Request $request
     * @param int $news_id
     * @param int $page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request,
                         int $page = 1) : \Illuminate\Contracts\Support\Renderable
    {
        $result = ToolController::getToolList();

        return view('tools', ['tool_info' => $result]);
    }
}
