<?php

namespace App\DTO;

class ModMetadata
{
    public $name;
    public $readableName;
    public $description;
    public $license;
    public $version;
    public $repository;
    public $repositoryType;
    public $authors;
    public $stars;
    public $tags;

    function __construct($data = null, $stars = 0) {
        $this->name = null;
        $this->readableName = null;
        $this->description = null;
        $this->license = null;
        $this->version = null;
        $this->repository = null;
        $this->repositoryType = null;
        $this->stars = null;
        $this->tags = null;

        if (isset($data['id']) && is_string($data['id'])) {
            $this->name = $data['id'];
        }

        if (isset($data['title'])) {
            $this->readableName = $this->getStringFromLanguageLabel($data['title']);
        }

        if (isset($data['description'])) {
            $this->description = $this->getStringFromLanguageLabel($data['description']);
        }

        $_version = '0.0.0';

        if (isset($data['version']) && is_string($data['version'])) {
            $_version = $data['version'];
        }

        $this->version = $_version;

        if (isset($data['repository']) && is_string($data['repository'])) {
            $this->repository = $data['repository'];
            if (preg_match('~^http(s)?://(www\.)?github\.com/~', $this->repository)) {
                $this->repositoryType = 'github';
            }
            else if (preg_match('~^http(s)?://(www\.)?gitlab\.com/~', $this->repository)) {
                $this->repositoryType = 'gitlab';
            }
            else {
                $this->repositoryType = 'web';
            }
        }

        if (isset($data['authors'])) {
            if (is_string($data['authors'])) {
                $this->authors = $data['authors'];
            } else {
                $this->authors = join(', ', $data['authors']);
            }
        }

        $this->stars = $stars;

        if (isset($data['tags'])) {
            $this->tags = join(', ', $data['tags']);
        }
    }

    public function getVisibleName(): string {
        return $this->readableName ?? $this->name;
    }

    public function hasReadableName(): bool {
        return (!is_null($this->readableName));
    }

    public static function getStringFromLanguageLabel($label, $language = 'en_US') {
        $_str = $label;
        if (!is_string($label)) {
            $_str = $label[$language];
        }
        /* remove crosscode icons and colors */
        $_str = preg_replace('/\\\\c\[[^\]]*\]/', '', $_str);
        $_str = preg_replace('/\\\\s\[[^\]]*\]/', '', $_str);
        $_str = preg_replace('/\\\\i\[[^\]]*\]/', '', $_str);
        return $_str;
    }
}
