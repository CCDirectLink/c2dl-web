<?php namespace c2dl\sys\db\struct;

require_once( getenv('C2DL_SYS', true) . '/repository/struct/IDatabaseStructAdapterEntry.php');

use \TypeError;

/*
 * Database Struct Adapter (entry)
 */
class DatabaseStructAdapterEntry implements IDatabaseStructAdapterEntry {

    private $_classString;
    private $_functionName;

    /*
     * Constructor
     * @param string $className Class Name
     * @param string $functionName Function name
     */
    public function __construct($classString, $functionName) {
        $this->_classString = '';
        $this->_functionName = '';

        $this->setClassString($classString);
        $this->setFunctionName($functionName);
    }

    public function classString(): string {
        return $this->_classString;
    }

    public function functionName(): string {
        return $this->_functionName;
    }

    public function setClassString($classString) {
        if ((!isset($classString)) || (!is_string($classString))) {
            throw new TypeError('Invalid type - classString must be string');
        }
        $this->_classString = $classString;
    }

    public function setFunctionName($functionName) {
        if ((!isset($functionName)) || (!is_string($functionName))) {
            throw new TypeError('Invalid type - functionName must be string');
        }
        $this->_functionName = $functionName;
    }

    public function call(...$parameter) {
        return call_user_func([$this->_classString, $this->_functionName], ...$parameter);
    }

}
