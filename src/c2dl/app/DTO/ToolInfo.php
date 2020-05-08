<?php

namespace App\DTO;

class ToolInfo
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

        if (isset($data['tools'])) {
            $_size = count($data['tools']);

            $_entriesPerPage = (($entriesPerPage > 0) ? $entriesPerPage : 15);
            $_maxPage = intdiv($_size, $_entriesPerPage) + ((($_size % $_entriesPerPage) === 0) ? (0) : (1));
            $_maxPage = (($_maxPage > 0) ? $_maxPage : 1);
            $_page = (($page > $_maxPage) ? ($_maxPage) : ($page));
            $_start = ($_page - 1) * $_entriesPerPage;

            $this->page = $_page;
            $this->maxPage = $_maxPage;
            $_array = array_slice($data['tools'], $_start, $_entriesPerPage);

            foreach ($_array as &$value) {
                array_push($_list, new \App\DTO\ToolDataEntry($value));
            }
        }

        $this->list = $_list;

    }
}
