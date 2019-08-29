<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/IDatabaseColumn.php');

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
    public function key(): ?IDatabaseColumn;

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
