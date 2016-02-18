<?php

namespace App\Helpers\Forms\Fields;

/**
 * Class used to create a datatable select filter from a database table
 *
 * Class DatatableFilterSelect
 * @package App\Helpers\Datatable
 */
class Input extends Field {

    /**
     * Set the list of option values for the select field
     *
     * @param string $type The type of the input
     * @param string $value The initial value
     */
    public function __construct($type = "text", $value = null) {
        $this->addAttribute('type', $type);

        if (!is_null($value)) {
            $this->addAttribute('value', $value);
        }
    }

    /**
     * Return the field HTML
     *
     * @return string
     */
    protected function getHTML($attributes, $customAttributes = []) {
        return view('forms.fields.input', [
            'attributes' => $attributes,
            'custom_attributes' => $customAttributes
        ]);
    }

}