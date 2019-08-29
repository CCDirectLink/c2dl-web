<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/DatabaseColumnConstraints.php');
require_once( getenv('C2DL_SYS', true) . '/repository/IDatabaseColumnStringRegexConstraints.php');

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
