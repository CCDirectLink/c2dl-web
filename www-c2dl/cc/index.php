<?php

    require_once( getenv('C2DL_SYS_PAGE', true) . '/Page.php' );
    require_once( getenv('C2DL_SYS', true) . '/service/Redirect.php' );
    require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php' );

    use c2dl\sys\redirect\Redirect;
    use c2dl\sys\service\GeneralService;
    use c2dl\sys\page\Page;

    // redirect
    $redirectEntry = null;

    if (GeneralService::inArray('id', $_GET)) {
        $redirectEntry = $_GET['id'];
        Redirect::redirect($redirectEntry);
    }

    // html templates

    if (GeneralService::stringsEqual($redirectEntry, 'mods')) {
        $title = 'CrossCode Mods';
        $pageEntry = 'mods';
        $pageCb = function($document) {
            $document->querySelector('#mod-list li')->setAttribute('data-template', '');
        };
        $cbDone = function($document) {

            $modListData = [];

            try {
                $modJson = file_get_contents(
                    'https://raw.githubusercontent.com/CCDirectLink/CCModDB/master/mods.json'
                );
                $modJson = json_decode($modJson, true);
                if (GeneralService::inArray('mods', $modJson)) {
                    foreach ($modJson['mods'] as $entry) {
                        if ((GeneralService::inArray('archive_link', $entry)) &&
                            (GeneralService::inArray('name', $entry)) &&
                            (GeneralService::inArray('description', $entry))  &&
                            (GeneralService::inArray('version', $entry))) {

                            $entryData = [];
                            if (GeneralService::inArray('page', $entry)) {
                                foreach ($entry['page'] as $pageEntry) {
                                    $entryData['page_' . $pageEntry['name']] = $pageEntry['url'];
                                }
                            }

                            $entryData = array_merge($entryData, [
                                'download' => $entry['archive_link'],
                                'title' => $entry['name'],
                                'description' => $entry['description'],
                                'version' => $entry['version'],
                                'license' => GeneralService::inArray('license', $entry) ? $entry['license'] : '(None)',
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
    else if (GeneralService::stringsEqual($redirectEntry, 'tools')) {
        $title = 'CrossCode Tools';
        $pageEntry = 'tools';
        $pageCb = function($document) {
            $document->querySelector('#mod-list li')->setAttribute('data-template', '');
        };
        $cbDone = function($document) {

            $toolListData = [];

            try {
                $toolsJson = file_get_contents(
                    'https://raw.githubusercontent.com/CCDirectLink/CCModDB/master/tools.json'
                );
                $toolsJson = json_decode($toolsJson, true);
                if (GeneralService::inArray('tools', $toolsJson)) {
                    foreach ($toolsJson['tools'] as $entry) {
                        if ((GeneralService::inArray('archive_link', $entry)) &&
                            (GeneralService::inArray('name', $entry)) &&
                            (GeneralService::inArray('description', $entry))  &&
                            (GeneralService::inArray('version', $entry))) {

                            $entryData = [];
                            if (GeneralService::inArray('page', $entry)) {
                                foreach ($entry['page'] as $pageEntry) {
                                    $entryData['page_' . $pageEntry['name']] = $pageEntry['url'];
                                }
                            }

                            $entryData = array_merge($entryData, [
                                'download' => $entry['archive_link'],
                                'title' => $entry['name'],
                                'description' => $entry['description'],
                                'version' => $entry['version'],
                                'license' => GeneralService::inArray('license', $entry) ? $entry['license'] : '(None)',
                                'hash' => $entry['hash']['sha256'],
                            ]);

                            array_push($toolListData, $entryData);
                        }
                    }
                }
            }
            catch (Error $err) {

            }

            // bind data
            $document->getElementById('mod-list')->bindList($toolListData);

        };
    }
    else if (GeneralService::stringsEqual($redirectEntry, 'news')) {
        $title = 'CrossCode Community News';
        $newsPage = null;

        if (GeneralService::inArray('p', $_GET)) {
            $newsPage = $_GET['p'];
        }

        $pageCb = function($document) {};
        $cbDone = function($document) {};

        if (GeneralService::stringsEqual($newsPage, 'welcome')) {
            $pageEntry = 'news/welcome';
            $style = 'news';
        }
        else if (GeneralService::stringsEqual($newsPage, 'contributing')) {
            $pageEntry = 'news/contributing';
            $style = 'news';
        }
        else {
            $pageEntry = 'news';
        }
    }
    else if (GeneralService::stringsEqual($redirectEntry, 'team')) {
        $title = 'C2DL Team';
        $teamPage = null;

        if (GeneralService::inArray('p', $_GET)) {
            $teamPage = $_GET['p'];
        }

        $pageCb = function($document) {};
        $cbDone = function($document) {};

        if (GeneralService::stringsEqual($teamPage, 'ac')) {
            $pageEntry = 'team/ac';
            $style = 'team';
        }
        else if (GeneralService::stringsEqual($teamPage, 'ichi')) {
            $pageEntry = 'team/ichi';
            $style = 'team';
        }
        else if (GeneralService::stringsEqual($teamPage, 'keanu')) {
            $pageEntry = 'team/keanu';
            $style = 'team';
        }
        else if (GeneralService::stringsEqual($teamPage, 'mr')) {
            $pageEntry = 'team/mr';
            $style = 'team';
        }
        else if (GeneralService::stringsEqual($teamPage, 'streetclaw')) {
            $pageEntry = 'team/streetclaw';
            $style = 'team';
        }
        else {
            $pageEntry = 'team';
        }
    }
    else if (GeneralService::stringsEqual($redirectEntry, 'login')) {
        $title = 'C2DL Login';

        $pageCb = function($document) {};
        $cbDone = function($document) {};

        $pageEntry = 'login';
        $style = 'login';
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

    if (GeneralService::inArrayIsString('theme', $_GET,'dark', false)) {
        $theme = 'dark';
    }

    if (!isset($style)) {
        $style = $pageEntry;
    }

    $document = $page->generate($title, $theme, $style, $pageCb, $cbDone);
    echo $document->__toString();

?>
