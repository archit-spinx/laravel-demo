<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

define('GET_PRODUCTS_API', 'http://spinx.local/laravel-demo/public/api/products');

define('DELETE_PRODUCT_API','http://spinx.local/laravel-demo/public/api/product/delete/');

class ProductAPIController extends Controller
{

    public function index()
    {
        $products = $this->getProducts()->json()['data'];
        return view('product-api-data')->with("products",$products);
    }

    public function getProducts()
    {
        $response = Http::get(GET_PRODUCTS_API);
        return $response;
    }
}
