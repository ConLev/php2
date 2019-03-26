<?php

namespace App\Controllers;

class IndexController extends Controller
{
    protected $template = 'index.html';

    public function index($data = [])
    {
        echo $this->render();
    }
}