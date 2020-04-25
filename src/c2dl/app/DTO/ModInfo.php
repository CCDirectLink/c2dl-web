<?php

namespace App\DTO;

class ModInfo
{
    public $page;
    public $maxPage;
    public $list;

    function __construct($data = null,
                         int $page = 1,
                         int $entriesPerPage = 15) {
        $this->page = 1;
        $this->maxPage = 1;
        $_list = [];

        if (isset($data)) {
            $_size = count($data);

            $_entriesPerPage = (($entriesPerPage > 0) ? $entriesPerPage : 15);
            $_maxPage = intdiv($_size, $_entriesPerPage) + ((($_entriesPerPage % $_size) === 0) ? (1) : (0));
            $_maxPage = (($_maxPage > 0) ? $_maxPage : 1);
            $_page = (($page > $_maxPage) ? ($_maxPage) : ($page));
            $_start = ($_page - 1) * $_entriesPerPage;

            $this->page = $_page;
            $this->maxPage = $_maxPage;
            $_array = array_slice($data, $_start, $_entriesPerPage);

            foreach ($_array as &$value) {
                array_push($_list, new \App\DTO\ModEntry($value));
            }
        }

        $this->list = $_list;

    }
}
