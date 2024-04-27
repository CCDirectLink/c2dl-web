<?php

namespace App\DTO;

class ModEntry
{
    public $metadata;
    public $installation;

    function __construct($data = null) {
        $this->metadata = new \App\DTO\ModMetadata($data);
        $this->installation = [];

        foreach ($data['installation'] as $installation) {
            array_push($this->installation, new \App\DTO\ModInstallEntry($installation));
        }
    }
}
