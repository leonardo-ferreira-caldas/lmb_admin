<?php

if (!function_exists('select')) {

    /**
     * Create a new select field instance
     *
     * @param array $options List of options
     * @param mixed $selectedValue Selected option
     */
    function select(array $options = [], $defaultText = null) {
        $instance = app('App\Helpers\Forms\Fields\Select', [$options]);

        if (!is_null($defaultText)) {
            $instance->defaultText($defaultText);
        }

        return $instance;
    }

}

if (!function_exists('selectTable')) {

    /**
     * Create a new select field instance
     *
     * @param $table string
     * @param $keyColumn string
     * @param $descriptionColumn string
     * @param $defaultText string
     */
    function selectTable($table, $keyColumn, $descriptionColumn = null, $defaultText = null) {
        $instance = app('App\Helpers\Forms\Fields\Select')->fromTable($table, $keyColumn, $descriptionColumn);

        if (!is_null($defaultText)) {
            $instance->defaultText($defaultText);
        }

        return $instance;
    }

}


if (!function_exists('image_upload')) {

    /**
     * Return the image url
     *
     * @param $imgName string
     */
    function image_upload($imgName) {
        return env('APP_SITE_UPLOAD_IMG') . $imgName;
    }

}

if (!function_exists('thumb_upload')) {

    /**
     * Return the thumb image url
     *
     * @param $imgName string
     */
    function thumb_upload($imgName, $width, $height) {
        return env('APP_SITE_URL') . "image/{$width}/{$height}/{$imgName}";
    }

}

if (!function_exists('app_url')) {

    /**
     * Return the app url
     *
     * @param $url string
     */
    function app_url($url) {
        return env('APP_SITE_URL') . $url;
    }

}

if (!function_exists('date_formatter')) {

    /**
     * Format a date time in a specific country format
     *
     * @param $date string
     * @param $countryFormat string
     */
    function date_formatter($date, $countryFormat) {
        return app("App\Helpers\Formatters\Date")->applyFormat($date, $countryFormat);
    }

}


if (!function_exists('datetime_formatter')) {

    /**
     * Format a date time in a specific country format
     *
     * @param $date string
     * @param $countryFormat string
     */
    function datetime_formatter($datetime, $countryFormat) {
        return app("App\Helpers\Formatters\Date")->applyFormat($datetime, $countryFormat, true);
    }

}


if (!function_exists('money_formatter')) {

    /**
     * Format a currency in a specific country format
     *
     * @param $date string
     * @param $countryFormat string
     */
    function money_formatter($datetime, $countryFormat = "br") {
        return app("App\Helpers\Formatters\Currency")->applyFormat($datetime, $countryFormat);
    }

}