<?php namespace c2dl\sys\db;

use \TypeError;
use \PDOException;
use \Exception;

/*
 * Column Constraints Type Interface
 */
interface IDatabaseColumnConstraints {
    /*
     * Validate data
     * @param mixed $data Input data
     * @return bool True if valid
     */
    public function validate($data): bool;
}

/*
 * Column Constraints Type
 */
abstract class DatabaseColumnConstraints implements IDatabaseColumnConstraints {
    /*
     * Validate data
     * @param mixed $data Input data
     * @return bool True if valid
     */
    abstract public function validate($data): bool;
}

/*
 * Column Size Constraints Interface
 */
interface IDatabaseColumnStringSizeConstraints {
    /*
     * Create Constraints
     * @param int|null $min Minimum Constraints
     * @param int|null $max Maximum Constraints
     */
    static public function create($min = null, $max = null);

    /*
     * Constructor
     * @param int|null $min Minimum Constraints
     * @param int|null $max Maximum Constraints
     */
    public function __construct($min = null, $max = null);

    /*
     * get min Constraints
     * @return int|null Minimum Constraints
     */
    public function min(): ?int;

    /*
     * get max Constraints
     * @return int|null Maximum Constraints
     */
    public function max(): ?int;

    /*
     * set min Constraints
     * @param int $min Minimum Constraints
     */
    public function setMin($min);

    /*
     * set max Constraints
     * @param int $max Maximum Constraints
     */
    public function setMax($max);

    /*
     * Validate string
     * @param string $data String data
     * @return bool True if valid
     */
    public function validate($data): bool;
}

/*
 * Column Size Constraints
 */
class DatabaseColumnStringSizeConstraints extends DatabaseColumnConstraints
    implements IDatabaseColumnStringSizeConstraints {
    private $_min;
    private $_max;

    /*
     * Create Constraints
     * @param int|null $min Minimum Constraints
     * @param int|null $max Maximum Constraints
     */
    static public function create($min = null, $max = null) {
        return new self($min, $max);
    }

    /*
     * Constructor
     * @param int|null $min Minimum Constraints
     * @param int|null $max Maximum Constraints
     */
    public function __construct($min = null, $max = null) {
        $this->_min = null;
        $this->_max = null;

        if ((isset($min)) && (is_int($min))) {
            $this->_min = $min;
        }

        if ((isset($max)) && (is_int($max))) {
            $this->_max = $max;
        }
    }

    /*
     * get min Constraints
     * @return int|null Minimum Constraints
     */
    public function min(): ?int {
        return $this->_min;
    }

    /*
     * get max Constraints
     * @return int|null Maximum Constraints
     */
    public function max(): ?int {
        return $this->_max;
    }

    /*
     * set min Constraints
     * @param int $min Minimum Constraints
     */
    public function setMin($min) {
        if ((!isset($min)) || (!is_int($min))) {
            throw new TypeError('Invalid type - min must be int');
        }
        $this->_min = $min;
    }

    /*
     * set max Constraints
     * @param int $max Maximum Constraints
     */
    public function setMax($max) {
        if ((!isset($max)) || (!is_int($max))) {
            throw new TypeError('Invalid type - max must be int');
        }
        $this->_max = $max;
    }

    /*
     * Validate string
     * @param string $data String data
     * @return bool True if valid
     */
    public function validate($data): bool {
        if ((!isset($data)) || (!is_string($data))) {
            return false;
        }
        if (($this->_min !== null) && (strlen($data) < $this->_min)) {
            return false;
        }
        if (($this->_max !== null) && (strlen($data) > $this->_max)) {
            return false;
        }
        return true;
    }
}

/*
 * Column Regex Constraints Interface
 */
interface IDatabaseColumnStringRegexConstraints {
    /*
     * Create Constraints
     * @param string|null $pattern Pattern
     */
    static public function create($pattern = null);

    /*
     * Constructor
     * @param string|null $pattern Pattern
     */
    public function __construct($pattern = null);

    /*
     * Get Pattern
     * @return string|null Pattern
     */
    public function pattern(): ?string;

    /*
     * set Pattern
     * @param string $pattern String pattern
     */
    public function setPattern($pattern);

    /*
     * Validate string
     * @param string $data String data#
     * @return bool True if valid
     */
    public function validate($data): bool;
}

/*
 * Column Regex Constraints
 */
class DatabaseColumnStringRegexConstraints extends DatabaseColumnConstraints
    implements IDatabaseColumnStringRegexConstraints{
    private $_pattern;

    /*
     * Create Constraints
     * @param string|null $pattern Pattern
     */
    static public function create($pattern = null) {
        return new self($pattern);
    }

    /*
     * Constructor
     * @param string|null $pattern Pattern
     */
    public function __construct($pattern = null) {
        $this->_pattern = null;

        if ((isset($pattern)) && (is_string($pattern))) {
            $this->_pattern = $pattern;
        }
    }

    /*
     * Get Pattern
     * @return string|null Pattern
     */
    public function pattern(): ?string {
        return $this->_pattern;
    }

    /*
     * set Pattern
     * @param string $pattern String pattern
     */
    public function setPattern($pattern) {
        if ((!isset($pattern)) || (!is_string($pattern))) {
            throw new TypeError('Invalid type - pattern must be string');
        }
        $this->_pattern = $pattern;
    }

    /*
     * Validate string
     * @param string $data String data#
     * @return bool True if valid
     */
    public function validate($data): bool {
        if ((!isset($data)) || (!is_string($data))) {
            return false;
        }
        if (!preg_match($this->_pattern, $data)) {
            return false;
        }
        return true;
    }
}

