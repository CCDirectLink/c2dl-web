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

    private function _convertGregorian(\DateTime $dateTime, string $format, string $calender) : string
    {
        $format = str_replace('C', '_000000_', $format);

        // 'GR'
        $calender_type = 0;
        $calender_info = false;

        if (strcmp($calender, 'HE') == 0) {
            $calender_type = 1;
        }
        else if (strcmp($calender, 'HE.HTML') == 0) {
            $calender_type = 1;
            $calender_info = true;
        }

        if ($calender_type == 1) {

            $gregorian_year = getdate(strtotime($dateTime->format('F d, Y H:i:s T')))['year'];

            $_he_info_hover = __('date.he_info', [ 'year' => $gregorian_year ]);
            $_he_info = __('date.he');
            $_he_info_html_start = '';
            $_he_info_html_end = '';

            if ($calender_info) {
                $_he_info_html_start = '<span title="' . $_he_info_hover . '" class="c2dl-hoverinfo">';
                $_he_info_html_end = '</span>';
            }

            $format = str_replace('Y', '_000001_', $format);
            $gregorian_date_yearplaceholder = $dateTime->format($format);

            $he_year = [
                'upper' => '1' . intdiv($gregorian_year, 1000),
                'lower' => str_pad('' . $gregorian_year % 1000,
                    3, '0', STR_PAD_LEFT),
            ];

            $he_date = str_replace('_000001_',
                $_he_info_html_start . $he_year['upper'] . ',' . $he_year['lower'],
                $gregorian_date_yearplaceholder);
            $he_date = str_replace('_000000_', $_he_info . $_he_info_html_end, $he_date);

            return $he_date;
        }

        $grg_date = $dateTime->format($format);
        $he_date = str_replace(' _000000_', '', $grg_date);
        return $he_date;
    }

    private function _getDateTimeString($date, string $timezone, string $calender, string $format = null) : string
    {
        if (!is_string($format)) {
            $format = config('app.default_datetime_format');
        }
        try {
            $dateTime = new \DateTime ($date);
            $dateTime->setTimezone(new \DateTimeZone($timezone));

        } catch (\Exception $e) {
            return '(unknown)';
        }

        return $this->_convertGregorian($dateTime, $format, $calender);
    }

    function created(string $format = null, string $timezone = 'UTC', string $calender = 'HE.HTML') : string
    {
        return $this->_getDateTimeString($this->_created, $timezone, $calender, $format);
    }

    function updated(string $format = null, string $timezone = 'UTC', string $calender = 'HE.HTML') : string
    {
        return $this->_getDateTimeString($this->_updated, $timezone, $calender, $format);
    }

    function is_updated() : bool
    {
        return ($this->_created != $this->_updated);
    }

}
