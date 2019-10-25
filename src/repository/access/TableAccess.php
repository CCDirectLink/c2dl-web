<?php namespace c2dl\sys\db\access;

require_once( getenv('C2DL_SYS', true) . '/repository/struct/DatabaseStructAdapterEntry.php');
require_once( getenv('C2DL_SYS', true) . '/repository/access/ITableAccess.php');

require_once( getenv('C2DL_SYS', true) . '/logger/Log.php');

use c2dl\sys\db\struct\DatabaseStructAdapterEntry;

/*
 * Repository Table
 */
class TableAccess implements ITableAccess
{
    private static $_structClassString = 'c2dl\\sys\\db\\base\\Structure';

    private static $_structFktSelect = 'executeSelectPDO';
    private static $_structFktUpdate = 'executeUpdatePDO';
    private static $_structPrepStatement = 'prepareStatementString';
    private static $_structPrepStatementFilter = 'prepareStatementStringFilter';

    protected $_pdo;
    protected $_logger;

    protected $_executeSelect;
    protected $_executeUpdate;
    protected $_prepareStatement;
    protected $_prepareStatementFilter;

    /*
     * Get Account repository instance
     * @param string|null $dbEntry database name
     * @return Account Account repository
     */
    public static function createInstance($pdo, $logger = null): ITableAccess {
       return new self($pdo, $logger,
                new DatabaseStructAdapterEntry(self::$_structClassString,self::$_structFktSelect),
                new DatabaseStructAdapterEntry(self::$_structClassString,self::$_structFktUpdate),
                new DatabaseStructAdapterEntry(self::$_structClassString,self::$_structPrepStatement),
                new DatabaseStructAdapterEntry(self::$_structClassString,self::$_structPrepStatementFilter)
            );
    }

    /*
     * Test only
     * @param PDO $dummyPdo database
     * @param Log $logger logger
     * @return Account Account repository
     */
    public static function createCustomInstance($dummyPdo, $logger,
                                           $select, $update, $prepareStatement, $filter): ITableAccess {
        return new self($dummyPdo, $logger, $select, $update, $prepareStatement, $filter);
    }

    /*
     * Constructor
     * @param PDO $dbEntry database
     * @return Account Account repository
     */
    private function __construct($pdo, $logger, $select, $update, $prepareStatement, $filter) {
        $this->_pdo = $pdo;
        $this->_logger = $logger;

        $this->_executeSelect = $select;
        $this->_executeUpdate = $update;
        $this->_prepareStatement = $prepareStatement;
        $this->_prepareStatementFilter = $filter;
    }

    public function executeSelectPDO($elements, $table, $where,
                                        $dbStructure, $data, $logger = null, $multi = false): ?iterable {
        return $this->_executeSelect->call($this->_pdo,
            $elements, $table, $where, $dbStructure, $data, $logger, $multi);
    }

    public function executeUpdatePDO($table, $setList, $where,
                                        $dbStructure, $data, $logger = null): ?iterable {
        return $this->_executeUpdate->call($this->_pdo,
            $table, $setList, $where, $dbStructure, $data, $logger);
    }

    public function prepareStatementString($dbStructure, $logger = null): string {
        return $this->_prepareStatement->call($dbStructure, $logger);
    }

    public function prepareStatementStringFilter($dbStructure, $data, $logger = null): string {
        return $this->_prepareStatementFilter->call($dbStructure, $data, $logger);
    }

    public function hasPDO(): bool {
        return !is_null($this->_pdo);
    }

}
