<?php

namespace App\DTO;

class SvgRequest
{
    public $class;
    public $id;
    public $title;
    public $path;

    public function __construct($data = null)
    {
        $this->path = null;
        $this->title = null;
        $this->id = null;
        $this->class = null;

        if (isset($data['path']) && is_string($data['path'])) {
            $this->path = $data['path'];
        }

        if (isset($data['title']) && is_string($data['title'])) {
            $this->title = $data['title'];
        }

        if (isset($data['id']) && is_string($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['class']) && is_string($data['class'])) {
            $this->class = $data['class'];
        }
    }
}
