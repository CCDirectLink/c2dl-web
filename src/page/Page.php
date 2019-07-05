<?php  namespace c2dl\sys\page;

require_once( getenv('C2DL_SYS_PAGE', true) . '/vendor/autoload.php' );

use Gt\DomTemplate\HTMLDocument;

class Page {

    private $name;
    private $fileName;
    private $pageData;

    public function __construct($html, $name, $fileName = 'main') {

        if (!isset($html)) {
            $html = file_get_contents(getenv('C2DL_WWW_RES', true) . '/template/base.html');
        }

        $this->html = $html;
        $this->name = $name;
        $this->fileName = $fileName;
        $this->pageData = file_get_contents(getenv('C2DL_WWW_RES', true) .
            '/template/page/' . $this->fileName . '.html');
    }

    public function genrate($title, $theme, $style, $cb, $cbDone) {
        // prepare templates
        $document = new HTMLDocument($this->html, getenv('C2DL_WWW_RES') .
            '/template/_component');

        $document->querySelector('title')->innerHTML = $title;
        $document->querySelector('main')->innerHTML = $this->pageData;
        $htmlHeadContent = $htmlHead = $document->querySelector('head')->innerHtml;

        // set themes
        $htmlHeadContent = $htmlHeadContent . '<link rel="stylesheet" type="text/css" name="theme"
        href="/res/style/colorset/' . $theme . '.css" media="all" id="theme-css"/>';
        $htmlHeadContent = $htmlHeadContent . '<link rel="stylesheet" type="text/css" name="www-main"
            href="/res/style/page/' . $style . '.css" media="all" id="www-main-css"/>';
        $htmlHead = $document->querySelector('head')->innerHtml = $htmlHeadContent;

        $document->expandComponents();
        // Workaround: data-template not working for expandComponents
        $cb($document);
        $document->extractTemplates();
        $cbDone($document);

        return $document;
    }

}
