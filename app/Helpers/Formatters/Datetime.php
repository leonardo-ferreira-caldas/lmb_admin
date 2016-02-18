<?php

namespace App\Helpers\Formatters;

class Datetime {

    public function applyFormat($date, $countryFormat) {
        return app(Date::class)->applyFormat($date, $countryFormat, true);
    }

}