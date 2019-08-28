<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');

use c2dl\sys\service\GeneralService;
use \PDO;
use \Exception;
use \PDOException;

class Redirect {

    private static $_instance;

    private $_pdo;
    private $_table;
    private $_tableId;
    private $_tableUrl;
    private $_tableActive;

    public static function getInstance($dbEntry = 'main'): Redirect {
        if(!self::$_instance) {
            self::$_instance = new self($dbEntry);
        }
        return self::$_instance;
    }

    private function __construct($dbEntry = 'main') {
        $this->_table = 'www_redirectList';
        $this->_tableId = 'id';
        $this->_tableUrl = 'url';
        $this->_tableActive = 'active';

        $this->setPDO($dbEntry);
    }

    private function __clone() { }

    private function setPDO($dbEntry): void {
        $_db = Database::getInstance()->getConnection();
        if (GeneralService::inArray($dbEntry, $_db)) {
            $this->_pdo = $_db[$dbEntry];
        }
        else {
            $this->_pdo = null;
        }
    }

    public function hasRedirect($entry): ?iterable {

        if ((!isset($entry)) || (is_null($this->_pdo))) {
            return array('entry' => null, 'url' => null);
        }

        if (!self::_validEntry($entry)) {
            return array('entry' => null, 'url' => null);
        }

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
        catch (PDOException $e) {
            error_log($e->getMessage());
            return array('entry' => $entry, 'url' => null);
        }
        catch (Exception $e) {
            error_log($e->getMessage());
            return array('entry' => $entry, 'url' => null);
        }

        if (!isset($result)) {
            return array('entry' => $entry, 'url' => null);
        }

        $_active = $result[$this->_tableActive];

        if ($_active == 0) {
            return array('entry' => $entry, 'url' => null);
        }

        return array('entry' => $entry, 'url' => $result[$this->_tableUrl]);
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
