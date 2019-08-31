<?php namespace c2dl\sys\log;

require_once( getenv('C2DL_SYS', true) . '/error/RequestException.php');
require_once( getenv('C2DL_SYS', true) . '/logger/vendor/autoload.php');
require_once( getenv('C2DL_SYS', true) . '/logger/ILog.php');

use c2dl\sys\err\RequestException;
use c2dl\sys\service\GeneralService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\ErrorHandler;
use \Exception;

/*
 * Log (singleton)
 */
class Log implements ILog {

    private static $_log;
    private $_logger;

    /*
     * Get Log instance
     * @return Log instance
     */
    public static function getInstance(): ILog {
        if(!self::$_log) {
            self::$_log = new self();
        }
        return self::$_log;
    }

    /*
     * Constructor
     */
    private function __construct() {
        $this->_logger = [
            'error' => new Logger('error'),
            'main' => new Logger('main'),
            'db' => new Logger('db'),
            'security' => new Logger('security')
        ];

        try {
            $this->_logger['error']->pushHandler(
                new StreamHandler(getenv('C2DL_LOG', true) . '/www-c2dl/error.log',
                    Logger::DEBUG));
        }
        catch (Exception $e) {
            error_log($e->getMessage());
        }

        try {
            $this->_logger['main']->pushHandler(
                new StreamHandler(getenv('C2DL_LOG', true) . '/www-c2dl/main.log',
                Logger::DEBUG));
        }
        catch (Exception $e) {
            error_log($e->getMessage());
        }

        try {
            $this->_logger['db']->pushHandler(
                new StreamHandler(getenv('C2DL_LOG', true) . '/www-c2dl/db.log',
                    Logger::WARNING));
        }
        catch (Exception $e) {
            error_log($e->getMessage());
        }

        try {
            $this->_logger['security']->pushHandler(
                new StreamHandler(getenv('C2DL_LOG', true) . '/www-c2dl/security.log',
                    Logger::DEBUG));
        }
        catch (Exception $e) {
            error_log($e->getMessage());
        }

        $this->_logger['db']->pushProcessor(function ($record) {
            //$record['extra']['user'] = get_current_user();
            return $record;
        });

        ErrorHandler::register($this->_logger['error']);
    }

    /*
     * No Clone
     */
    private function __clone() { }

    /*
     * Get Logger
     * @param string|null $logger Logger
     * @return Log
     */
    public function getLogger($logger = 'main') {
        if (GeneralService::inArray($logger, $this->_logger)) {
            return $this->_logger[$logger];
        }
        $message = 'Logger ' . $logger . ' not available';
        $this->_logger['main']->error($message);
        throw new RequestException($message);
    }

}
