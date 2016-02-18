<?php

namespace App\Helpers\Menu;

abstract class BaseMenu implements MenuInterface {

    use NestedMenuOptions;

    public abstract function getNamespace();
    public abstract function getRoute();
    public abstract function getTarget();

    public function hasSubmenus() {
        return false;
    }

}