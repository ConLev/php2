<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../../config/config.php';

//$twig = TemplateEngine::getInstance()->twig;
//$db = DB::getInstance();

$navItems = getNav();
try {
    $template = TemplateEngine::getInstance()->twig->load('index.html');
    $images = DB::getInstance()->fetchAll("SELECT * FROM `images` ORDER BY `images`.`views` DESC");
    $year = date("Y");

    echo $template->render([
        'title' => 'lesson_3',
        'navItems' => $navItems,
        'h1' => 'lesson_3',
        'images' => $images,
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}