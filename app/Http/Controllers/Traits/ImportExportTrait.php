<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait ImportExportTrait
{
    /**
     * @var array
     */
    protected $search_bindings = [];
    /**
     * Creates the search scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $q
     * @param string $search
     * @param float|null $threshold
     * @param  boolean $entireText
     * @param  boolean $entireTextOnly
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExport(Builder $q, $fields, $threshold = null, $entireText = false, $entireTextOnly = false)
    {
        return $this->scopeExportRestricted($q, $fields, null, $threshold, $entireText, $entireTextOnly);
    }
    public function scopeExportRestricted(Builder $q, $fields, $labels, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
    {
        $query = clone $q;
        $query->select(DB::raw($this->getSelectStatement($fields)));
        $this->makeRelateJoins($query);
        $this->mergeRelateQueries($query, $q);
        return $query;
    }

    public function getSelectStatement($fields){
        $statement =[];
        foreach ($fields as $key => $value){
            $statement[] = $key.(!empty($value) ? ' AS '.$value : '');
        }
        return implode(", ",$statement);
    }
    /**
     * Returns database driver Ex: mysql, pgsql, sqlite.
     *
     * @return array
     */
    protected function getDBriver() {
        $key = $this->connection ?: Config::get('database.default');
        return Config::get('database.connections.' . $key . '.driver');
    }
    /**
     * Adds the sql joins to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    protected function makeRelateJoins(Builder $query)
    {
        foreach ($this->relates as $table => $keys) {
            $query->leftJoin($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
                if (array_key_exists(2, $keys) && array_key_exists(3, $keys)) {
                    $join->where($keys[2], '=', $keys[3]);
                }
            });
        }
    }
    /**
     * Merge our cloned query builder with the original one.
     *
     * @param \Illuminate\Database\Eloquent\Builder $clone
     * @param \Illuminate\Database\Eloquent\Builder $original
     */
    protected function mergeRelateQueries(Builder $clone, Builder $original) {
        $tableName = DB::connection($this->connection)->getTablePrefix() . $this->getTable();
        if ($this->getDatabaseDriver() == 'pgsql') {
            $original->from(DB::connection($this->connection)->raw("({$clone->toSql()}) as {$tableName}"));
        } else {
            $original->from(DB::connection($this->connection)->raw("({$clone->toSql()}) as `{$tableName}`"));
        }
        $original->setBindings(
            array_merge_recursive(
                $clone->getBindings(),
                $original->getBindings()
            )
        );
    }
}