<?php

namespace App\Database;

use App\Exceptions\EntityNotFoundException;
use DB;
use Schema;

class Metadata {

    public static function getTableColumns($table) {
        if (!self::tableExists($table)) {
            throw new EntityNotFoundException($table);
        }

        return Schema::getColumnListing($table);
    }

    public static function getTablePrimaryKeys($table) {
        return Queries::getTablePrimaryKeys($table);
    }

    public static function tableExists($table) {
        return Schema::hasTable($table);
    }

}