<?php

namespace App;

use App\Classes\TemplateEngine;

require_once __DIR__ . '/../config/config.php';

try {
    $navItems = getNav();
    $template = TemplateEngine::getInstance()->twig->load('contacts.html');
    $year = date("Y");

    echo $template->render([
        'title' => 'Contacts',
        'navItems' => $navItems,
        'h1' => 'Contacts',
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}