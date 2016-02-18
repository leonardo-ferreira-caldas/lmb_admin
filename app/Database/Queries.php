<?php

namespace App\Database;

use DB;
use App\Helpers\Formatters\SQL;
use Illuminate\Database\Query\Builder;

class Queries {

    /**
     * Return the crud's table primary keys
     *
     * @param $table
     * @return array
     */
    public static function getTablePrimaryKeys($table) {
        $result = DB::select("
            SELECT
                COLUMN_NAME
            FROM
                information_schema.COLUMNS
            WHERE
                TABLE_SCHEMA = ? AND
                TABLE_NAME = ? AND
                COLUMN_KEY = 'PRI'", [env('DB_DATABASE'), $table]);

        return array_map(function($value) {
            return $value->COLUMN_NAME;
        }, $result);
    }

    /**
     * Return all the rows from the crud's table
     *
     * @param $table
     * @param $columns
     *
     * @return array
     */
    public static function getTableRows($table, $columns) {
        return DB::table($table)->select($columns)->get();
    }

    /**
     * Return the filtered, ordered and paginated rows from the crud's table
     *
     * @param string $table
     * @param array $columns
     * @param int $start
     * @param int $length
     * @param array $filters
     * @param null|array $order
     *
     * @return array
     */
    public static function getFilteredAjaxTableRows($table, $columns, $start, $length, $filters = [], $order = null) {
        $query = DB::table($table)->select($columns);
        return self::getFilteredQueryListRows($query, $start, $length, $filters, $order);
    }

    /**
     * Return the filtered, ordered and paginated rows from the crud's custom query
     *
     * @param Builder $query
     * @param int $start
     * @param int $length
     * @param array $filters
     * @param null $order
     * @return array
     */
    public static function getFilteredQueryListRows(Builder $query, $start, $length, $filters = [], $order = null) {

        // Get the total count of rows with no filters and pagination
        $countTotal = $query->count();

        // Check if any filters were submitted
        if ($filters) {
            foreach ($filters as $filterName => $filterValue) {

                // Check if there is any filter operator in the field string
                $operation = SQL::findOperationWhere($filterValue);

                $query->where($filterName, $operation['operation'], $operation['text']);
            }
        }

        // Get the total count of rows filtered, but without pagination
        $countFiltered = $query->count();

        // Execute pagination
        $query->skip($start)->take($length);

        // Check if an order by was submitted
        if ($order) {
            $query->orderBy($order['name'], $order['dir']);
        }

        return [
            'rows'           => $query->get(),
            'count_filtered' => $countFiltered,
            'count_total'    => $countTotal
        ];
    }

    /**
     * Return the crud's custom query columns
     *
     * @param Builder $builder
     * @return array
     */
    public static function getQueryColumns(Builder $builder) {

        // Get the first result of the query
        $resultSet = $builder->skip(0)->take(1)->get();

        // Get the first line from the result query
        $firstRow = array_shift($resultSet);

        if (empty($firstRow)) {
            return [];
        }

        // Convert stdClass $firstRow to array
        $stdClassVars = get_object_vars($firstRow);

        // Return only the column names
        return array_keys($stdClassVars);
    }

    /**
     * Return the table's rows formatted for a select filter
     *
     * @param string $table
     * @param string $keyColumn
     * @param string $descriptionColumn
     */
    public static function getTableFilter($table, $keyColumn, $descriptionColumn) {
        $result = DB::table($table)->select($keyColumn, $descriptionColumn)->get();

    }

    public static function applyClause(Builder $query, array $where) {
        foreach ($where as $clauseName => $clauseValue) {
            $query->where($clauseName, '=', $clauseValue);
        }
        return $query;
    }

    public static function insert($tableName, $columns) {
        return DB::table($tableName)->insert($columns);
    }

    public static function update($tableName, $columns, $where) {
        return self::applyClause(DB::table($tableName), $where)->update($columns);
    }

    public static function delete($tableName, $where) {
        return self::applyClause(DB::table($tableName), $where)->delete();
    }

    public static function getSingleTableRow($tableName, $where) {
        return self::applyClause(DB::table($tableName), $where)->first();
    }
}