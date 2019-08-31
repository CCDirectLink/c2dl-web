<?php namespace c2dl\sys\db;

/*
 * Database Structure Service Interface
 */
interface IStructure {

    /*
     * Prepare Statement String
     * DatabaseColumn[name=id,...] -> "id = :id"
     * DatabaseColumn[name=a,...][...b...] -> "a = :a, b = :b"
     *
     * @param DatabaseColumn[] $dbStructure Database structure (Columns)
     * @param null|Logger $logger logger
     * @return string Statement string
     */
    public static function prepareStatementString($dbStructure, $logger = null): string;

    /*
     * Prepare Statement String Filter
     * DatabaseColumn[name=id,...] -> "id = :id"
     * DatabaseColumn[name=a,...][...b...] -> "a = :a, b = :b"
     * Only Columns that are present in $dbStructure and $data are used.
     * Makes it possible to update only specified/used columns in a database request
     *
     * @param DatabaseColumn[] $dbStructure Database structure (Columns)
     * @param mixed[] Data to check (key ===? DatabaseColumn name)
     * @param null|Logger $logger logger
     * @return string Statement string
     */
    public static function prepareStatementStringFilter($dbStructure, $data, $logger = null): string;

    /*
     * SQL Select request
     *
     * @param PDO $pdo PDO object
     * @param string $elements Selected elements - SQL (e.g. * for all)
     * @param string $table Table name
     * @param string $where Condition
     * @param DatabaseColumn[] $dbStructure parameter binding
     * @param mixed[] $data used data
     * @param null|Logger $logger logger
     * @param bool $multi fetchAll if true
     * @return mixed[] Requested data
     */
    public static function executeSelectPDO($pdo, $elements, $table, $where,
                                            $dbStructure, $data, $logger = null, $multi = false): ?iterable;

    /*
     * SQL Update request
     *
     * @param PDO $pdo PDO object
     * @param string $table Table name
     * @param string $setList Updated elements
     * @param string $where Condition
     * @param DatabaseColumn[] $dbStructure parameter binding
     * @param mixed[] $data used data
     * @param null|Logger $logger logger
     */
    public static function executeUpdatePDO($pdo, $table, $setList, $where,
                                            $dbStructure, $data, $logger = null): void;

}
