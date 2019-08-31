<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/Database.php');
require_once( getenv('C2DL_SYS', true) . '/service/GeneralService.php');
require_once( getenv('C2DL_SYS', true) . '/repository/Structure.php');
require_once( getenv('C2DL_SYS', true) . '/repository/IRedirect.php');

require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseTable.php');
require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumn.php');
require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumnStringSizeConstraints.php');
require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumnStringRegexConstraints.php');

require_once( getenv('C2DL_SYS', true) . '/logger/Log.php');

use c2dl\sys\log\Log;
use \PDO;

/*
 * Redirect Repository (Singleton)
 */
class Redirect implements IRedirect {

    private static $_instance;

    private $_pdo;
    private $_tableStructure;
    private $_logger;

    private $_executeSelect;
    private $_prepareStatement;

    /*
     * Get Redirect instance
     * @param string|void $dbEntry used database
     */
    public static function getInstance($dbEntry = 'main'): IRedirect {
        if(!self::$_instance) {
            self::$_instance = new self(Database::getInstance()->getConnection($dbEntry),
                Log::getInstance()->getLogger('db'),
                [ 'c2dl\\sys\\db\\Structure', 'executeSelectPDO'],
                [ 'c2dl\\sys\\db\\Structure', 'prepareStatementString']);
        }
        return self::$_instance;
    }

    /*
     * Test only
     * @param PDO $dummyPdo database
     * @return Account Account repository
     */
    public static function createTestDummy($dummyPdo, $logger, $select, $prepareStatement): IRedirect {
        return new self($dummyPdo, $logger, $select, $prepareStatement);
    }

    /*
     * Constructor
     * @param PDO $pdo used database
     */
    private function __construct($pdo, $logger, $select, $prepareStatement) {
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

        $this->_pdo = $pdo;
        $this->_logger = $logger;
        $this->_executeSelect = $select;
        $this->_prepareStatement = $prepareStatement;
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
        if ((!isset($entry)) || (is_null($this->_pdo))) {
            return array('entry' => null, 'url' => null);
        }

            $_redirectTable = $this->_tableStructure['redirect'];
        $result = call_user_func($this->_executeSelect, $this->_pdo, '*', $_redirectTable->name(),
            call_user_func($this->_prepareStatement, array($_redirectTable->key()), $this->_logger),
            array($_redirectTable->key()), array($entry), $this->_logger);

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
