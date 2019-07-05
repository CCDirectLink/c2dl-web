<?php

    require_once( getenv('C2DL_SYS_PAGE', true) . '/Page.php' );
    require_once( getenv('C2DL_SYS', true) . '/Redirect.php' );
    require_once( getenv('C2DL_SYS', true) . '/Service.php' );

    use c2dl\sys\redirect\Redirect;
    use c2dl\sys\service\Service;
    use c2dl\sys\page\Page;

    // redirect
    $redirectEntry = null;

    if (Service::inArray('id', $_GET)) {
        $redirectEntry = $_GET['id'];
    }

    $redirect = new Redirect($redirectEntry);
    $redirect->redirect();

    // html templates

    if (Service::stringsEqual($redirectEntry, 'mods')) {
        $title = 'CrossCode Mods';
        $pageEntry = 'mods';
        $pageCb = function($document) {
            $document->querySelector('#mod-list li')->setAttribute('data-template', '');
        };
        $cbDone = function($document) {

            $modListData = [];

            try {
                $modJson = file_get_contents('https://raw.githubusercontent.com/CCDirectLink/CCModDB/master/mods.json');
                $modJson = json_decode($modJson, true);
                if (Service::inArray('mods', $modJson)) {
                    foreach ($modJson['mods'] as $entry) {
                        if ((Service::inArray('archive_link', $entry)) &&
                            (Service::inArray('name', $entry)) &&
                            (Service::inArray('description', $entry))  &&
                            (Service::inArray('version', $entry))) {

                            $entryData = [];
                            if (Service::inArray('page', $entry)) {
                                foreach ($entry['page'] as $pageEntry) {
                                    $entryData['page_' . $pageEntry['name']] = $pageEntry['url'];
                                }
                            }

                            $entryData = array_merge($entryData, [
                                'download' => $entry['archive_link'],
                                'title' => $entry['name'],
                                'description' => $entry['description'],
                                'version' => $entry['version'],
                                'license' => Service::inArray('license', $entry) ? $entry['license'] : '(None)',
                                'hash' => $entry['hash']['sha256'],
                            ]);

                            array_push($modListData, $entryData);
                        }
                    }
                }
            }
            catch (Error $err) {

            }

            // bind data
            $document->getElementById('mod-list')->bindList($modListData);

        };
    }
    else if (Service::stringsEqual($redirectEntry, 'news')) {
        $title = 'CrossCode Community News';
        $newsPage = null;

        if (Service::inArray('p', $_GET)) {
            $newsPage = $_GET['p'];
        }

        $pageCb = function($document) {};
        $cbDone = function($document) {};

        if (Service::stringsEqual($newsPage, 'welcome')) {
            $pageEntry = 'news/welcome';
            $style = 'news';
        }
        else if (Service::stringsEqual($newsPage, 'contributing')) {
            $pageEntry = 'news/contributing';
            $style = 'news';
        }
        else {
            $pageEntry = 'news';
        }
    }
    else if (Service::stringsEqual($redirectEntry, 'team')) {
        $title = 'C2DL Team';
        $teamPage = null;

        if (Service::inArray('p', $_GET)) {
            $teamPage = $_GET['p'];
        }

        $pageCb = function($document) {};
        $cbDone = function($document) {};

        if (Service::stringsEqual($teamPage, 'ac')) {
            $pageEntry = 'team/ac';
            $style = 'team';
        }
        else if (Service::stringsEqual($teamPage, 'ichi')) {
            $pageEntry = 'team/ichi';
            $style = 'team';
        }
        else if (Service::stringsEqual($teamPage, 'keanu')) {
            $pageEntry = 'team/keanu';
            $style = 'team';
        }
        else if (Service::stringsEqual($teamPage, 'mr')) {
            $pageEntry = 'team/mr';
            $style = 'team';
        }
        else {
            $pageEntry = 'team';
        }
    }
    else if (Service::stringsEqual($redirectEntry, 'discord')) {
        $title = 'CrossCode Modding Discord';
        $pageCb = function($document) {};
        $cbDone = function($document) {};

        $pageEntry = 'discord';
    }
    else {
        $title = 'CCDirectLink - CrossCode Community group';
        $pageEntry = 'main';
        $pageCb = function($document) {
            $document->querySelector('#uri-list li')->setAttribute('data-template', '');
        };
        $cbDone = function($document) {
            // Link list

            $uriListData = [
                ['href' => 'https://store.steampowered.com/app/368340/CrossCode/', 'title' => 'Steam Page'],
                ['href' => 'https://cross-code.com/en/home', 'title' => 'CrossCode-Website'],
                ['href' => 'https://discord.gg/crosscode', 'title' => 'CrossCode Discord'],
                ['href' => 'https://github.com/CCDirectLink', 'title' => 'CCDirectLink GitHub'],
                ['href' => 'https://gitlab.com/CCDirectLink', 'title' => 'CCDirectLink GitLab'],
            ];

            // bind data
            $document->getElementById('uri-list')->bindList($uriListData);
        };
    }

    $page = new Page(null, $pageEntry, $pageEntry);

    // theme selector
    $theme = 'light';

    if (Service::inArrayIsString('theme', $_GET,'dark', false)) {
        $theme = 'dark';
    }

    if (!isset($style)) {
        $style = $pageEntry;
    }

    $document = $page->genrate($title, $theme, $style, $pageCb, $cbDone);
    echo $document->__toString();

?>
