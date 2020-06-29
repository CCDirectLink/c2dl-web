<?php

namespace App\DTO;

class User
{
    public $id; // int
    public $name; // string
    public $bio; // string

    function __construct($data = null) {
        $this->id = null;
        $this->name = null;
        $this->bio = null;

        if (isset($data[0]) && is_int($data[0])) {
            $this->id = $data[0];
        }

        if (isset($data[1]) && is_string($data[1])) {
            $this->name = $data[1];
        }

        if (isset($data[2]) && is_string($data[2])) {
            $this->bio = $data[2];
        }

    }

    function hasId(): bool {
        return (!is_null($this->id));
    }

    function hasName(): bool {
        return (!is_null($this->name));
    }

    function hasBio(): bool {
        return (!is_null($this->bio));
    }
}
