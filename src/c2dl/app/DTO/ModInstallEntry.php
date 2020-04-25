<?php

namespace App\DTO;

class ModInstallEntry
{
    public $type;
    public $url;
    public $source;
    public $hash;

    function __construct($data = null) {
        $this->type = null;
        $this->source = null;
        $this->url = null;
        $this->hash = null;

        if (isset($data['type']) && is_string($data['type']) &&
            (($data['type'] === 'ccmod') || ($data['type'] === 'modZip'))) {
            $this->type = $data['type'];
        }

        if (($this->type === 'modZip') && isset($data['source']) && is_string($data['source'])) {
            $this->source = $data['source'];
        }

        if (isset($data['url']) && is_string($data['url'])) {
            $this->url = $data['url'];
        }

        $_hash = null;
        if (isset($data['hash']) && isset($data['hash']['sha256']) && is_string($data['hash']['sha256'])) {
            $_hash = [ 'hash' => $data['hash']['sha256'], 'hash_type' => 'sha256' ];
        }

        $this->hash = new \App\DTO\Hash($_hash);
    }
}