/*
 * Database column interface
 */
interface IDatabaseColumn {
    /*
     * Create Column
     * @param string|null $name Column Name
     * @param int|null $type PDO type
     * @param DatabaseColumnConstraints[]|null $constraints Constraints
     */
    static public function create($name = null, $type = null, $constraints = null);

    /*
     * Constructor
     * @param string|null $name Column Name
     * @param int|null $type PDO type
     * @param DatabaseColumnConstraints[]|null $constraints Constraints
     */
    public function __construct($name = null, $type = null, $constraints = null);

    /*
     * Get Name
     * @return string|null Column Name
     */
    public function name(): ?string;

    /*
     * Get PDO type
     * @return int|null PDO type
     */
    public function type(): ?int;

    /*
     * Get Constraints
     * @return DatabaseColumnConstraints[]|null Constraints
     */
    public function constraints(): ?iterable;

    /*
     * Set Name
     * @param string $name Column Name
     */
    public function setName($name);

    /*
     * Set PDO type
     * @param int $type PDO type
     */
    public function setType($type);

    /*
     * Set Constraints
     * @param DatabaseColumnConstraints[] $constraints Constraints
     */
    public function setConstraints($constraints);
}

/*
 * Represents a database column
 */
class DatabaseColumn implements IDatabaseColumn {
    private $_name;
    private $_type;
    private $_constraints;

    /*
     * Create Column
     * @param string|null $name Column Name
     * @param int|null $type PDO type
     * @param DatabaseColumnConstraints[]|null $constraints Constraints
     */
    static public function create($name = null, $type = null, $constraints = null) {
        return new self($name, $type, $constraints);
    }

    /*
     * Constructor
     * @param string|null $name Column Name
     * @param int|null $type PDO type
     * @param DatabaseColumnConstraints[]|null $constraints Constraints
     */
    public function __construct($name = null, $type = null, $constraints = null) {
        $this->_name = null;
        $this->_type = null;
        $this->_constraints = null;

        if ((isset($name)) && (is_string($name))) {
            $this->_name = $name;
        }

        if ((isset($type)) && (is_int($type))) {
            $this->_type = $type;
        }

        if ((isset($constraints)) && (is_array($constraints))) {
            $this->_constraints = $constraints;
        }
    }

    /*
     * Get Name
     * @return string|null Column Name
     */
    public function name(): ?string {
        return $this->_name;
    }

    /*
     * Get PDO type
     * @return int|null PDO type
     */
    public function type(): ?int {
        return $this->_type;
    }

    /*
     * Get Constraints
     * @return DatabaseColumnConstraints[]|null Constraints
     */
    public function constraints(): ?iterable {
        return $this->_constraints;
    }

    /*
     * Set Name
     * @param string $name Column Name
     */
    public function setName($name) {
        if ((!isset($name)) || (!is_string($name))) {
            throw new TypeError('Invalid type - name must be string');
        }
        $this->_name = $name;
    }

    /*
     * Set PDO type
     * @param int $type PDO type
     */
    public function setType($type) {
        if ((!isset($type)) || (!is_int($type))) {
            throw new TypeError('Invalid type - type must be int');
        }
        $this->_type = $type;
    }

    /*
     * Set Constraints
     * @param DatabaseColumnConstraints[] $constraints Constraints
     */
    public function setConstraints($constraints) {
        if ((!isset($constraints)) || (!is_array($constraints))) {
            throw new TypeError('Invalid type - constraints must be array');
        }
        $this->_constraints = $constraints;
    }
}

/*
 * Database table interface
 */
interface IDatabaseTable {
    /*
     * Create Database Table
     * @param string|null $name Table Name
     * @param DatabaseColumn|null $key Table Key Column
     * @param DatabaseColumn[]|null $data Table Data Column
     */
    static public function create($name = null, $key  = null, $data  = null);

    /*
     * Constructor
     * @param string|null $name Table Name
     * @param DatabaseColumn|null $key Table Key Column
     * @param DatabaseColumn[]|null $data Table Data Columns
     */
    public function __construct($name = null, $key  = null, $data  = null);

    /*
     * Get Table Name
     * @return string|null Table Name
     */
    public function name(): ?string;

    /*
     * Get Table Key Column
     * @return DatabaseColumn|null Table Key Column
     */
    public function key(): ?DatabaseColumn;

    /*
     * Get Table Data Columns
     * @return DatabaseColumn[]|null Table Data Columns
     */
    public function data(): ?iterable;

    /*
     * Set Table Name
     * @param string $name Table Name
     */
    public function setName($name);

    /*
     * Set Table Key Column
     * @param DatabaseColumn $key Table Key Column
     */
    public function setKey($key);

