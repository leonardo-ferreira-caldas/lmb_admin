<?php

namespace App\Helpers\Datatable\Actions;

use Closure;

class DatatableActionsItemBuilder {

    private $label;
    private $route;
    private $icon;

    public function __construct($label, Closure $route, $icon) {
        $this->label = $label;
        $this->route = $route;
        $this->icon = $icon;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getRoute(array $primaryKeys) {
        $closure = $this->route;
        return $closure($primaryKeys);
    }

    public function getIcon() {
        return $this->icon;
    }

}