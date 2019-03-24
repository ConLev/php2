<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../../config/config.php';

$current_id = isset($_GET['id']) ? (int)$_GET['id'] : false;

if (!$current_id) {
    echo 'id не передан';
    exit();
}

$new_id = (int)$_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$image = $_POST['image'] ?? '';
$h1 = 'Обновить товар';

try {
    $navItems = getNav();
    $template = TemplateEngine::getInstance()->twig->load('updateProduct.html');
    $product = DB::getInstance()->fetchOne("SELECT * FROM `products` WHERE `id` = $current_id");
    $year = date("Y");

    if ($new_id && $name && $description && $price && $image) {
//пытаемся обновить товар
        $result = DB::getInstance()->exec("UPDATE `products` SET `id` = :id, `name` = :name, 
                      `description` = :description, `price` = :price, `image` = :image 
WHERE `products`.`id` = :current_id", ['id' => $new_id, 'name' => $name, 'description' => $description,
            'price' => $price, 'image' => $image, 'current_id' => $current_id]);
//при успешном обновлении возвращаемся на страницу просмотра товаров
        if ($result) {
            header("Location: /products/readProducts.php", TRUE, 301);
            //очишаем кеш (id)
            header("Cache-Control: no-cache");
        }
    }

    echo $template->render([
        'title' => 'update_product',
        'navItems' => $navItems,
        'h1' => "$h1",
        'product' => $product,
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}