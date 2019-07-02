<?php
    // DO NOT INCLUDE THIS FILE

    $envGetter = function ($env): ?string {

        $envSet = function($env): bool {
            return (getenv($env) !== false);
        };

        if(!$envSet($env)) {

            if($envSet('REDIRECT_' . $env)) {
                $envData = getenv('REDIRECT_' . $env);

                return $envData;
            }

            // optional - only on deployment

            if (file_exists(getenv('C2DL_ROOT', true) . '/.internal/deployStorage.php')) {
                // do not use *_once
                require(getenv('C2DL_ROOT', true) . '/.internal/deployStorage.php');
            }
            else {
                $_requestDeployStorage = function ($env): ?string { return null; };
            }

            // ----
            $envData = $_requestDeployStorage($env);
            unset($_requestDeployStorage);
            return $envData;
        }

        $envData = getenv($env);

        return $envData;
    };

?>
