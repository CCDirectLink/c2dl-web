<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/IStructure.php');
require_once( getenv('C2DL_SYS', true) . '/repository/IDatabaseColumn.php');
require_once( getenv('C2DL_SYS', true) . '/error/ConstraintException.php');

require_once( getenv('C2DL_SYS', true) . '/logger/Log.php');

use c2dl\sys\log\Log;
use c2dl\sys\err\ConstraintException;
use c2dl\sys\service\GeneralService;
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
     * @param null|Logger $logger logger
     * @return string Statement string
     */
    public static function prepareStatementString($dbStructure, $logger = null): string {
        $result = '';
        $first = true;

        foreach ($dbStructure as &$entry) {
            if ($entry instanceof IDatabaseColumn) {
                $result .= ($first ? '' : ', ') . $entry->name() . ' = :' . $entry->name();
                $first = false;
            }
        }

        if (isset($logger)) {
            $logger->info(__FUNCTION__, ['out' => $result]);
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
     * @param null|Logger $logger logger
     * @return string Statement string
     */
    public static function prepareStatementStringFilter($dbStructure, $data, $logger = null): string {
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

        if (isset($logger)) {
            $logger->info(__FUNCTION__, ['out' => $result]);
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
     * @param null|Logger $logger logger
     * @param bool $multi fetchAll if true
     * @return mixed[] Requested data
     */
    public static function executeSelectPDO($pdo, $elements, $table, $where,
                                             $dbStructure, $data, $logger = null, $multi = false): ?iterable {
        $_loggedStatements = [];

        $result = null;
        try {
            $_statement = $pdo->prepare(
                'SELECT ' . $elements . ' FROM ' . $table . ' WHERE ' . $where
            );
            foreach ($dbStructure as $key => &$entry) {
                if (!GeneralService::inArray($key, $data)) {
                    array_push($_loggedStatements,
                        ':' . $entry->name() . ' skipped (' . $entry->type() . ')'
                    );
                    continue 1;
                }
                $_statement->bindParam(':' . $entry->name(), $data[$key], $entry->type());
                array_push($_loggedStatements,
                    ':' . $entry->name() . ' = ' . $data[$key] . ' (' . $entry->type() . ')'
                );
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
            throw $e;
        }

        if ((!isset($result)) || ($result === false)) {
            return null;
        }

        if (isset($logger)) {
            $logger->info(__FUNCTION__, [
                'sql' => 'SELECT ' . $elements . ' FROM ' . $table . ' WHERE ' . $where,
                'bind' => $_loggedStatements,
                'out' => $result
            ]);
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
     * @param null|Logger $logger logger
     */
    public static function executeUpdatePDO($pdo, $table, $setList, $where,
                                             $dbStructure, $data, $logger = null): void {
        $_loggedStatements = [];

        try {
            $_statement = $pdo->prepare(
                'UPDATE ' . $table . ' SET ' . $setList . ' WHERE ' . $where
            );
            foreach ($dbStructure as $key => &$entry) {
                if (!GeneralService::inArray($key, $data)) {
                    array_push($_loggedStatements,
                        ':' . $entry->name() . ' skipped (' . $entry->type() . ')'
                    );
                    continue 1;
                }
                if (is_array($entry->constraints())) {
                    foreach ($entry->constraints() as &$constraint) {
                        if (!$constraint->validate($data[$key])) {
                            $_statement = null;
                            throw new ConstraintException('Constraint not met in '. $key, 0, $key);
                        }
                    }
                }
                $_statement->bindParam(':' . $entry->name(), $data[$key], $entry->type());
                array_push($_loggedStatements,
                    ':' . $entry->name() . ' = ' . $data[$key] . ' (' . $entry->type() . ')'
                );
            }
            $_statement->execute();
            $_statement = null;
        }
        catch (PDOException $e) {
            throw $e;
        }

        if (isset($logger)) {
            $logger->info(__FUNCTION__, [
                'sql' => 'UPDATE ' . $table . ' SET ' . $setList . ' WHERE ' . $where,
                'bind' => $_loggedStatements
            ]);
        }
    }

}
