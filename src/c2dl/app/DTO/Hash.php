<?php

namespace App\DTO;

class Hash
{
    public $hash;
    public $hash_type;

    function __construct($data = null) {
        $this->hash = null;
        $this->hash_type = null;

        if (isset($data['hash']) && is_string($data['hash'])) {
            $this->hash = $data['hash'];
        }

        if (isset($data['hash_type']) && is_string($data['hash_type'])) {
            $this->hash_type = $data['hash_type'];
        }

        if (isset($data) && is_string($data)) {
            preg_match('/^([a-zA-Z0-9]+)\-(.*)$/u', $data, $results);

            if (isset($results[1]) && is_string($results[1])) {
                $this->hash_type = $results[1];
            }

            if (isset($results[2]) && is_string($results[2])) {
                $this->hash = $results[2];
            }
        }

    }

    public function getSubresourceIntegrity() : string
    {
        return $this->hash_type . '-'. $this->hash;
    }
}
