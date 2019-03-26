<?php

namespace App;

use App\Classes\DB;

require_once '../../config/config.php';

$id = (int)$_GET['id'] ?? '';

try {
    $result = DB::getInstance()->exec("DELETE FROM `products` WHERE `products`.`id` = :id", ['id' => $id]);
    if ($result) {
        header("Location: /products/readProducts.php", TRUE, 301);
    }

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}