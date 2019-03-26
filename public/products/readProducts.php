<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../../config/config.php';

try {
    $perPage = 4;
    $rawProducts = !empty($_GET['rawProducts']);
    $admin = ($_SESSION['login']['admin']) ? 1 : 0;
    $templateName = $rawProducts ? 'productsList.html' : 'productsPage.html';
    $page = (int)($_GET['page'] ?? 0);
    $startPage = $page * $perPage;
    $navItems = getNav();
    $template = TemplateEngine::getInstance()->twig->load($templateName);
    $products = DB::getInstance()->fetchAll("SELECT * FROM `products` LIMIT $startPage, $perPage");
    $year = date("Y");

    echo $template->render([
        'title' => 'products',
        'navItems' => $navItems,
        'products' => $products,
        'page' => $page,
        'admin' => $admin,
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}