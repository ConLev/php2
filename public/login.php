<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

require_once '../config/config.php';

try {
    $template = TemplateEngine::getInstance()->twig->load('login.html');
    $year = date("Y");

    echo $template->render([
        'title' => 'PHP_2',
        'year' => $year,
    ]);

} catch (\Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}

//Вариант без AJAX
//Полуаем логин пароль
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
//var_dump(md5($password));
//die;

//Если логин и пароль переданы пытаемся авторизоваться
if ($login && $password) {
    //преобразуем пароль в хэш
    $password = md5($password);
    //получаем пользователя из базы
    $sql = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
    $user = DB::getInstance()->fetchOne($sql);

    //если пользователь найден. Записываем его в сессию
    if ($user) {
        $_SESSION['login'] = $user;
    } else {
        echo 'Неверная пара логин-пароль';
    }
}