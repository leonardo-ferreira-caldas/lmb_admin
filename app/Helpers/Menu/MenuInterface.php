<?php

namespace App\Helpers\Menu;

interface MenuInterface {

    public function getIcon();
    public function getLabel();
    public function icon($icon);
    public function label($label);
    public function hasSubmenus();

}