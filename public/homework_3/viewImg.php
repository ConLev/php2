<?php

namespace engine;

use engine\Classes\DB;
use engine\Classes\TemplateEngine;

require_once '../../config/config.php';

if (!isset($_GET['id'])) {
    echo 'id not found';
    exit();
}

$id = (int)$_GET['id'];

try {
    DB::getInstance()->exec("UPDATE `images` SET `views`=`views`+ 1 WHERE `images`.`id`='$id'");
    $template = TemplateEngine::getInstance()->twig->load('viewImg.html');
    $img = DB::getInstance()->fetchOne("SELECT * FROM `images` WHERE id='$id'");

    echo $template->render([
        'title' => 'Галерея',
        'img' => $img,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}