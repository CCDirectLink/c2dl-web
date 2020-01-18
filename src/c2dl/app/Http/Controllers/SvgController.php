<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SvgController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the svg image
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, string $svg, array $rules = null, callable $replace = null)
    {
        $query = $request->query();

        if (is_callable($replace)) {
            $query = $replace($query);
        }
        else {
            $query = preg_replace('/_/u', '#', $query);
        }

        if (!isset($rules)) {
            $rules = [
                'fg' => ['nullable', "regex:/(^([ a-zA-z0-9\.\,\'\(\)\_]+)$)/u"],
                'bg' => ['nullable', "regex:/(^([ a-zA-z0-9\.\,\'\(\)\_]+)$)/u"],
                'height' => ['nullable', "regex:/(^([0-9\.]+)(\%|px|pt|pc|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in)$)/u"],
                '$width' => ['nullable', "regex:/(^([0-9\.]+)(\%|px|pt|pc|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in)$)/u"],
            ];
        }

        try {
            $this->validate($request, $rules);
        }
        catch (\Throwable $e) {
            $query = [];
        }

        return response()->view('svgdata.' . $svg, $query, 200)->
        header('Content-Type', 'image/svg+xml');
    }
}
