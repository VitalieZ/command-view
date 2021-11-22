<?php

namespace App\Services\Crud;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MyModel
{
    public function getTable($modelName, $table = null)
    {
        if ($table != null) {
            $table = $table;
        } else {
            $model = Str::of($modelName)->lower();
            $table = Str::plural($model);
        }
        if (!Schema::hasTable($table)) {
            return false;
        }
        return $table;
    }

    public function getFillable($modelName, $table = null)
    {
        if (Schema::hasTable($this->getTable($modelName, $table))) {
            $fields = array();
            $table = DB::select('DESCRIBE ' . $this->getTable($modelName, $table));
            if ($table) {
                foreach ($table as $item) {
                    $fields[] = $item->Field;
                }
            }
            $string = implode("','", $fields);
            $slice = Str::of($string)->after("id',");
            return $slice . "'";
        }
        return false;
    }

    public function getVariablesModel($stub, $modelName, $resource = null, $table = null)
    {
        $symbol = "$";
        $replace = [
            '{{ table }}' => ($this->getTable($modelName, $table) == false) ? "" : "protected " . $symbol . "table = '" . $this->getTable($modelName, $table) . "';",
            '{{ fillable }}' => ($resource == null || $this->getFillable($modelName, $table) == false) ? "" : "protected " . $symbol . "fillable = [" . $this->getFillable($modelName, $table) . "];",
        ];
        return str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );
    }
}
