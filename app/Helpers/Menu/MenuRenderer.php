<?php

namespace App\Helpers\Menu;

use stdClass;

class MenuRenderer {

    private $list;

    public function get() {
        $this->list = $this->build(MenuBuilder::getInstance()->get());
        return $this->list;
    }

    public function build(array $menus) {
        $listMenus = [];

        foreach ($menus as $name => $menu) {
            $std = new stdClass();
            $std->has_submenus = $menu->hasSubmenus();
            $std->label        = $menu->getLabel();
            $std->icon         = $menu->getIcon();

            if ($menu->hasSubmenus()) {
                $std->route = "#";
                $std->submenus = $this->build($menu->getSubmenuBuilder()->get());
            } else {
                $std->route = $menu->getRoute();
            }

            $listMenus[] = $std;
        }

        return $listMenus;
    }

}