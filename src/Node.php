<?php namespace c2dl\sys\node;

require_once( getenv('C2DL_SYS', true) . '/Service.php');

use c2dl\sys\service\Service;
use \Exception;

class Node
{

    static public function nodeJS(string $command, &$output = null, &$return_var = null): string {

        $disabled = false;

        if (!Service::inCorrectRoot($_SERVER['DOCUMENT_ROOT'], getenv('C2DL_WWW', true))) {
            return '';
        }

        if ($disabled) {
            return '';
        }

        require(getenv('C2DL_SYS') . '/_internal/envGetter.php');
        $execUrl = $envGetter('C2DL_NODE_EXEC');
        unset($envGetter);

        $currentDir = dirname($_SERVER['SCRIPT_FILENAME']);

        try {
            return exec('cd ' . $currentDir . ' && ' . $execUrl . ' ' . $command,
                $output, $return_var);
        } catch (Exception $e) {
            @error_log('NodeJS Failed: ' . $e);
            return '';
        }
    }

    static public function npmRun(string $command, &$output = null, &$return_var = null): string {

        $disabled = true;

        if (!Service::inCorrectRoot($_SERVER['DOCUMENT_ROOT'], getenv('C2DL_WWW', true))) {
            return '';
        }

        if ($disabled) {
            return '';
        }

        require(getenv('C2DL_SYS', true) . '/_internal/envGetter.php');
        $execUrl = $envGetter('C2DL_NPM_EXEC');
        unset($envGetter);

        $currentDir = dirname($_SERVER['SCRIPT_FILENAME']);

        try {
            return exec('cd ' . $currentDir . ' && ' . $execUrl . ' ' . $command,
                $output, $return_var);
        } catch (Exception $e) {
            @error_log('NPM Failed: ' . $e);
            return '';
        }
    }

}
