<?php

namespace App\Helpers\Formatters;

use Illuminate\Support\Str;

class String {

    /**
     * Makes a string more readable
     *
     * @param $string
     * @return string
     */
    public static function labelize($string) {
        $replaces = [
            'id_' => 'codigo ',
            'fk_' => '',
            '_' => ' '
        ];

        $string = str_replace(array_keys($replaces), array_values($replaces), $string);

        return ucwords($string);
    }

    /**
     * Remove a character from a string
     *
     * @param $string
     * @param $needle
     * @return string
     */
    public static function remove($string, $needle) {
        return str_replace($needle, "", $string);
    }


}