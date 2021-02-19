<?php

namespace App\DTO;

class Social
{
    public $type;
    public $name;
    public $logo;
    public $main;
    public $sub;
    public $side;
    public $link;
    public $link_type;
    public $desc;
    public $card_type;

    public function __construct($data = null)
    {
        $this->type = null;
        $this->name = null;
        $this->logo = null;
        $this->main = null;
        $this->sub = null;
        $this->side = null;
        $this->link = null;
        $this->link_type = null;
        $this->desc = null;
        $this->card_type = "full";

        if (isset($data['type']) && is_string($data['type'])) {
            $this->type = $data['type'];
        }

        if (isset($data['name']) && is_string($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['logo']) && is_string($data['logo'])) {
            $this->logo = $data['logo'];
        }

        if (isset($data['main']) && is_string($data['main'])) {
            $this->main = $data['main'];
        }

        if (isset($data['sub']) && is_string($data['sub'])) {
            $this->sub = $data['sub'];
        }

        if (isset($data['side']) && is_string($data['side'])) {
            $this->side = $data['side'];
        }

        if (isset($data['link']) && is_string($data['link'])) {
            $this->link = $data['link'];
        }

        if (isset($data['link_type']) && is_string($data['link_type'])) {
            $this->link_type = $data['link_type'];
        }

        if (isset($data['desc']) && is_string($data['desc'])) {
            $this->desc = $data['desc'];
        }

        if (isset($data['card_type']) && is_string($data['card_type'])) {
            $this->card_type = $data['card_type'];
        }
    }
}
