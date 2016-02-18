<?php

namespace App\Helpers\Forms\Fields;

use App\Helpers\Forms\Fields\Input;
use UnexpectedValueException;

class Factory {

    /**
     * Creates a new field instance
     *
     * @param string $fieldName
     * @param \Illuminate\Support\Collection $attributes
     */
    public static function createField($fieldName, Field $field = null, $attributes = []) {

        // If a field type was not set, use Input as default
        if (is_null($field)) {
            return (new Input($fieldName))->create($fieldName, $attributes);

        }

        // If it was, use the specified type to create the field
        return $field->create($fieldName, $attributes);

    }

}