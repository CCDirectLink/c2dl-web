<?php

namespace App\DTO;

class ToolDataEntryVersion
{
    public $page_list;
    public $source_list;
    public $version;
    public $hash;

    function __construct($data = null) {
        $this->page_list = [];
        $this->source_list = [];
        $this->version = null;

        if (isset($data['page']) && is_array($data['page'])) {
            foreach ($data['page'] as $page) {
                if (isset($page['url']) && is_string($page['url'])) {
                    $this->page_list[$page['name']] = $page['url'];
                }
            }
        }

        if (isset($data['archive_link']) && is_string($data['archive_link'])) {
            array_push($this->source_list, $data['archive_link']);
        }

        if (isset($data['version']) && is_string($data['version'])) {
            $this->version = $data['version'];
        }

        $_hash = null;
        if (isset($data['hash']) && isset($data['hash']['sha256']) && is_string($data['hash']['sha256'])) {
            $_hash = [ 'hash' => $data['hash']['sha256'], 'hash_type' => 'sha256' ];
        }

        $this->hash = new \App\DTO\Hash($_hash);
    }
}
