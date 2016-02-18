<?php

namespace App\Helpers\Formatters;

class Vector {

    /**
     * Split a string by a specific character and return its last position
     *
     * @param $string
     * @param $splitBy
     * @return mixed
     */
    public static function getLastSplited($string, $splitBy) {
        $splited = explode($splitBy, $string);
        return end($splited);
    }

    /**
     * Resolve a string formatter pattern
     *
     * @param $formatter
     * @return array
     */
    public static function resolveFormatter($formatter) {
        $resolvedFormatter = [];

        $split = explode(":", $formatter);
        $resolvedFormatter['formatter_name'] = $split[0];

        if (count($split) > 1) {
            $resolvedFormatter['parameters'] = explode(",", $split[1]);
            return $resolvedFormatter;
        }

        $resolvedFormatter['parameters'] = [];

        return $resolvedFormatter;
    }

    /**
     * Check if an array if associative
     *
     * @param array $array
     * @return bool
     */
    public static function isAssociative(array $array) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Transform a normal array into an associative array
     *
     * @param array $array
     * @return array
     */
    public static function toAssociative(array $array) {
        return array_combine(array_values($array), array_values($array));
    }

    /**
     * Check if a key exists in a haystack, if not return empty array
     *
     * @param array $haystack
     * @param mixed $needle
     * @return array
     */
    public static function findOrEmptyArray(array $haystack, $needle) {
        return self::findOrEmpty($haystack, $needle) ?: [];
    }

    /**
     * Check if a key exists in a haystack, if not return empty array
     *
     * @param array $haystack
     * @param mixed $needle
     * @return array
     */
    public static function findOrEmpty(array $haystack, $needle) {
        if (isset($haystack[$needle])) {
            return $haystack[$needle];
        }

        return null;
    }

}