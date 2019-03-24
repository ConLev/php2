<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../../config/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : false;

if (!$id) {
    echo 'id не передан';
    exit();
}

try {
    $navItems = getNav();
    $template = TemplateEngine::getInstance()->twig->load('showProduct.html');
    $product = DB::getInstance()->fetchOne("SELECT * FROM `products` WHERE `id` = $id");
    $year = date("Y");

    echo $template->render([
        'title' => 'product $id',
        'navItems' => $navItems,
        'h1' => "Товар $id",
        'product' => $product,
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}