<?php

namespace App\DTO;

class Pagination
{
    public $list; // int array
    public $current; // int
    public $before; // int
    public $next; // int
    public $number; // int

    function __construct($data = null) {
        $this->list = [];
        $this->current = null;
        $this->before = null;
        $this->next = null;

        if (isset($data['list']) && is_array($data['list'])) {
            $this->list = $data['list'];
        }

        if (isset($data['current']) && is_int($data['current'])) {
            $this->current = $data['current'];
        }

        if (isset($data['before']) && is_int($data['before'])) {
            $this->before = $data['before'];
        }

        if (isset($data['next']) && is_int($data['next'])) {
            $this->next = $data['next'];
        }

        $this->number = count($this->list);

    }

    public function hasNext() : bool
    {
        return (is_int($this->next));
    }

    public function hasBefore() : bool
    {
        return (is_int($this->before));
    }
}
