<?php

    $ECHO_MESSAGE = [
        'ping' => [
            'status' => 'ok',
            'request' => date("Y/m/d"),
        ]
    ];

    header('Content-Type: application/json');
    echo $ECHO_MESSAGE;
