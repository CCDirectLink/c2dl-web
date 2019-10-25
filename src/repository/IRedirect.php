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
     * Test only
     * @param Log $logger logger
     * @param TableAccess $tableAccess table Access
     */
    public static function createTestDummy($logger, $tableAccess): IRedirect;

    /*
     * Get redirect data
     * @param string|null $entry redirect entry name
     * @return mixed[] redirect result
     */
    public function hasRedirect($entry): ?iterable;

}
