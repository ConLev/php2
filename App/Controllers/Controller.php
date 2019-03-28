<?php

namespace App\Controllers;

use App\Classes\Templater;

abstract class Controller
{
    protected $template;
    protected $twig;
    protected $userName;
    protected $userLogin;

    public function __construct()
    {
        $this->twig = Templater::getInstance()->twig;
    }

    protected function render($params = [], $template = null)
    {
        if (!$template) {
            $template = $this->template;
        }
        $twig = $this->twig->load($template);
        return $twig->render($params);
    }
}