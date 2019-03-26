<?php

namespace App\Controllers;

use App\Classes\Templater;
use App\Models\Products;

class ProductsController extends Controller
{
    protected $template = 'productsPage.html';

    public function index($data = [])
    {
        $products = Products::fetchAll();

        echo $this->render(['products' => $products]);
    }
}