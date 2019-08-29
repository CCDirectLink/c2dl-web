<?php namespace c2dl\sys\db;

require_once( getenv('C2DL_SYS', true) . '/repository/IDatabaseColumnConstraints.php');

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
