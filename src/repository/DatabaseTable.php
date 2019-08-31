<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/IDatabaseTable.php');

use \TypeError;

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

        if ((isset($key)) && ($key instanceof IDatabaseColumn)) {
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
    public function key(): ?IDatabaseColumn {
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
     * Get All Table Columns
     * @return DatabaseColumn[]|null All Table Columns
     */
    public function allColumns(): ?iterable {
        return array_merge($this->_data, array(self::PRIMARY => $this->_key));
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
        if ((!isset($key)) || (!$key instanceof IDatabaseColumn)) {
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
