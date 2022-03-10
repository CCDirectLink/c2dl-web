<?php

namespace App\DTO;

class User
{
    public $id; // int
    public $name; // string
    public $bio; // string|array

    /**
     * @param int $id
     * @param string $name
     * @param string|array|null $bio
     */
    function __construct($id, $name, $bio = null)
    {
        if (is_int($id)) {
            $this->id = $id;
        } else {
            throw new \InvalidArgumentException('$id must be an integer');
        }

        if (is_string($name)) {
            $this->name = $name;
        } else {
            throw new \InvalidArgumentException('$name must be a string');
        }

        if (is_string($bio) || is_array($bio) || is_null($bio)) {
            $this->bio = $bio;
        } else {
            throw new \InvalidArgumentException('$bio must be a string or an array');
        }
    }

    function hasBio(): bool
    {
        return (!is_null($this->bio));
    }
}
