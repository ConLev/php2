<?php

namespace App\Controllers;

use App\Models\OrdersProducts;
use Exception;

class AccountController extends Controller
{
    protected $template = 'userAccount.html';
    protected $userLogin;
    protected $userName;
    protected $id;
    protected $admin;

    public function __construct()
    {
        $this->userLogin = $_SESSION['login']->login;
        $this->userName = $_SESSION['login']->name;
        $this->id = $_SESSION['login']->id;
        Controller::__construct();
    }

    public function index()
    {
        if (isset($this->userLogin) && isset($this->userName)) {
            try {
                $orders = OrdersProducts::getWithProducts($this->admin, $this->id);
//                die;
                return $this->render([
                    'title' => 'user account',
                    'h1' => 'Личный кабинет',
                    'name' => $this->userName,
                    'login' => $this->userLogin,
                    'admin' => $this->admin,
                    'pages' => unserialize($_COOKIE['story']),
                    'orders' => $orders,
                    'year' => date("Y"),
                ]);

            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }

        } else {
            header("Location: /authentication/", TRUE, 301);
        }
    }
}