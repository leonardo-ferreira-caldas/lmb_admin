<?php

namespace App\Helpers\Menu;

use App\Helpers\Menu\BaseMenu;
use Illuminate\Routing\Router;

class MenuCrud extends BaseMenu {

    const ROUTE_LIST = 'list';
    const ROUTE_INSERT_VIEW = 'add.get';
    const ROUTE_INSERT_REQUEST = 'add.post';
    const ROUTE_UPDATE_VIEW = 'edit.get';
    const ROUTE_UPDATE_REQUEST = 'edit.post';
    const ROUTE_DELETE = 'delete';

    private $target;

    public function __construct($target) {
        $this->target = $target;
    }

    public function getNamespace() {
        return 'App\Http\Cruds';
    }

    public function registerRoutes(Router $router) {
        $this->registerGET($router,  config('admin.routes.crud.list'),    'getList',    self::ROUTE_LIST);
        $this->registerGET($router,  config('admin.routes.crud.insert'),  'getInsert',  self::ROUTE_INSERT_VIEW);
        $this->registerGET($router,  config('admin.routes.crud.update'),  'getUpdate',  self::ROUTE_UPDATE_VIEW);
        $this->registerGET($router,  config('admin.routes.crud.delete'),  'getDelete',  self::ROUTE_DELETE);
        $this->registerPOST($router, config('admin.routes.crud.insert'),  'postInsert', self::ROUTE_INSERT_REQUEST);
        $this->registerPOST($router, config('admin.routes.crud.update'),  'postUpdate', self::ROUTE_UPDATE_REQUEST);
    }

    public function registerGET(Router $router, $route, $target, $name) {
        $router->get($this->buildRoute($route), $this->buildTarget($target))->name($this->buildRouteName($name))->middleware('auth');
    }

    public function registerPOST(Router $router, $route, $target, $name) {
        $router->post($this->buildRoute($route), $this->buildTarget($target))->name($this->buildRouteName($name))->middleware('auth');
    }

    private function buildRoute($route) {
        return $this->getBaseRoute() . DIRECTORY_SEPARATOR . $route;
    }

    private function buildTarget($target) {
        return $this->target . "@" . $target;
    }

    private function buildRouteName($name) {
        return $this->getName() . "." . $name;
    }

    public function getTarget() {
        return $this->target;
    }

    public function getRoute() {
        return route($this->buildRouteName(self::ROUTE_LIST));
    }

}