<?php

namespace App\Models;

use App\Classes\DB;

abstract class Model
{
    protected static $table;

    public static function fetchAll()
    {
        $table = static::$table;
        return DB::getInstance()->fetchAll("SELECT * FROM $table");
    }

    public static function fetchOne()
    {
        $table = static::$table;
        return DB::getInstance()->fetchOne("SELECT * FROM $table");
    }

    public static function exec($sql, $param)
    {
        return DB::getInstance()->exec($sql, $param);
    }
}