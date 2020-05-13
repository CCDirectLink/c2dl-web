<?php

namespace App\DTO;

class ModMetadata
{
    public $name;
    public $readableName;
    public $description;
    public $license;
    public $version;
    public $homepage;
    public $homepageType;

    function __construct($data = null) {
        $this->name = null;
        $this->readableName = null;
        $this->description = null;
        $this->license = null;
        $this->version = null;
        $this->homepage = null;
        $this->homepageType = null;

        if (isset($data['name']) && is_string($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['ccmodHumanName']) && is_string($data['ccmodHumanName'])) {
            $this->readableName = $data['ccmodHumanName'];
        }

        if (isset($data['description']) && is_string($data['description'])) {
            $this->description = $data['description'];
        }

        $_version = '0.0.0';

        if (isset($data['version']) && is_string($data['version'])) {
            $_version = $data['version'];
        }

        $this->version = $_version;

        if (isset($data['homepage']) && is_string($data['homepage'])) {
            $this->homepage = $data['homepage'];
            if (preg_match('~^http(s)?://(www\.)?github\.com/~', $this->homepage)) {
                $this->homepageType = 'github';
            }
            else if (preg_match('~^http(s)?://(www\.)?gitlab\.com/~', $this->homepage)) {
                $this->homepageType = 'gitlab';
            }
            else {
                $this->homepageType = 'web';
            }
        }

    }

    public function getVisibleName(): string {
        return $this->readableName ?? $this->name;
    }

    public function hasReadableName(): bool {
        return (!is_null($this->readableName));
    }
}
