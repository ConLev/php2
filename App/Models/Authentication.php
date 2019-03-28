<?php /** @noinspection SqlResolve */

namespace App\Models;

use App\Classes\DB;

class Authentication extends Model
{
    protected static $table = 'users';
    public static $login;
    public static $password;

    public static function fetchOne()
    {
        $table = static::$table;
        $login = static::$login;
        $password = static::$password;
        return DB::getInstance()->fetchOne("SELECT * FROM $table WHERE `login` = '$login' AND `password` = '$password'");
    }
}