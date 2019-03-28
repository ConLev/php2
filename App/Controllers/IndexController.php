<?php

namespace App\Controllers;

class IndexController extends Controller
{
    protected $template = 'index.html';

    public function index()
    {
        try {
            echo $this->render([
                'title' => 'PHP_2',
                'h1' => 'PHP2',
                'year' => date("Y"),
            ]);

        } catch (\Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}