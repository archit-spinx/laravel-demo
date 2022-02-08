<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Rating;
use Illuminate\Routing\UrlGenerator;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Client\Response;

class AdminProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $url;

    public function __construct(
        UrlGenerator $url
    )
    {
        $this->url = $url;
        $this->middleware('auth');
    }

    function External() {
		
		
    }

    public function getProducts(Request $request)
    {
       
        if(isset($_GET['page'])){
            $page = '?page='.$_GET['page'];
        }else{
            $page = '';
        }
        $data = Http::get(env("API_URL").'/api/products'.$page);         
        $categoryCollection = ProductCategory::all();
        $products = $data->json();
        return view('admin.adminproducts',["productCollection" => $products])->with("categoryCollection",$categoryCollection);
    }

    

    
}