<?php

namespace App\Controllers;

use App\Models\OrdersProducts;
use Exception;

class OrdersController extends Controller
{
    protected $template;
    protected $admin;

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function updateStatus(array $data)
    {
        if (empty($data['id']) || empty($data['order_id']) || empty($data['product_id']) || empty($data['amount'])
            || empty($data['status'])) {
            throw new Exception('Параметры не переданы');
        }
        //пытаемся обновить статус заказа
        $attributes = ['id' => (int)$data['id'], 'order_id' => (int)$data['order_id'],
            'product_id' => (int)$data['product_id'], 'amount' => (int)$data['amount'], 'status' => (int)$data['status']];
        $orderStatus = new OrdersProducts($attributes);
        $result = $orderStatus->save();

        if ($result) {
            return true;
        } else {
            throw new Exception('Ошибка при обновлении статуса заказа');
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function deleteProductOfOrder(array $data)
    {
        $param = ['order_id' => (int)$data['order_id'], 'product_id' => (int)$data['product_id']];
        $result = OrdersProducts::deleteProductOfOrder($param);

        if ($result) {
            return true;
        } else {
            throw new Exception('Ошибка при удалении товара из заказа');
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function removeOrder(array $data)
    {
        $param = ['order_id' => (int)$data['order_id']];
        $result = OrdersProducts::removeOrder($param);

        if ($result) {
            return true;
        } else {
            throw new Exception('Ошибка при удалении заказа');
        }
    }
}