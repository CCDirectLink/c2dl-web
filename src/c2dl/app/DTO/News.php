<?php

namespace App\DTO;

class News
{
    public $id; // int
    public $_created; // UTC DateTime
    public $_updated; // UTC DateTime
    public $language; // string
    public $title; // string
    public $content; // string
    public $preview; // NewsPreview
    public $author; // User
    public $page; // Parination

    function __construct($data = null,
                         string $preview = null,
                         \App\DTO\User $author = null,
                         \App\DTO\Pagination $page_data = null) {
        $this->id = null;
        $this->_created = null;
        $this->_updated = null;
        $this->language = 'en';
        $this->title = null;
        $this->content = null;

        if (isset($data->news_id) && is_int($data->news_id)) {
            $this->id = $data->news_id;
        }

        if (isset($data->created_at) && is_object($data->created_at)) {
            $this->_created = $data->created_at;
        }

        if (isset($data->updated_at) && is_object($data->updated_at)) {
            $this->_updated = $data->updated_at;
        }

        if (isset($data->lang) && is_string($data->lang)) {
            $this->language = $data->lang;
        }

        if (isset($data->title) && is_string($data->title)) {
            $this->title = $data->title;
        }

        if (isset($data->content) && is_string($data->content)) {
            $this->content = $data->content;
        }

        $_preview = [];

        if (isset($preview) && is_string($preview)) {
            $_preview['content'] = $preview;
        }

        if (isset($data->preview_content) && is_string($data->preview_content)) {
            $_preview['content'] = $data->preview_content;
        }

        if (isset($data->preview_image) && is_string($data->preview_image)) {
            $_preview['image'] = $data->preview_image;
        }

        $this->preview = new \App\DTO\NewsPreview($_preview);

        if (isset($author) && is_object($author)) {
            $this->author = $author;
        }
        else {
            $this->author = new \App\DTO\User();
        }

        if (isset($page_data) && is_object($page_data)) {
            $this->page = $page_data;
        }
        else {
            $this->page = new \App\DTO\Pagination();
        }

    }

    private function _getDateTimeString($date, $format = null, $timezone = 'UTC')
    {
        if (!is_string($format)) {
            $format = config('app.default_datetime_format');
        }
        try {
            $dateTime = new \DateTime ($date);
            $dateTime->setTimezone(new \DateTimeZone($timezone));
            return $dateTime->format($format);
        } catch (\Exception $e) {
            return '(unknown)';
        }
    }

    function created($format = null, $timezone = 'UTC') : string
    {
        return $this->_getDateTimeString($this->_created, $format, $timezone);
    }

    function updated($format = null, $timezone = 'UTC') : string
    {
        return $this->_getDateTimeString($this->_updated, $format, $timezone);
    }

    function is_updated() : bool
    {
        return ($this->_created != $this->_updated);
    }

}
