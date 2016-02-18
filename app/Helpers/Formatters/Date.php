<?php

namespace App\Helpers\Formatters;

class Date {

    public function formatEN($date) {
        return date('Y-m-d', strtotime($date));
    }

    public function formatBR($date) {
        return date('d/m/Y', strtotime($date));
    }

    public function applyFormat($date, $countryFormat, $time = false) {
        $method = 'format' . strtoupper($countryFormat);

        if (!method_exists($this, $method)) {
            return date($countryFormat, strtotime($date));
        }

        $formattedDate = call_user_func(array($this, $method), $date);

        if ($time) {
            $formattedDate .= date(' H:i:s', strtotime($date));
        }

        return $formattedDate;
    }

}