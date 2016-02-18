<?php

namespace App\Helpers\Formatters;

use App\Helpers\Formatters\String;
use Illuminate\Support\Str;

class SQL {

    /**
     * Check if there is any sql operator in the string
     * filter, if there is, then remove it from the string
     * and return which operator is was
     *
     * @param $string
     * @return array
     */
    public static function findOperationWhere($string) {

        $operations = [">=", "<=", ">", "<", "!=", "<>"];

        foreach ($operations as $operation) {
            if (Str::startsWith($string, $operation)) {
                return [
                    'operation' => $operation,
                    'text'      => String::remove($string, $operation)
                ];
            }
        }

        if (Str::contains($string, "%")) {
            return [
                'operation' => "LIKE",
                'text'      => $string
            ];
        }

        return [
            'operation' => "=",
            'text'      => $string
        ];
    }

}