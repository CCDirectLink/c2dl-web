<?php

    require_once( getenv('C2DL_SYS_PAGE', true) . '/vendor/autoload.php' );
    require_once( getenv('C2DL_SYS', true) . '/Redirect.php' );
    require_once( getenv('C2DL_SYS', true) . '/Service.php' );

    use Gt\DomTemplate\HTMLDocument;
    use c2dl\sys\redirect\Redirect;
    use c2dl\sys\service\Service;

    // redirect
    $redirectEntry = null;

    if (Service::inArray('id', $_GET)) {
        $redirectEntry = $_GET['id'];
    }

    $redirect = new Redirect($redirectEntry);
    $redirect->redirect();

    // html templates
    $html = file_get_contents(getenv('C2DL_WWW_RES', true) . '/template/base.html');
    $main = file_get_contents(getenv('C2DL_WWW_RES', true) . '/template/main.html');

    // prepare templates
    $document = new HTMLDocument($html, getenv('C2DL_WWW_RES') . '/template/_component');
    $document->getElementById('content')->innerHTML = $main;
    $htmlHeadContent = $htmlHead = $document->getElementById('head')->innerHtml;

    // theme selector
    $theme = 'light';

    if (Service::inArrayIsString('theme', $_GET,'dark', false)) {
        $theme = 'dark';
    }

    // set themes
    $htmlHeadContent = $htmlHeadContent . '<link rel="stylesheet" type="text/css" name="theme"
        href="/res/style/colorset/' . $theme . '.css" media="all" id="theme-css"/>';
    $htmlHeadContent = $htmlHeadContent . '<link rel="stylesheet" type="text/css" name="www-main"
            href="/res/style/main.css" media="all" id="www-main-css"/>';
    $htmlHead = $document->getElementById('head')->innerHtml = $htmlHeadContent;

    // build page
    $document->expandComponents();
    // Workaround: data-template not working for expandComponents
    $document->querySelector('#mainUriList ul li')->setAttribute('data-template', '');
    $document->extractTemplates();


    // Link list

    $uriListData = [
        ['href' => 'https://cross-code.com/en/home', 'title' => 'CrossCode-Website'],
        ['href' => 'https://discord.gg/crosscode', 'title' => 'CrossCode Discord'],
        ['href' => 'https://discord.gg/TFs6n5v', 'title' => 'CrossCode Modding Discord'],
        ['href' => 'https://github.com/CCDirectLink', 'title' => 'CCDirectLink GitHub'],
        ['href' => 'https://gitlab.com/CCDirectLink', 'title' => 'CCDirectLink GitLab'],
    ];

    // bind data
    $document->getElementById('mainUriList')->bindList($uriListData);

    echo $document->__toString();

?>
