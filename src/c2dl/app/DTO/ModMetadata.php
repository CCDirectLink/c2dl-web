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

    function __construct($pkg = null) {
        $_metadata = $pkg['metadataCCMod'];

        $this->name = null;
        $this->readableName = null;
        $this->description = null;
        $this->license = null;
        $this->version = null;
        $this->repository = null;
        $this->repositoryType = null;
        $this->stars = null;
        $this->tags = null;

        if (isset($_metadata['id']) && is_string($_metadata['id'])) {
            $this->name = $_metadata['id'];
        }

        if (isset($_metadata['title'])) {
            $this->readableName = $this->getStringFromLanguageLabel($_metadata['title']);
        }

        if (isset($_metadata['description'])) {
            $this->description = $this->getStringFromLanguageLabel($_metadata['description']);
        }

        $_version = '0.0.0';

        if (isset($_metadata['version']) && is_string($_metadata['version'])) {
            $_version = $_metadata['version'];
        }

        $this->version = $_version;

        if (isset($_metadata['repository']) && is_string($_metadata['repository'])) {
            $this->repository = $_metadata['repository'];
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

        if (isset($_metadata['authors'])) {
            if (is_string($_metadata['authors'])) {
                $this->authors = $_metadata['authors'];
            } else {
                $this->authors = join(', ', $_metadata['authors']);
            }
        }

        if (isset($pkg['stars'])) {
            $this->stars = $pkg['stars'];
        }

        if (isset($_metadata['tags'])) {
            $this->tags = join(', ', $_metadata['tags']);
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
