<?php

namespace App\Http\Controllers;

use App\Models\Product;  

abstract class Controller
{
    function __construct()
    {
    }

    function getProducts()
    {
        $prod = Product::all();
        return response()->json($prod);
    }
}
