<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');
require_once( getenv('C2DL_SYS', true) . '/repository/Structure.php');

use c2dl\sys\service\GeneralService;
use \PDO;
use \Exception;
use \PDOException;

/*
 * Redirect Repository interface
 */
class Redirect {

    private static $_instance;

    private $_pdo;
    private $_tableStructure;

    public static function getInstance($dbEntry = 'main'): Redirect {
        if(!self::$_instance) {
            self::$_instance = new self($dbEntry);
        }
        return self::$_instance;
    }

    private function __construct($dbEntry = 'main') {
        $this->_tableStructure = [
            'redirect' => DatabaseTable::create('www_redirectList',
                DatabaseColumn::create('id', PDO::PARAM_STR,
                    [DatabaseColumnStringRegexConstraints::create('/^[a-zA-Z0-9äöüÄÖÜß_\-\=\~\|]{1,64}$/')]), [
                        'url' => DatabaseColumn::create(
                            'url', PDO::PARAM_STR, [DatabaseColumnStringSizeConstraints::create(10, 1024)]
                        ),
                        'active' => DatabaseColumn::create('active', PDO::PARAM_BOOL)
                ])
        ];

        $this->_pdo = Database::getInstance()->getConnection($dbEntry);
    }

    private function __clone() { }

    public function hasRedirect($entry): ?iterable {
        if ((!isset($entry)) || (is_null($this->_pdo))) {
            return array('entry' => null, 'url' => null);
        }

        $_redirectTable = $this->_tableStructure['redirect'];
        $result = Structure::executeSelectPDO($this->_pdo, '*', $_redirectTable->name(),
            Structure::prepareStatementString(array($_redirectTable->key())),
            array($_redirectTable->key()), array($entry));

        if (!isset($result)) {
            return array('entry' => $entry, 'url' => null);
        }

        $_active = $result[$_redirectTable->data()['active']->name()];

        if ($_active == 0) {
            return array('entry' => $entry, 'url' => null);
        }

        return array('entry' => $entry, 'url' => $result[$_redirectTable->data()['url']->name()]);
    }

}
