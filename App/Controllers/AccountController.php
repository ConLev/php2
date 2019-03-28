<?php

namespace App\Controllers;

class AccountController extends Controller
{
    protected $template = 'userAccount.html';
    protected $userLogin;
    protected $userName;

    public function __construct()
    {
        $_COOKIE['page'] = isset($_COOKIE['page']) ? unserialize($_COOKIE['page']) : [];
        date_default_timezone_set("Europe/Moscow");
        array_unshift($_COOKIE['page'], date('H:i:s') . ' - ' . $_SERVER['HTTP_REFERER']);
        $_COOKIE['page'] = array_slice($_COOKIE['page'], 0, 5);
        setcookie('page', serialize($_COOKIE['page']));

        $this->userLogin = $_SESSION['login']['login'];
        $this->userName = $_SESSION['login']['name'];
        Controller::__construct();
    }

    public function index()
    {
//        $orders = Account::fetchAll();

        if (isset($this->userLogin) && isset($this->userName)) {
            try {

                echo $this->render([
                    'title' => 'user account',
                    'h1' => 'Личный кабинет',
                    'name' => "$this->userName",
                    'login' => "$this->userLogin",
                    'pages' => $_COOKIE['page'],
                    'year' => date("Y"),
//                    'content' => generateOrdersPage(),
//                    'content' => $orders,
                ]);

            } catch (\Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }

        } else {
            header("Location: /authentication/login/", TRUE, 301);
        }
    }
}