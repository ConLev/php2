<?php

namespace App;

use App\Classes\TemplateEngine;

require_once '../config/config.php';

$userName = $_SESSION['login']['name'];
$userLogin = $_SESSION['login']['login'];

if (isset($userLogin) && isset($userName)) {
    try {
        $navItems = getNav();
        $template = TemplateEngine::getInstance()->twig->load('userAccount.html');
        $year = date("Y");

        echo $template->render([
            'title' => 'user account',
            'navItems' => $navItems,
            'h1' => 'Личный кабинет',
            'name' => "$userName",
            'login' => "$userLogin",
            'year' => $year,
            'content' => generateOrdersPage(),
        ]);

    } catch (\Exception $e) {
        die ('ERROR: ' . $e->getMessage());
    }
} else {
    header("Location: /", TRUE, 301);
}