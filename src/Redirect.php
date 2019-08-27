<?php namespace c2dl\sys\redirect;

require_once( getenv('C2DL_SYS', true) . '/Database.php');
require_once( getenv('C2DL_SYS', true) . '/Service.php');

use c2dl\sys\db\Database;
use c2dl\sys\service\Service;
use \Error;

class Redirect {

    private $_valid;
    private $_entry;
    private $_url;
    private $_error;

    private $_pdo;
    private $_table;
    private $_tableId;
    private $_tableUrl;
    private $_tableActive;

    public function __construct($entry = null, $dbEntry = 'main') {
        $this->_table = 'www_redirectList';
        $this->_tableId = 'id';
        $this->_tableUrl = 'url';
        $this->_tableActive = 'active';

        $this->setPDO($dbEntry);
        $this->setEntry($entry);
    }

    public function setPDO($dbEntry): void {
        $_db = Database::createPDO();
        if (Service::inArray($dbEntry, $_db)) {
            $this->_pdo = $_db[$dbEntry];
        }
        else {
            $this->_pdo = null;
        }
    }

    public function setEntry($entry): void {

        if ((!isset($entry)) || (is_null($this->_pdo))) {
            $this->_valid = false;
            $this->_entry = null;
            $this->_url = null;
            $this->_error = 'No Entry';

            return;
        }

        if (!self::_validEntry($entry)) {
            $this->_valid = false;
            $this->_entry = null;
            $this->_url = null;
            $this->_error = 'Invalid format';

            return;
        }

        $this->_valid = true;
        $this->_entry = $entry;
        $this->_url = null;
        $this->_error = null;

        $result = null;

        try {
            $_statement = $this->_pdo->prepare(
                'SELECT * FROM ' . $this->_table . ' WHERE ' . $this->_tableId . ' = :entry'
            );
            $_statement->bindParam(':entry', $entry, PDO::PARAM_STR);
            $_statement->execute();
            $result = $_statement->fetch();
            $_statement = null;
        }
        catch (Error $e) {
            error_log($e->getMessage());
            $this->_valid = false;
            $this->_error = 'Entry not found';
            return;
        }

        if (!isset($result)) {
            $this->_valid = false;
            $this->_error = 'Entry not found';
            return;
        }

        $_active = $result[$this->_tableActive];

        if ($_active == 0) {
            $this->_valid = false;
            $this->_error = 'Entry not found';
            return;
        }

        $this->_valid = true;
        $this->_url = $result[$this->_tableUrl];
    }

    public function hasRedirect(): bool {
        return $this->_valid;
    }

    public function getRedirect(): ?string {
        return $this->_url;
    }

    public function getError(): ?Error {
        if (!is_null($this->_error)) {
            return new Error($this->_error);
        }
        return null;
    }

    public function getEntry(): ?string {
        return $this->_entry;
    }

    public function redirect() {
        if ($this->hasRedirect()) {
            self::_redirectTo($this->_url);
        }
    }


    static private function _redirectTo($url) {
        header('Location: '. $url, true, 302);
        exit;
    }

    static private function _validEntry($entry): bool {
        if ((!isset($entry)) || (!is_string($entry))) {
            return false;
        }
        if (!preg_match('/^[a-zA-Z0-9äöüÄÖÜß_\-\=\~\|]{1,64}$/', $entry)) {
            return false;
        }
        return true;
    }

}
