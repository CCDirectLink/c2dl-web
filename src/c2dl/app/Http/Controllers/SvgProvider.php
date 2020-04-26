<?php

namespace App\Http\Controllers;

use App\DTO\SvgRequest;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Iterable_;

class SvgProvider extends Controller
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
     * Provide svg image
     *
     * @param $svg Iterable Svg request
     * @return string Svg Content
     */
    static public function provide($svg): string
    {
        $svgRequest = new SvgRequest($svg);

        if ((is_null($svgRequest->path)) || (preg_match('~(\.\.[\\\/])~', $svgRequest->path))) {
            return '';
        }

        if (BrowserController::isTextBrowser()) {
            if (is_null($svgRequest->alt)) {
                return '';
            }
            return '<span>'. $svgRequest->alt .'</span>';
        }

        $svg = new \DOMDocument();

        try {
            $svg->load(base_path('resources/images/svg/' . $svgRequest->path));
        } catch (\Throwable $e) {
            return '';
        }

        if (!is_null($svgRequest->class)) {
            $svg->documentElement->setAttribute('class', $svgRequest->class);
        }
        if (!is_null($svgRequest->id)) {
            $svg->documentElement->setAttribute('id', $svgRequest->id);
        }
        if (!is_null($svgRequest->title)) {
            $svg->documentElement->setAttribute('title', $svgRequest->title);
        }
        if (!is_null($svgRequest->width)) {
            $svg->documentElement->setAttribute('width', $svgRequest->width);
        }
        if (!is_null($svgRequest->height)) {
            $svg->documentElement->setAttribute('height', $svgRequest->height);
        }

        return $svg->saveXML($svg->documentElement);
    }
}
