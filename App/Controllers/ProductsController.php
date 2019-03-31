<?php

namespace App\Controllers;

use App\Models\Products;
use Exception;

class ProductsController extends Controller
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
            Products::$perPage = $perPage;
            Products::$startPage = $startPage;
            $products = Products::fetchAll();

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

            $new_id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $image = $_POST['image'] ?? '';
            $h1 = 'Обновить товар';

            $this->template = $template = 'updateProduct.html';
            Products::$id = $current_id;
            $product = Products::fetchOne();

            if ($new_id && $name && $description && $price && $image) {
                //пытаемся обновить товар
                $sql = "UPDATE `products` SET `id` = :id, `name` = :name, 
                      `description` = :description, `price` = :price, `image` = :image 
WHERE `products`.`id` = :current_id";

                $param = ['id' => (int)$new_id, 'name' => $name, 'description' => $description,
                    'price' => $price, 'image' => $image, 'current_id' => $current_id];

                $result = Products::exec($sql, $param);

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
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $image = $_POST['image'] ?? '';
        $h1 = 'Добавить товар';

        try {
            $this->template = $template = 'createProduct.html';

            if ($id && $name && $description && $price && $image) {
                //пытаемся добавить товар
                $sql = "INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) 
VALUES (:id, :name, :description, :price, :image)";

                $param = ['id' => (int)$id, 'name' => $name, 'description' => $description, 'price' => $price, 'image' => $image];

                $result = Products::exec($sql, $param);

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
            Products::$id = $id;
            $product = Products::fetchOne();

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
            $sql = "DELETE FROM `products` WHERE `products`.`id` = :id";

            $param = ['id' => $id];

            $result = Products::exec($sql, $param);

            if ($result) {
                header("Location: /products/", TRUE, 301);
            }

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}