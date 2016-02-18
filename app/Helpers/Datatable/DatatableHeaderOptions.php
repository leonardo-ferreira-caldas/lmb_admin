<?php

namespace App\Helpers\Datatable;

use App\Helpers\Formatters\String;
use App\Helpers\Formatters\Vector;
use App\Helpers\Forms\Fields\Factory;

class DatatableHeaderOptions {

    public static function build($columnName, $overrides, $defaultProperties) {
        $field = Factory::createField($columnName, Vector::findOrEmpty($overrides, 'type'));

        return collect([
            'align'  => 'left',
            'label'  => String::labelize($columnName),
            'width'  => null,
            'order'  => $defaultProperties['order'],
            'filter' => $defaultProperties['filter'],
            'name'   => $columnName,
        ])
        ->merge($overrides)
        ->merge(['type' => $field])
        ->toArray();
    }

    public static function fill($columns, $columnsOverrides, $defaultProperties) {
        $normalizedColumns = [];

        foreach ($columns as $numColumn => $columnName) {
            if (isset($columnsOverrides[$columnName])) {
                $normalizedColumns[] = self::build($columnName, $columnsOverrides[$columnName], $defaultProperties);
                continue;
            }

            $normalizedColumns[] = self::build($columnName, [], $defaultProperties);
        }

        return $normalizedColumns;
    }


}