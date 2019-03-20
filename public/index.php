<?php

namespace engine;

use engine\Classes\DB;
use engine\Classes\TemplateEngine;

require_once '../config/config.php';

//$twig = TemplateEngine::getInstance()->twig;
//$db = DB::getInstance();

try {
    $template = TemplateEngine::getInstance()->twig->load('index.tpl');
    $data = DB::getInstance()->fetchAll("SELECT * FROM `reviews`");

    echo $template->render([
        'name' => 'Clark Kent',
        'username' => 'ckent',
        'password' => 'krypt0n1te',
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}