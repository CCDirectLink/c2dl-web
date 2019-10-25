<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/base/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');
require_once( getenv('C2DL_SYS', true) . '/repository/base/Structure.php');
require_once( getenv('C2DL_SYS', true) . '/repository/IRedirect.php');

require_once( getenv('C2DL_SYS', true) . '/repository/struct/DatabaseTable.php');
require_once( getenv('C2DL_SYS', true) . '/repository/struct/DatabaseColumn.php');
require_once( getenv('C2DL_SYS', true) . '/repository/struct/DatabaseColumnStringSizeConstraints.php');
require_once( getenv('C2DL_SYS', true) . '/repository/struct/DatabaseColumnStringRegexConstraints.php');

require_once( getenv('C2DL_SYS', true) . '/repository/access/TableAccess.php');

require_once( getenv('C2DL_SYS', true) . '/logger/Log.php');

use c2dl\sys\db\access\TableAccess;
use c2dl\sys\log\Log;
use \PDO;
use c2dl\sys\db\base\Database;
use c2dl\sys\db\struct\DatabaseTable;
use c2dl\sys\db\struct\DatabaseColumn;
use c2dl\sys\db\struct\DatabaseColumnStringRegexConstraints;
use c2dl\sys\db\struct\DatabaseColumnStringSizeConstraints;

/*
 * Redirect Repository (Singleton)
 */
class Redirect implements IRedirect {

    private static $_instance;

    private static $_loggerEntry = 'db';

    private $_logger;
    private $_tableAccess;
    private $_tableStructure;

    /*
     * Get Redirect instance
     * @param string|void $dbEntry used database
     */
    public static function getInstance($dbEntry = 'main'): IRedirect {
        if(!self::$_instance) {
            $log = Log::getInstance()->getLogger(self::$_loggerEntry);
            $pdo = Database::getInstance()->getConnection($dbEntry);
            self::$_instance = new self($log,
                TableAccess::createInstance($pdo, $log));
        }
        return self::$_instance;
    }

    /*
     * Test only
     * @param Log $logger logger
     * @param TableAccess $tableAccess table Access
     */
    public static function createTestDummy($logger, $tableAccess): IRedirect {
        return new self($logger, $tableAccess);
    }

    /*
     * Constructor
     * @param PDO $pdo used database
     */
    private function __construct($logger, $tableAccess) {
        $this->_logger = $logger;
        $this->_tableAccess = $tableAccess;
        $this->_tableStructure =  DatabaseTable::create('www_redirectList',
                DatabaseColumn::create('id', PDO::PARAM_STR,
                    [DatabaseColumnStringRegexConstraints::create('/^[a-zA-Z0-9äöüÄÖÜß_\-\=\~\|]{1,64}$/')]), [
                        'url' => DatabaseColumn::create(
                            'url', PDO::PARAM_STR, [DatabaseColumnStringSizeConstraints::create(10, 1024)]
                        ),
                        'active' => DatabaseColumn::create('active', PDO::PARAM_BOOL)
                ]);
    }

    /*
     * No Clone
     */
    private function __clone() { }

    /*
     * Get redirect data
     * @param string|null $entry redirect entry name
     * @return mixed[] redirect result
     */
    public function hasRedirect($entry): ?iterable {
        if (!isset($entry)) {
            return array('entry' => null, 'url' => null);
        }

        $_redirectTable = $this->_tableStructure;
        $result = $this->_tableAccess->executeSelectPDO('*', $_redirectTable->name(),
            $this->_tableAccess->prepareStatementString([$_redirectTable->key()], $this->_logger),
            [$_redirectTable->key()], [$entry], $this->_logger);

        $this->_logger->info(__FUNCTION__, [
            'entry' => $entry,
            'result' => $result
        ]);

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
