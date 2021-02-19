<?php

namespace App\DTO;

class SvgRequest
{
    public $class;
    public $id;
    public $title;
    public $name;
    public $width;
    public $height;
    public $extern;
    public $alt;

    public function __construct($data = null)
    {
        $this->name = null;
        $this->title = null;
        $this->id = null;
        $this->class = null;
        $this->width = null;
        $this->height = null;
        $this->extern = false;
        $this->alt = null;

        if (isset($data['name']) && is_string($data['name'])) {
            $this->name = $data['name'];
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

        if (isset($data['width']) && is_string($data['width'])) {
            $this->width = $data['width'];
        }

        if (isset($data['height']) && is_string($data['height'])) {
            $this->height = $data['height'];
        }

        if (isset($data['extern']) && is_bool($data['extern'])) {
            $this->extern = $data['extern'];
        }

        if (isset($data['alt']) && is_string($data['alt'])) {
            $this->alt = $data['alt'];
        }
    }
}
