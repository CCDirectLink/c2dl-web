<?php namespace c2dl\sys\service;

class Service
{

    static public function inCorrectRoot($root, $shouldBe): bool {
        $docRoot = rtrim($root, '/');
        $compareRoot = rtrim($shouldBe, '/');
        return (strcmp($docRoot, $compareRoot) == 0);
    }


    static public function stringsEqual($a, $b, $case = true): bool {
        if ((!is_string($a)) || (!is_string($b))) {
            return false;
        }

        if ($case == true) {
            return (strcmp($a, $b) == 0);
        }
        return (strcasecmp($a, $b) == 0);
    }

    static public function inArray($key, $array, $strict = false): bool {
        return (isset($array) && is_array($array) && ($strict ? array_key_exists($key, $array) : isset($array[$key])));
    }

    static public function inArrayIsString($key, $array, $content, $case = true): bool {
        return (self::inArray($key, $array) && self::stringsEqual($array[$key], $content, $case));
    }

}
