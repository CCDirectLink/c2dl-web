<?php namespace c2dl\sys\err;

require_once( getenv('C2DL_SYS', true) . '/error/IException.php');

use \Exception;

/*
 * Type Exception
 */
class NoDatabaseException extends Exception implements IException {};
