<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/IStructure.php');
require_once( getenv('C2DL_SYS', true) . '/repository/IDatabaseColumn.php');

use \PDOException;

/*
 * Database Structure Service Functions
 */
class Structure implements IStructure {

    /*
     * Prepare Statement String
     * DatabaseColumn[name=id,...] -> "id = :id"
     * DatabaseColumn[name=a,...][...b...] -> "a = :a, b = :b"
     *
     * @param DatabaseColumn[] $dbStructure Database structure (Columns)
     * @return string Statement string
     */
    public static function prepareStatementString($dbStructure): string {
        $result = '';
        $first = true;

        foreach ($dbStructure as &$entry) {
            if ($entry instanceof IDatabaseColumn) {
                $result .= ($first ? '' : ', ') . $entry->name() . ' = :' . $entry->name();
                $first = false;
            }
        }

        return $result;
    }

    /*
     * Prepare Statement String Filter
     * DatabaseColumn[name=id,...] -> "id = :id"
     * DatabaseColumn[name=a,...][...b...] -> "a = :a, b = :b"
     * Only Columns that are present in $dbStructure and $data are used.
     * Makes it possible to update only specified/used columns in a database request
     *
     * @param DatabaseColumn[] $dbStructure Database structure (Columns)
     * @param mixed[] Data to check (key ===? DatabaseColumn name)
     * @return string Statement string
     */
    public static function prepareStatementStringFilter($dbStructure, $data): string {
        $result = '';
        $first = true;

        if ((!isset($data)) || (!is_array($data))) {
            return $result;
        }

        foreach ($dbStructure as &$entry) {
            if (($entry instanceof IDatabaseColumn) && (isset($data[$entry->name()]))) {
                $result .= ($first ? '' : ', ') . $entry->name() . ' = :' . $entry->name();
                $first = false;
            }
        }

        return $result;
    }

    /*
     * SQL Select request
     *
     * @param PDO $pdo PDO object
     * @param string $elements Selected elements - SQL (e.g. * for all)
     * @param string $table Table name
     * @param string $where Condition
     * @param DatabaseColumn[] $dbStructure parameter binding
     * @param mixed[] $data used data
     * @param bool $multi fetchAll if true
     * @return mixed[] Requested data
     */
    public static function executeSelectPDO($pdo, $elements, $table, $where,
                                             $dbStructure, $data, $multi = false): ?iterable {
        $result = null;
        try {
            $_statement = $pdo->prepare(
                'SELECT ' . $elements . ' FROM ' . $table . ' WHERE ' . $where
            );
            foreach ($dbStructure as $key => &$entry) {
                $_statement->bindParam(':' . $entry->name(), $data[$key], $entry->type());
            }
            $_statement->execute();
            if ($multi) {
                $result = $_statement->fetchAll();
            }
            else {
                $result = $_statement->fetch();
            }
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        return $result;
    }

    /*
     * SQL Update request
     *
     * @param PDO $pdo PDO object
     * @param string $table Table name
     * @param string $setList Updated elements
     * @param string $where Condition
     * @param DatabaseColumn[] $dbStructure parameter binding
     * @param mixed[] $data used data
     * @return mixed[] Requested data
     */
    public static function executeUpdatePDO($pdo, $table, $setList, $where,
                                             $dbStructure, $data): ?iterable {
        try {
            $_statement = $pdo->prepare(
                'UPDATE ' . $table . ' SET ' . $setList . ' WHERE ' . $where
            );
            foreach ($dbStructure as $key => &$entry) {
                if (is_array($entry->constraints())) {
                    foreach ($entry->constraints() as &$constraint) {
                        if (!$constraint->validate()) {
                            $_statement = null;
                            return [ 'error' => 'invalid', 'data' => $entry->name() ];
                        }
                    }
                }
                $_statement->bindParam(':' . $entry->name(), $data[$key], $entry->type());
            }
            $_statement->execute();
            $_statement = null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return [ 'error' => 'pdo', 'data' => $e->getMessage() ];
        }

        return null;
    }

}
