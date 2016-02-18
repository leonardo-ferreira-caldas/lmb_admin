<?php

namespace App\Helpers\Renderer;

use App\Helpers\Formatters\Vector;
use App\Helpers\Menu\MenuBuilder;
use App\Helpers\Menu\MenuCrud;
use App\Helpers\Patterns\Singleton;
use App\Helpers\Formatters\Url;
use Closure;

class CrudRenderer {

    use Singleton;

    private $crudClass;
    private $computedMenus;
    public $pageTitle;
    public $pageBreadcrumb;
    public $routes;

    public static function inicialize($crudClass) {
        self::getInstance()->load($crudClass);
    }

    public function load($crudClass) {
        $this->crudClass = Vector::getLastSplited($crudClass, "\\");
        $this->computedMenus = MenuBuilder::getInstance()->get();

        $this->loadPageTitle();
        $this->loadPageBreadcrumbs();
        $this->loadRoutes();
    }

    public function loadPageTitle() {
        $this->pageTitle = $this->getProperty($this->crudClass, 'getLabel');
    }

    public function loadRoutes() {
        $baseName = $this->getProperty($this->crudClass, 'getName');

        $routeList = [
            MenuCrud::ROUTE_LIST,
            MenuCrud::ROUTE_INSERT_VIEW,
            MenuCrud::ROUTE_UPDATE_VIEW,
            MenuCrud::ROUTE_DELETE,
        ];

        foreach ($routeList as $route) {
            $this->routes[$route] = route($baseName . '.' . $route);
        }

    }

    public function loadPageBreadcrumbs() {
        $breadcrumbs = [];

        foreach ($this->computedMenus as $menu) {
            if ($menu->hasSubmenus()) {
                $breadcrumbs[] = $menu->getLabel();

                foreach ($menu->getSubmenuBuilder()->get() as $submenu) {
                    if ($submenu->getTarget() == $this->crudClass) {
                        $breadcrumbs[] = $submenu->getLabel();
                        break 2;
                    }
                }
            } else if ($menu->getTarget() == $this->crudClass) {
                $breadcrumbs[] = $menu->getLabel();
                break;
            }
            $breadcrumbs = [];
        }

        $this->pageBreadcrumb = $breadcrumbs;
    }

    private function getProperty($className, $method) {
        return $this->iterateMenu($this->computedMenus, function($menu) use ($className, $method) {
            if ($menu->getTarget() == $className) {
                return call_user_func_array(array($menu, $method), []);
            }
        });
    }

    private function iterateMenu(array $menus, Closure $closure) {
        foreach ($menus as $menu) {
            if ($menu->hasSubmenus()) {
                $result = $this->iterateMenu($menu->getSubmenuBuilder()->get(), $closure);
            } else {
                $result = $closure($menu);
            }

            if (!empty($result)) {
                return $result;
            }
        }
    }

    public static function getPageTitle() {
        return self::getInstance()->pageTitle;
    }

    public static function getPageBreadcrumb() {
        return self::getInstance()->pageBreadcrumb;
    }

    public static function getListRoute() {
        return self::getInstance()->routes[MenuCrud::ROUTE_LIST];
    }

    public static function getUpdateRoute($parameters) {
        return Url::httpBuildQuery(self::getInstance()->routes[MenuCrud::ROUTE_UPDATE_VIEW], $parameters);
    }

    public static function getInsertRoute() {
        return self::getInstance()->routes[MenuCrud::ROUTE_INSERT_VIEW];
    }

    public static function getDeleteRoute($parameters) {
        return Url::httpBuildQuery(self::getInstance()->routes[MenuCrud::ROUTE_DELETE], $parameters);
    }
}