<?php

namespace App\Controllers;

use App\Models\Authentication;

class AuthenticationController extends Controller
{
    protected $template = 'login.html';

    public function login()
    {
        try {
            echo $this->render([
                'title' => 'PHP_2',
                'year' => date("Y"),
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
            Authentication::$login = $login;
            Authentication::$password = $password;
            $user = Authentication::fetchOne();

            //если пользователь найден. Записываем его в сессию
            if ($user) {
                $_SESSION['login'] = $user;
            } else {
                echo 'Неверная пара логин-пароль';
            }
        }
    }

    public function logout()
    {
        try {
            //Убиваем сессию и тем самым разлогиниваем пользователя
            session_destroy();
            header("Location: /authentication/login/", TRUE, 301);

        } catch (\Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}