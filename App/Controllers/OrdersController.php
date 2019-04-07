<?php

namespace App\Controllers;

use App\Models\Cart;
use App\Models\Orders;
use App\Models\OrdersProducts;
use Exception;

class OrdersController extends Controller
{
    protected $template;
    protected $userLogin;
    protected $userName;
    protected $id;
    protected $admin;

    public function __construct()
    {
        $this->userLogin = $_SESSION['login']->login;
        $this->userName = $_SESSION['login']->name;
        $this->id = $_SESSION['login']->id;
        Controller::__construct();
    }

    /**
     * @throws Exception
     */
    public function createOrder()
    {
        if (isset($this->userLogin) && isset($this->userName)) {
            $cart = Cart::getBasket($this->id);
            if (!empty($cart)) {
                $attributes = ['user_id' => (int)$this->id, 'address' => 'Воронеж', 'status' => 1];
                $order_id = new Orders($attributes);
                $order_id = $order_id->save();
                if (!empty($order_id)) {
                    foreach ($cart as $product) {
                        $attributes = ['order_id' => (int)$order_id->id, 'product_id' => (int)$product->product_id,
                            'amount' => (int)$product->quantity, 'status' => 1];
                        $order = new OrdersProducts($attributes);
                        $order = $order->save();
                    }
                    if (!empty($order)) {
                        $clearCart = new CartController();
                        $clearCart->clear();
                        return true;
                    } else {
                        $data = ['order_id' => (int)$order_id->id];
                        $this->removeOrder($data);
                        throw new Exception('Ошибка при создании заказа');
                    }
                } else {
                    throw new Exception('Ошибка при создании заказа');
                }
            } else {
                throw new Exception('Корзина пуста');
            }
        } else {
            header("Location: /authentication/", TRUE, 301);
        }
    }

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