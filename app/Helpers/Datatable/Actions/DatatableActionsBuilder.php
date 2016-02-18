<?php

namespace App\Helpers\Datatable\Actions;

class DatatableActionsBuilder {

    private $list = [];

    public function action($label, $icon, $route) {
        $this->list [] = new DatatableActionsItemBuilder($label, $route, $icon);
    }

    public function get() {
        return $this->list;
    }

}