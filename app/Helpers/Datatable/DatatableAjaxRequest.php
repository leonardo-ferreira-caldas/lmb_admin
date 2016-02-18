<?php

namespace App\Helpers\Datatable;

class DatatableAjaxRequest {

    private $ajaxRequestData;
    private $filters;

    /**
     * Receive the ajax GET request data
     *
     * @param array $ajaxRequestData
     */
    public function __construct(array $ajaxRequestData) {
        $this->ajaxRequestData = $ajaxRequestData;
    }

    /**
     * Return the formatted filters requested by datatable
     *
     * @return array
     */
    public function getFilters($resolvedAmbiguousColumns) {
        if ($this->filters) {
            return $this->filters;
        }

        $filters = [];

        foreach ($this->ajaxRequestData['columns'] as $column) {
            if ($column['searchable'] && !empty($column['name'])) {
                if (!empty($column['search']['value'])) {
                    $columnName = $this->getResolvedAmbiguousFilter($column['name'], $resolvedAmbiguousColumns);
                    $filters[$columnName] = $column['search']['value'];
                }
            }
        }

        return $this->filters = $filters;
    }

    /**
     * Check if there is a resolved ambiguous column for the respective column name
     *
     * @param $columnName
     * @param $resolvedAmbiguousColumns
     */
    private function getResolvedAmbiguousFilter($columnName, $resolvedAmbiguousColumns) {
        if (isset($resolvedAmbiguousColumns[$columnName])) {
            return $resolvedAmbiguousColumns[$columnName];
        }

        return $columnName;
    }

    /**
     * Return the start offset of the datatable pagination
     *
     * @return int
     */
    public function getPagitionStart() {
        return (int) $this->ajaxRequestData['start'];
    }

    /**
     * Return the length of rows of each datatable page
     *
     * @return int
     */
    public function getPaginationLength() {
        return (int) $this->ajaxRequestData['length'];
    }

    /**
     * Property used to control the order of requests made by the datatable
     *
     * @return int
     */
    public function getDraw() {
        return (int) $this->ajaxRequestData['draw'];
    }

    /**
     * Return column name and direction for ordering
     *
     * @return array
     */
    public function getOrder() {
        $order   = $this->ajaxRequestData['order'];
        $columns = $this->ajaxRequestData['columns'];

        if (empty($order)) {
            return [];
        }

        $order = array_shift($order);
        $column = $columns[$order['column']];

        if (empty($column) || (!empty($column) && empty($column['name']))) {
            return [];
        }

        return [
            'name' => $column['name'],
            'dir'  => $order['dir']
        ];
    }
}