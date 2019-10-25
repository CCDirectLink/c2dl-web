<?php namespace c2dl\sys\db\struct;

require_once( getenv('C2DL_SYS', true) . '/repository/struct/IDatabaseColumn.php');

use \TypeError;

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
