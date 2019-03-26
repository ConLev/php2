<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../../config/config.php';

//echo '<pre>';
//var_dump($_POST);
//die;
//echo '</pre>';

//?? - заменяет isset($a) ? $a : '';
$id = (int)$_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$image = $_POST['image'] ?? '';
$h1 = 'Добавить товар';

try {
    $navItems = getNav();
    $template = TemplateEngine::getInstance()->twig->load('createProduct.html');
    $year = date("Y");

    if ($id && $name && $description && $price && $image) {
//пытаемся добавить товар
        $result = DB::getInstance()->exec("INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) 
VALUES (:id, :name, :description, :price, :image)",
            ['id' => $id, 'name' => $name, 'description' => $description, 'price' => $price, 'image' => $image]);
//при успешном добавлении товара возвращаемся на страницу просмотра товаров
        if ($result) {
            header("Location: /products/readProducts.php", TRUE, 301);
        }
    }

    echo $template->render([
        'title' => 'create_product',
        'navItems' => $navItems,
        'h1' => "$h1",
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}