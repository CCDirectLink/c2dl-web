<?php namespace c2dl\sys\db\struct;

require_once( getenv('C2DL_SYS', true) . '/repository/struct/DatabaseColumnConstraints.php');
require_once( getenv('C2DL_SYS', true) .
    '/repository/struct/IDatabaseColumnStringSizeConstraints.php');

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
