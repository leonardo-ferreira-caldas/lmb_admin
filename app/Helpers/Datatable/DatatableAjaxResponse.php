<?php

namespace App\Helpers\Datatable;

use Illuminate\Contracts\Support\Jsonable;

class DatatableAjaxResponse implements Jsonable  {

    private $rows;
    private $draw;
    private $actions;
    private $totalRowsSize;
    private $filteredRowsSize;

    public function __construct($rows, $actions, $filteredRowsSize, $totalRowsSize, $draw) {
        $this->rows             = $rows;
        $this->actions          = $actions;
        $this->draw             = $draw;
        $this->filteredRowsSize = $filteredRowsSize;
        $this->totalRowsSize    = $totalRowsSize;
    }

    /**
     * Serialize the response to client's datatable
     *
     * @return array
     */
    public function toJson($options = 0) {
        return json_encode([
            'draw'            => $this->draw,
            'data'            => $this->getFormattedRows(),
            'recordsFiltered' => $this->filteredRowsSize,
            'recordsTotal'    => $this->totalRowsSize
        ], $options);
    }

    /**
     * Check if there is actions to load
     *
     * @return boolean
     */
    public function hasActions() {
        return count($this->actions);
    }

    /**
     * Return all the found query rows formatted as the datatable expects
     *
     * @return array
     */
    public function getFormattedRows() {
        $response = [];

        foreach ($this->rows as $rowIndex => $rowData) {
            $response[$rowIndex] = $this->formatSingleRow($rowData['columns']);

            if ($this->hasActions()) {
                $response[$rowIndex]['datatable.actions'] = $this->addColumnActions($rowData['keys']);
            }

        }

        return $response;
    }

    /**
     * Get a single row and format it in datatable expected format
     *
     * @param $columns
     * @return array
     */
    public function formatSingleRow($columns) {
        $formattedRow = [];

        foreach($columns as $column) {
            $formattedRow[$column['name']] = $column['value'];
        }

        return $formattedRow;
    }

    /**
     * Load the view column actions and return it rendered as HTML
     *
     * @param $keys
     * @return string
     */
    public function addColumnActions($keys) {
        return view('crud.datatable.column_actions', [
            'datatable_actions' => $this->actions,
            'keys'              => $keys
        ])->render();
    }
}