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
        $pageEntry = 'mods';
        $pageCb = function($document) {
            $document->querySelector('#modList ul li')->setAttribute('data-template', '');
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
                                'href' => $entry['archive_link'],
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
            $document->getElementById('modList')->bindList($modListData);

        };
    }
    else {
        $pageEntry = 'main';
        $pageCb = function($document) {
            $document->querySelector('#mainUriList ul li')->setAttribute('data-template', '');
        };
        $cbDone = function($document) {
            // Link list

            $uriListData = [
                ['href' => 'https://store.steampowered.com/app/368340/CrossCode/', 'title' => 'Steam Page'],
                ['href' => 'https://cross-code.com/en/home', 'title' => 'CrossCode-Website'],
                ['href' => 'https://discord.gg/crosscode', 'title' => 'CrossCode Discord'],
                ['href' => 'https://discord.gg/TFs6n5v', 'title' => 'CrossCode Modding Discord'],
                ['href' => 'https://github.com/CCDirectLink', 'title' => 'CCDirectLink GitHub'],
                ['href' => 'https://gitlab.com/CCDirectLink', 'title' => 'CCDirectLink GitLab'],
            ];

            // bind data
            $document->getElementById('mainUriList')->bindList($uriListData);
        };
    }

    $page = new Page(null, $pageEntry, $pageEntry);

    // theme selector
    $theme = 'light';

    if (Service::inArrayIsString('theme', $_GET,'dark', false)) {
        $theme = 'dark';
    }

    $document = $page->genrate($theme, $pageEntry, $pageCb, $cbDone);
    echo $document->__toString();

?>
