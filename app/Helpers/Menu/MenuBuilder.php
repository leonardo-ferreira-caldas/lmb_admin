<?php

namespace App\Helpers\Menu;

use Closure;
use App\Helpers\Patterns\Singleton;

class MenuBuilder {

    use Singleton;

    private $list = [];

    public function page($route) {
        return $this->add(new MenuPage($route));
    }

    public function crud($target) {
        return $this->add(new MenuCrud($target));
    }

    public function submenu(Closure $closure) {
        return $this->add(new Submenu($closure));
    }

    private function add($menu) {
        $index = count($this->list);
        $this->list[$index] = $menu;
        return $this->list[$index];
    }

    public function get() {
        return $this->list;
    }


}