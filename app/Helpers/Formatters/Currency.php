<?php

namespace App\Helpers\Formatters;

class Currency {

    public function formatBR($currency) {
        return number_format($currency, 2, ",", ".");
    }

    public function applyFormat($currency, $countryFormat) {
        $method = 'format' . strtoupper($countryFormat);

        if (!method_exists($this, $method)) {
            return $currency;
        }

        $formattedDate = call_user_func(array($this, $method), $currency);

        return $formattedDate;
    }

}