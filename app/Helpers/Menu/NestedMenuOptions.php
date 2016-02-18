<?php

namespace App\Helpers\Menu;

trait NestedMenuOptions {

    protected $icon;
    protected $route;
    protected $name;
    protected $label;

    public function route($route) {
        $this->route = $route;
        return $this;
    }

    public function icon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function label($label) {
        $this->label = $label;
        return $this;
    }

    public function name($name) {
        $this->name = $name;
        return $this;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getName() {
        return $this->name;
    }

    public function getBaseRoute() {
        return $this->route;
    }

}