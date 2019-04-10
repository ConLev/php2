<?php

namespace App\Models;

use App\Classes\DB;

class Orders extends Model
{
    protected static $table = 'orders';

    protected static $schema = [
        [
            'name' => 'id',
            'type' => 'int'
        ],
        [
            'name' => 'user_id',
            'type' => 'int'
        ],
        [
            'name' => 'address',
            'type' => 'string'
        ],
        [
            'name' => 'dateCreate',
            'type' => 'string',
            'nullable' => true,
        ],
        [
            'name' => 'dateChange',
            'type' => 'string',
            'nullable' => true,
        ],
        [
            'name' => 'status',
            'type' => 'int'
        ],
    ];

    public static function getOrders(
        ?array $filters = [],
        ?array $orders = [],
        ?int $limitCount = null,
        ?int $limitOffset = null
    ): array
    {
        $usersOrders = static::get($filters, $orders, $limitCount, $limitOffset);

        if (empty($usersOrders)) {
            return $usersOrders;
        }
        return $usersOrders;
    }

    public static function getUserOrders($id)
    {
        return Orders::getOrders([
            [
                'col' => 'user_id',
                'oper' => '=',
                'value' => $id,
            ],
        ]);
    }

    public static function delete($param)
    {
        $sql = "DELETE FROM `orders` WHERE `orders`.`id` = :id";
        return DB::getInstance()->exec($sql, $param);
    }
}