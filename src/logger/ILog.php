<?php namespace c2dl\sys\log;

/*
 * Log interface (singleton)
 */
interface ILog {

    /*
     * Get Log instance
     * @return Log instance
     */
    public static function getInstance(): ILog;

    /*
     * Get Logger
     * @param string|null $logger Logger
     * @return Log
     */
    public function getLogger($logger = 'main');

}
