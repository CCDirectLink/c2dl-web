<?php namespace c2dl\sys\db;
require_once( getenv('C2DL_SYS') . '/Service.php');

use \PDO;
use \Exception;
use c2dl\sys\service\Service;

class Database {

    static private function _defaultOptions() {
        return [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
    }

    static private function _getData() {
        $arr = null;

        if (Service::inCorrectRoot($_SERVER['DOCUMENT_ROOT'], getenv('C2DL_WWW', true))) {

            require(getenv('C2DL_SYS', true) . '/_internal/envGetter.php');

            $arr = array(
                'main' => array(
                    'user' => $envGetter('C2DL_DB_MAIN_USER'),
                    'pass' => $envGetter('C2DL_DB_MAIN_PASS'),
                    'host' => $envGetter('C2DL_DB_MAIN_HOST'),
                    'port' => $envGetter('C2DL_DB_MAIN_PORT'),
                    'db' => $envGetter('C2DL_DB_MAIN_DB')
                ),
                'ext' => array(
                    'user' => $envGetter('C2DL_DB_EXT_USER'),
                    'pass' => $envGetter('C2DL_DB_EXT_PASS'),
                    'host' => $envGetter('C2DL_DB_EXT_HOST'),
                    'port' => $envGetter('C2DL_DB_EXT_PORT'),
                    'db' => $envGetter('C2DL_DB_EXT_DB')
                ),
                'acc' => array(
                    'user' => $envGetter('C2DL_DB_ACC_USER'),
                    'pass' => $envGetter('C2DL_DB_ACC_PASS'),
                    'host' => $envGetter('C2DL_DB_ACC_HOST'),
                    'port' => $envGetter('C2DL_DB_ACC_PORT'),
                    'db' => $envGetter('C2DL_DB_ACC_DB')
                )
            );

            unset($envGetter);

        }
        else if (Service::inCorrectRoot($_SERVER['DOCUMENT_ROOT'], getenv('C2DL_API', true))) {

            require(getenv('C2DL_SYS', true) . '/_internal/envGetter.php');

            $arr = array(
                'ext' => array(
                    'user' => $envGetter('C2DL_DB_EXT_USER'),
                    'pass' => $envGetter('C2DL_DB_EXT_PASS'),
                    'host' => $envGetter('C2DL_DB_EXT_HOST'),
                    'port' => $envGetter('C2DL_DB_EXT_PORT'),
                    'db' => $envGetter('C2DL_DB_EXT_DB')
                )
            );

            unset($envGetter);

        }
        else {
            @error_log('Database access tried - file: ' . $_SERVER['SCRIPT_FILENAME']);
        }

        return $arr;
    }

    static public function createPDO($options = null): iterable {
        $_options = self::_defaultOptions();

        if (isset($options)) {
            $_options = $options;
        }

        $_data = self::_getData();

        $resultArray = array();

        if (is_null($_data)) {
            return $resultArray;
        }

        foreach ($_data as $key => &$value) {

            // cancel if not array

            $dsn = 'mysql:host=' . $value['host'] . ';dbname=' . $value['db'] . ';charset=utf8mb4';

            if (isset($value['port'])) {
                $dsn = $dsn . ';port=' . $value['port'];
            }

            try {
                $entry = new PDO($dsn, $value['user'], $value['pass'], $_options);
                $resultArray[$key] = $entry;
            } catch (Exception $e) {
                @error_log('Database access failed with Error (' . $e . ') - entry ' . $key .
                    ' file: ' . $_SERVER['SCRIPT_FILENAME']);
            }

            // in loop cleanup
            unset($dsn);
            unset($value);

        }

        // cleanup
        unset($_data);

        return $resultArray;
    }

}
