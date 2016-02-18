<?php

namespace App\Exceptions;

use Exception;

class EntityNotFoundException extends Exception {

    /**
     * Create a new exception instance.
     *
     * @param  string  $table
     * @return void
     */
    public function __construct($table)
    {
        parent::__construct("Specified table '{$table}' not found.");
    }

}