<?php

namespace App\Helpers\Menu;

use Illuminate\Routing\Router;
use Closure;

class Submenu implements MenuInterface {

    use NestedMenuOptions;

    private $buider;

    public function __construct(Closure $closure) {
        $builder = app('App\Helpers\Menu\MenuBuilder');
        $closure($builder);
        $this->buider = $builder;
    }

    public function hasSubmenus() {
        return true;
    }

    public function getSubmenuBuilder() {
        return $this->buider;
    }

}