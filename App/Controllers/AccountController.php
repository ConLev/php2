<?php

namespace App\Controllers;

use Exception;

class AccountController extends Controller
{
    protected $template = 'userAccount.html';
    protected $userLogin;
    protected $userName;

    public function __construct()
    {
        $this->userLogin = $_SESSION['login']->login;
        $this->userName = $_SESSION['login']->name;
        Controller::__construct();
    }

    public function index()
    {
//        $orders = Account::fetchAll();

        if (isset($this->userLogin) && isset($this->userName)) {
            try {

                return $this->render([
                    'title' => 'user account',
                    'h1' => 'Личный кабинет',
                    'name' => $this->userName,
                    'login' => $this->userLogin,
                    'pages' => unserialize($_COOKIE['story']),
                    'year' => date("Y"),
//                    'content' => generateOrdersPage(),
//                    'content' => $orders,
                ]);

            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }

        } else {
            header("Location: /authentication/", TRUE, 301);
        }
    }
}