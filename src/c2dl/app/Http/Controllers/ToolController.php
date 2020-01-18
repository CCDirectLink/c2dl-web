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

    static public function getToolList()
    {
        $list = [];

        try {
            $mod_list_raw = file_get_contents(
                'https://raw.githubusercontent.com/CCDirectLink/CCModDB/master/tools.json'
            );
            $mod_list_json = json_decode($mod_list_raw, true);
        }
        catch (\Throwable $e)
        {
            return [];
        }

        if (!isset($mod_list_json['tools'])) {
            return [];
        }

        foreach ($mod_list_json['tools'] as $mod) {
            array_push($list, new \App\DTO\DataEntry($mod));
        }

        return $list;
    }

    /**
     * Show the tool view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $tool_list = ToolController::getToolList();

        return view('tools', ['title' => 'CCDirectLink - CrossCode Tools', 'tool_list' => $tool_list]);
    }
}
