<?php

namespace App\Helpers\Datatable;

use App\Helpers\Formatters\Vector;

class DatatableFormatter {

    public static function factory($formatterName) {
        $registeredFormatters = config('admin.formatters');

        return app($registeredFormatters[$formatterName]);
    }

    public static function apply($rawString, $formatter) {
        if (is_callable($formatter)) {
            return $formatter($rawString);
        }

        $resolved = Vector::resolveFormatter($formatter);

        $formatterFactory = self::factory($resolved['formatter_name']);

        array_unshift($resolved['parameters'], $rawString);

        return call_user_func_array(array($formatterFactory, 'applyFormat'), $resolved['parameters']);
    }

}