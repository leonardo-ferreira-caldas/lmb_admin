<?php

namespace App\Helpers\Menu;

use App\Helpers\Menu\BaseMenu;
use Illuminate\Routing\Router;

class MenuPage extends BaseMenu {

    private $target;

    public function __construct($target) {
        $this->target = $target;
    }

    public function getNamespace() {
        return 'App\Http\Controllers';
    }

    public function registerRoutes(Router $router) {
        $route = $router->get($this->route, $this->target)->middleware('auth');

        if (!is_null($this->route)) {
            $route->name($this->name);
        }
    }

    public function getRoute() {
        return $this->getBaseRoute();
    }

    public function getTarget() {
        return $this->target;
    }

}