    /*
     * Set Table Data Columns
     * @param DatabaseColumn[] $data Table Data Columns
     */
    public function setData($data);
}

/*
 * Represents a database table
 */
class DatabaseTable implements IDatabaseTable {
    private $_name;
    private $_key;
    private $_data;

    /*
     * Create Database Table
     * @param string|null $name Table Name
     * @param DatabaseColumn|null $key Table Key Column
     * @param DatabaseColumn[]|null $data Table Data Column
     */
    static public function create($name = null, $key  = null, $data  = null) {
        return new self($name, $key, $data);
    }

    /*
     * Constructor
     * @param string|null $name Table Name
     * @param DatabaseColumn|null $key Table Key Column
     * @param DatabaseColumn[]|null $data Table Data Columns
     */
    public function __construct($name = null, $key  = null, $data  = null) {
        $this->_name = null;
        $this->_key = null;
        $this->_data = null;

        if ((isset($name)) && (is_string($name))) {
            $this->_name = $name;
        }

        if ((isset($key)) && ($key instanceof DatabaseColumn)) {
            $this->_key = $key;
        }

        if ((isset($data)) && (is_array($data))) {
            $this->_data = $data;
        }
    }

    /*
     * Get Table Name
     * @return string|null Table Name
     */
    public function name(): ?string {
        return $this->_name;
    }

    /*
     * Get Table Key Column
     * @return DatabaseColumn|null Table Key Column
     */
    public function key(): ?DatabaseColumn {
        return $this->_key;
    }

    /*
     * Get Table Data Columns
     * @return DatabaseColumn[]|null Table Data Columns
     */
    public function data(): ?iterable {
        return $this->_data;
    }

    /*
     * Set Table Name
     * @param string $name Table Name
     */
    public function setName($name) {
        if ((!isset($name)) || (!is_string($name))) {
            throw new TypeError('Invalid type - name must be string');
        }
        $this->_name = $name;
    }

    /*
     * Set Table Key Column
     * @param DatabaseColumn $key Table Key Column
     */
    public function setKey($key) {
        if ((!isset($key)) || (!$key instanceof DatabaseColumn)) {
            throw new TypeError('Invalid type - key must be DatabaseColumn');
        }
        $this->_key = $key;
    }

    /*
     * Set Table Data Columns
     * @param DatabaseColumn[] $data Table Data Columns
     */
    public function setData($data) {
        if ((!isset($data)) || (!is_array($data))) {
            throw new TypeError('Invalid type - data must be array');
        }
        $this->_data = $data;
    }
}

/*
 * Exception Interface
 */
interface IException
{
    // Exception Functions
    public function getMessage();
    public function getCode();
    public function getFile();
    public function getLine();
    public function getTrace();
    public function getTraceAsString();

    /*
     * Create UpdateResultException
     * @param string $message Error Message
     * @param int|null $code Error code
     * @param string|null $errorWithData Data element that is invalid
     */
    static public function create($message = null, $code = 0, $errorWithData  = null);

    /*
     * Constructor
     * @param string $message Error Message
     * @param int|null $code Error code
     * @param string|null $errorWithData Data element that is invalid
     */
    public function __construct($message = null, $code = 0);

    /*
     * Get element that is invalid
     * @return string|null Data element that is invalid
     */
    public function getErrorBy(): ?string;

    /*
     * Error String
     * @return Error String
     */
    public function __toString();
}

/*
 * Update Exception
 */
class UpdateException extends Exception implements IException {

    protected $message = 'Unknown exception';
    private $string;
    protected $code = 0;
    protected $file;
    protected $line;
    private $trace;
    private $errorBy;

    /*
     * Create UpdateResultException
     * @param string $message Error Message
     * @param int|null $code Error code
     * @param string|null $errorWithData Data element that is invalid
     */
    static public function create($message = null, $code = 0, $errorBy  = null) {
        return new self($message, $code, $errorBy);
    }

    /*
     * Constructor
     * @param string $message Error Message
     * @param int|null $code Error code
     * @param string|null $errorBy Data element that is invalid
     */
    public function __construct($message = null, $code = 0, $errorBy  = null) {
        $this->errorBy = null;

        if ((isset($errorBy)) && (is_string($errorBy))) {
            $this->errorBy = $errorBy;
        }

        parent::__construct($message, $code);
    }

    /*
     * Get element that is invalid
     * @return string|null Data element that is invalid
     */
    public function getErrorBy(): ?string {
        return $this->errorBy;
    }

    /*
     * Error String
     * @return Error String
     */
    public function __toString(): string {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
            . "{$this->getTraceAsString()}";
    }
}

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
     * @return string Statement string
     */
    public static function prepareStatementString($dbStructure): string;

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
    public static function prepareStatementStringFilter($dbStructure, $data): string;

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
                                            $dbStructure, $data, $multi = false): ?iterable;

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
                                            $dbStructure, $data): ?iterable;

}

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
            if ($entry instanceof DatabaseColumn) {
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
            if (($entry instanceof DatabaseColumn) && (isset($data[$entry->name()]))) {
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
