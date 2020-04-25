<?php

namespace App\DTO;

class ToolDataEntry
{
    public $name;
    public $description;
    public $last_version;
    public $version_list;

    function __construct($data = null) {
        $this->name = null;
        $this->description = null;
        $this->version_list = [];

        if (isset($data['name']) && is_string($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['description']) && is_string($data['description'])) {
            $this->description = $data['description'];
        }

        $_version = '0.0.0';

        if (isset($data['version']) && is_string($data['version'])) {
            $_version = $data['version'];
        }

        $this->last_version = $_version;
        $this->version_list[$_version] = new ToolDataEntryVersion($data);
    }
}
