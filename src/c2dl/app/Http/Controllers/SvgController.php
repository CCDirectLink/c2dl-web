<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Contracts\Routing\ResponseFactory;
use \Illuminate\Http\Response;
use \Illuminate\Http\RedirectResponse;
use \Illuminate\Routing\Redirector;

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
     * @return ResponseFactory|Response|RedirectResponse|Redirector
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
                'fg' => ['nullable', "regex:/(^(([ a-zA-z0-9\.\,\'\(\)\_]+)(:([ a-zA-z0-9\.\,\'\(\)\_]+))?)+$)/u"],
                'bg' => ['nullable', "regex:/(^(([ a-zA-z0-9\.\,\'\(\)\_]+)(:([ a-zA-z0-9\.\,\'\(\)\_]+))?)+$)/u"],
                'height' => ['nullable', "regex:/(^([0-9\.]+)(\%|px|pt|pc|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in)$)/u"],
                '$width' => ['nullable', "regex:/(^([0-9\.]+)(\%|px|pt|pc|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in)$)/u"],
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('svgdata.' . $svg)
                ->withErrors($validator)
                ->withInput();
        }

        return response()
            ->view('svgdata.' . $svg, $query, 200)
            ->header('Content-Type', 'image/svg+xml');
    }
}
