<?php /** @noinspection SqlResolve */

namespace App\Models;

use App\Classes\DB;

class Products extends Model
{
    protected static $table = 'products';
    public static $perPage;
    public static $startPage;
    public static $id;

    public static function fetchAll()
    {
        $table = static::$table;
        $perPage = static::$perPage;
        $startPage = static::$startPage;
        return DB::getInstance()->fetchAll("SELECT * FROM $table LIMIT $startPage, $perPage");
    }

    public static function fetchOne()
    {
        $table = static::$table;
        $id = static::$id;
        return DB::getInstance()->fetchOne("SELECT * FROM $table WHERE `id` = $id");
    }

    public static function exec($sql, $param)
    {
        return DB::getInstance()->exec($sql, $param);
    }
}