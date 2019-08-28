<?php namespace c2dl\sys\redirect;

require_once( getenv('C2DL_SYS', true) . '/repository/Redirect.php');

use c2dl\sys\db;

class Redirect {

    static public function redirectData($entry): iterable {
        $_redirect = db\Redirect::getInstance();

        $_result = array(
            'valid' => false,
            'entry' => null,
            'url' => null,
        );

        if (!isset($entry)) {
            $_result['error'] = 'No Entry';
            return $_result;
        }

        $_data = $_redirect->hasRedirect($entry);

        $_result['url'] = $_data['url'];
        $_result['entry'] = $_data['entry'];

        if ($_data['url'] === null) {
            $_result['error'] = 'Entry not found';
        }

        return $_result;
    }

    static public function redirect($entry): void {
        $_redirect = self::redirectData($entry);

        if ($_redirect['url'] !== null) {
            self::_redirectTo($_redirect['url']);
        }
    }

    static private function _redirectTo($url): void {
        header('Location: '. $url, true, 302);
        exit;
    }

}
