<?php namespace c2dl\sys\db;

/*
 * Redirect Repository interface (Singleton)
 */
interface IRedirect {

    /*
     * Get Redirect instance
     * @param string|void $dbEntry used database
     */
    public static function getInstance($dbEntry = 'main'): IRedirect;

    /*
     * Get redirect data
     * @param string|null $entry redirect entry name
     * @return mixed[] redirect result
     */
    public function hasRedirect($entry): ?iterable;

}
