<?php

namespace App\Helpers\Patterns;

trait Singleton {

    private static $instance;

    public static function getInstance() {
        if (empty(self::$instance)) {
            return self::$instance = new static();
        }
        return self::$instance;
    }

}