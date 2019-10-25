<?php namespace c2dl\sys\db\struct;

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
