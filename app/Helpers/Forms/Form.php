<?php

namespace App\Helpers\Forms;

use App\Helpers\Formatters\String;
use App\Helpers\Forms\Fields\Factory;
use App\Helpers\Formatters\Vector;
use App\Database\Queries;

trait Form {

    /**
     * Get all the form fields to render
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getInsertFields() {
        $columns          = $this->getTableColumns();
        $formCustomFields = $this->getCustomFormFields();
        $fields           = collect();

        foreach ($columns as $column) {
            $customProperties = $this->getInsertAttributes($column, $formCustomFields);

            // Check if the field is not to be shown
            if ($customProperties->has('hidden')) {
                continue;
            }

            $field = Factory::createField($column, $customProperties->get('type'), $customProperties->toArray());
            $fields->push($field);
        }

        return $fields;
    }

    /**
     * Get all the update fields
     *
     * @param array $keys
     * @return \Illuminate\Support\Collection
     */
    protected function getUpdateFields(array $keys) {
        $columns          = $this->getTableColumns();
        $rowData          = $this->getRowData($keys);
        $formCustomFields = $this->getCustomFormFields();
        $fields           = collect();

        foreach ($columns as $column) {
            $customProperties = $this->getUpdateAttributes($column, $formCustomFields, $rowData);

            // Check if the field is not to be shown
            if ($customProperties->has('hidden')) {
                continue;
            }

            $field = Factory::createField($column, $customProperties->get('type'), $customProperties->toArray());
            $fields->push($field);
        }

        return $fields;
    }

    /**
     * Return all merge attributes to insert fields
     *
     * @param string $column
     * @param array $formCustomFields
     * @return \Illuminate\Support\Collection
     */
    protected function getInsertAttributes($column, $formCustomFields) {
        $collection = collect(Vector::findOrEmptyArray($formCustomFields, $column));
        return $collection->merge($collection->get("insert", []));
    }

    /**
     * Return all merge attributes to update fields
     *
     * @param string $column
     * @param array $formCustomFields
     * @param array $rowData
     * @return \Illuminate\Support\Collection
     */
    protected function getUpdateAttributes($column, $formCustomFields, $rowData) {
        $collection = collect(array_merge(
            Vector::findOrEmptyArray($formCustomFields, $column),
            Vector::findOrEmptyArray($rowData, $column)));

        return $collection->merge($collection->get("update", []));
    }

    /**
     * Return a single row from the crud's table
     *
     * @param array $keys
     * @return array
     */
    protected function getRowData(array $keys) {
        if (empty($keys)) {
            return [];
        }

        $rowData = Queries::getSingleTableRow($this->getTable(), $keys);
        $rowData = get_object_vars($rowData);
        $formatted = [];

        foreach ($rowData as $columnName => $columnValue) {
            $formatted[$columnName] = ['value' => $columnValue];
        }

        return $formatted;
    }

    /**
     * Handle insert process
     *
     * @param $postData
     */
    protected function processInsert($postData) {
        $columns = collect($postData)->only($this->getTableColumns())->toArray();

        Queries::insert($this->getTable(), $columns);
    }

    /**
     * Handle update process
     *
     * @param $postData
     */
    protected function processUpdate($postData) {
        $collection  = collect($postData);
        $keys        = $this->getTablePrimaryKeys();
        $update      = $collection->only($this->getTableColumns())->except($keys)->toArray();
        $clause      = $collection->only($keys)->toArray();

        Queries::update($this->getTable(), $update, $clause);
    }

    /**
     * Handle delete process
     *
     * @param $postData
     */
    protected function processDelete($postData) {
        $keys        = $this->getTablePrimaryKeys();
        $clause      = collect($postData)->only($keys)->toArray();

        Queries::delete($this->getTable(), $clause);
    }
}