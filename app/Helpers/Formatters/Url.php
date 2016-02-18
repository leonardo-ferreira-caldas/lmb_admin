<?php

namespace App\Helpers\Formatters;

class Url {

    public static function httpBuildQuery($url, $parameters) {
        if (empty($parameters)) {
            return $url;
        }

        return $url . "?" . http_build_query($parameters);
    }

}