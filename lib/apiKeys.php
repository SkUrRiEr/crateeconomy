<?php

namespace CE;

class ApiKey
{
    private function __construct()
    {
        // Do nothing, this is static only
    }

    public static function getKey($service)
    {
        $list = json_decode(file_get_contents("api_keys.json"), true);

        if (!$list || !isset($list[$service])) {
            return null;
        }

        return $list[$service];
    }
}
