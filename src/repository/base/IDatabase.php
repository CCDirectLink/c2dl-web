<?php namespace c2dl\sys\db\base;

/*
 * Database Access information interface (singleton)
 */
interface IDatabase {
    /*
     * Get Database instance
     * @param mixed[] $options PDO options
     */
    public static function getInstance($options = null): IDatabase;

    /*
     * Get PDO object (db connection)
     * @param string|null $dbEntry database name
     * @return PDO[]|PDO|null PDO array if no $dbEntry, PDO if existing $dbEntry, null if invalid
     */
    public function getConnection($dbEntry = null);
}
