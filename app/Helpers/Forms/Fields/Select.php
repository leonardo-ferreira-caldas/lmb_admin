<?php

namespace App\Helpers\Forms\Fields;

use App\Database\Queries;
use App\Helpers\Formatters\Vector;

/**
 * Class used to create a datatable select filter from a database table
 *
 * Class DatatableFilterSelect
 * @package App\Helpers\Datatable
 */
class Select extends Field {

    /**
     * The name of the table
     *
     * @var string
     */
    private $table;

    /**
     * The name of the key column that will be used to filter the datatable
     *
     * @var string
     */
    private $keyColumn;

    /**
     * The name of the column that will be displayed in the select filter
     *
     * @var string
     */
    private $descriptionColumn;

    /**
     * The list of values/options to fill the select
     *
     * @var string
     */
    private $options;

    /**
     * The value of the select option in the select
     *
     * @var string
     */
    private $selectedValue;

    /**
     * The initial/default text of the select field
     *
     * @var string
     */
    private $defaultText = "Choose one...";


    /**
     * Set the list of option values for the select field
     *
     * @param array $options List of options
     * @param mixed $selectedValue Selected option
     */
    public function __construct(array $options = []) {
        $this->options = $options;
    }

    /**
     * Set the information to get list of select filter from the database
     *
     * @param $table
     * @param $keyColumn
     * @param $descriptionColumn
     * @param mixed $selectedValue Selected option
     */
    public function fromTable($table, $keyColumn, $descriptionColumn = null, $selectedValue = null) {
        $this->table             = $table;
        $this->keyColumn         = $keyColumn;
        $this->descriptionColumn = $descriptionColumn ?: $keyColumn;
        $this->selectedValue     = $selectedValue;
        return $this;
    }

    /**
     * Set the selected value of the select field
     *
     * @param mixed $selectedValue Selected option
     */
    public function selected($selectedValue) {
        $this->selectedValue = $selectedValue;
        return $this;
    }

    /**
     * Set the initial/default text to the select
     *
     * @param mixed $text
     */
    public function defaultText($text) {
        $this->defaultText = $text;
        return $this;
    }

    /**
     * Return the select options from a database table
     *
     * @return array
     */
    private function getTableOptions() {
        $rows = Queries::getTableRows($this->table, [$this->keyColumn, $this->descriptionColumn]);
        $options = collect();

        foreach ($rows as $row) {
            $options->push($this->createOption($row->{$this->keyColumn}, $row->{$this->descriptionColumn}));
        }

        return $options->toArray();
    }

    /**
     * Return the list of options
     *
     * @return array
     */
    private function getOptions() {
        $this->selectedValue = $this->selectedValue ?: $this->getValue();

        if (!empty($this->table)) {
            return $this->getTableOptions();
        }

        if (!Vector::isAssociative($this->options)) {
            $this->options = Vector::toAssociative($this->options);
        }

        $options = collect();

        foreach ($this->options as $optionValue => $optionText) {
            $options->push($this->createOption($optionValue, $optionText));
        }

        return $options->toArray();
    }

    /**
     * Create a single option array structure
     *
     * @param string $value
     * @param string $text
     * @return array
     */
    private function createOption($value, $text) {
        return [
            "value"    => $value,
            "text"     => $text,
            "selected" => !empty($this->selectedValue) && $this->selectedValue == $value
        ];
    }

    /**
     * Return the field HTML
     *
     * @return string
     */
    protected function getHTML($attributes, $customAttributes) {
        return view('forms.fields.select', [
            'options'     => $this->getOptions(),
            'defaultText' => $this->defaultText,
            'attributes'  => $attributes,
            'custom_attributes' => $customAttributes
        ]);
    }

}