<?php namespace c2dl\sys\db;

use \TypeError;
use \PDOException;

abstract class DatabaseColumnConstraints {
    abstract public function validate($data): bool;
}

class DatabaseColumnStringSizeConstraints extends DatabaseColumnConstraints {
    private $_min;
    private $_max;

    static public function create($min = null, $max = null) {
        return new self($min, $max);
    }

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

    public function min(): ?int {
        return $this->_min;
    }

    public function max(): ?int {
        return $this->_max;
    }

    public function setMin($min) {
        if ((!isset($min)) || (!is_int($min))) {
            throw new TypeError('Invalid type - min must be int');
        }
        $this->_min = $min;
    }

    public function setMax($max) {
        if ((!isset($max)) || (!is_int($max))) {
            throw new TypeError('Invalid type - max must be int');
        }
        $this->_max = $max;
    }

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

class DatabaseColumnStringRegexConstraints extends DatabaseColumnConstraints {
    private $_pattern;

    static public function create($pattern = null) {
        return new self($pattern);
    }

    public function __construct($pattern = null) {
        $this->_pattern = null;

        if ((isset($pattern)) && (is_string($pattern))) {
            $this->_pattern = $pattern;
        }
    }

    public function pattern(): ?string {
        return $this->_pattern;
    }

    public function setPattern($pattern) {
        if ((!isset($pattern)) || (!is_string($pattern))) {
            throw new TypeError('Invalid type - pattern must be string');
        }
        $this->_pattern = $pattern;
    }

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

class DatabaseColumn {
    private $_name;
    private $_type;
    private $_constraints;

    static public function create($name = null, $type = null, $constraints = null) {
        return new self($name, $type, $constraints);
    }

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

    public function name(): ?string {
        return $this->_name;
    }

    public function type(): ?int {
        return $this->_type;
    }

    public function constraints(): ?iterable {
        return $this->_constraints;
    }

    public function setName($name) {
        if ((!isset($name)) || (!is_string($name))) {
            throw new TypeError('Invalid type - name must be string');
        }
        $this->_name = $name;
    }

    public function setType($type) {
        if ((!isset($type)) || (!is_int($type))) {
            throw new TypeError('Invalid type - type must be int');
        }
        $this->_type = $type;
    }

    public function setConstraints($constraints) {
        if ((!isset($constraints)) || (!is_array($constraints))) {
            throw new TypeError('Invalid type - constraints must be array');
        }
        $this->_constraints = $constraints;
    }
}

class DatabaseTable {
    private $_name;
    private $_key;
    private $_data;

    static public function create($name = null, $key  = null, $data  = null) {
        return new self($name, $key, $data);
    }

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

    public function name(): ?string {
        return $this->_name;
    }

    public function key(): ?DatabaseColumn {
        return $this->_key;
    }

    public function data(): ?iterable {
        return $this->_data;
    }

    public function setName($name) {
        if ((!isset($name)) || (!is_string($name))) {
            throw new TypeError('Invalid type - name must be string');
        }
        $this->_name = $name;
    }

    public function setKey($key) {
        if ((!isset($key)) || (!$key instanceof DatabaseColumn)) {
            throw new TypeError('Invalid type - key must be DatabaseColumn');
        }
        $this->_key = $key;
    }

    public function setData($data) {
        if ((!isset($data)) || (!is_array($data))) {
            throw new TypeError('Invalid type - data must be array');
        }
        $this->_data = $data;
    }
}

class Structure {

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
