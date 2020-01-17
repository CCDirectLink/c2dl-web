<?php

namespace App\DTO;

class NewsPreview
{
    public $content; // string
    public $image; // string

    function __construct($data = null) {
        $this->content = null;
        $this->image = null;

        if (isset($data['content']) && is_string($data['content'])) {
            $this->content = $data['content'];
        }

        if (isset($data['image']) && is_string($data['image'])) {
            $this->image = $data['image'];
        }
    }
}
