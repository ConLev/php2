<?php

namespace App\Controllers;

use App\Models\Orders;
use Exception;

class OrdersController extends Controller
{
    protected $template;
    protected $admin;

    public function index()
    {
        try {
            $perPage = 4;
            $rawProducts = !empty($_GET['rawProducts']);
            $this->template = $rawProducts ? 'productsList.html' : 'productsPage.html';
            $page = (int)($_GET['page'] ?? 0);
            $startPage = $page * $perPage;
            $products = Orders::get([[
                'col' => 'isActive',
                'oper' => '=',
                'value' => 1,
            ]],
                [], $perPage, $startPage);

            return $this->render([
                'title' => 'products',
                'products' => $products,
                'page' => $page,
                'admin' => $this->admin,
                'year' => date("Y"),
            ]);

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $current_id = isset($_GET['id']) ? (int)$_GET['id'] : false;

            if (!$current_id) {
                echo 'id не передан';
                exit();
            }

            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $discount = $_POST['discount'] ?? '';
            $image = $_POST['image'] ?? '';
            $isActive = $_POST['isActive'] ?? '';
            $categoryId = $_POST['categoryId'] ?? '';
            $h1 = 'Обновить товар';

            $this->template = $template = 'updateProduct.html';
            $product = Orders::getByKey($current_id);

            if ($name && $description && $price && $discount && $image) {
                //пытаемся обновить товар
                $attributes = ['id' => (int)$current_id, 'name' => $name, 'description' => $description,
                    'price' => $price, 'discount' => $discount, 'image' => $image, 'isActive' => $isActive,
                    'categoryId' => $categoryId, 'current_id' => $current_id];
                $product = new Orders($attributes);
                $result = $product->save();
                //при успешном обновлении возвращаемся на страницу просмотра товаров
                if ($result) {
                    header("Location: /products/", TRUE, 301);

                    //очишаем кеш (id)
                    header("Cache-Control: no-cache");
                }
            }

            return $this->render([
                'title' => 'update_product',
                'h1' => "$h1",
                'product' => $product,
                'year' => date("Y"),
            ]);

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $discount = $_POST['discount'] ?? '';
        $image = $_POST['image'] ?? '';
        $isActive = $_POST['isActive'] ?? '';
        $categoryId = $_POST['categoryId'] ?? '';
        $h1 = 'Добавить товар';

        try {
            $this->template = $template = 'createProduct.html';

            if ($name && $description && $price && $image) {
                //пытаемся добавить товар
                $attributes = ['name' => $name, 'description' => $description, 'price' => $price,
                    'discount' => $discount, 'image' => $image, 'isActive' => $isActive, 'categoryId' => $categoryId];
                $product = new Orders($attributes);
                $result = $product->save();
                //при успешном добавлении товара возвращаемся на страницу просмотра товаров
                if ($result) {
                    header("Location: /products/", TRUE, 301);
                }
            }

            return $this->render([
                'title' => 'create_product',
                'h1' => "$h1",
                'year' => date("Y"),
            ]);

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function view()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : false;

        if (!$id) {
            echo 'id не передан';
            exit();
        }

        try {
            $this->template = $template = 'showProduct.html';
            $product = Orders::getByKey($id);

            return $this->render([
                'title' => "product_$id",
                'h1' => "Товар $id",
                'product' => $product,
                'year' => date("Y"),
            ]);

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $id = (int)$_GET['id'] ?? '';

        try {
            $param = ['id' => $id];
            $result = Orders::delete($param);

            if ($result) {
                header("Location: /products/", TRUE, 301);
            }

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}