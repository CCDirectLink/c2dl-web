<?php namespace c2dl\sys\db\access;

/*
 * Repository Table
 */
interface ITableAccess {

    public static function createInstance($dbEntry): ITableAccess;

    public static function createCustomInstance($dummyPdo, $logger,
                                           $select, $update, $prepareStatement, $filter): ITableAccess;

    public function executeSelectPDO($elements, $table, $where,
                                     $dbStructure, $data, $logger = null, $multi = false): ?iterable;

    public function executeUpdatePDO($table, $setList, $where,
                                     $dbStructure, $data, $logger = null): ?iterable;

    public function prepareStatementString($dbStructure, $logger = null): string;

    public function prepareStatementStringFilter($dbStructure, $data, $logger = null): string;

    public function hasPDO(): bool;

}
