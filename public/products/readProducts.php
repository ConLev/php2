<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../../config/config.php';

try {
    $message = '';
    $perPage = 4;
    $page = ((int)$_GET['page'] ?? 0);
    $startPage = $page * $perPage;
    $navItems = getNav();
    $template = ($_SESSION['login']['admin']) ? 'adminProductItem.html' : 'userProductItem.html';
    $template = TemplateEngine::getInstance()->twig->load($template);
    $products = DB::getInstance()->fetchAll("SELECT * FROM `products` LIMIT $startPage, $perPage");
    $year = date("Y");
    if (empty((array)$products)) {
        $message = 'К сожалению, это все имеющиеся товары';
    }

    echo $template->render([
        'title' => 'products',
        'navItems' => $navItems,
        'message' => $message,
        'products' => $products,
        'page' => $page,
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}