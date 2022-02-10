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
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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
       
        /* if(isset($_GET['page'])){
            $page = '?page='.$_GET['page'];
        }else{
            $page = '';
        }
        $data = Http::get(env("API_URL").'/api/adminproducts'.$page);    
        $products = $data->json();        
        return view('admin.adminproducts',compact(['products'])); */

        $categoryCollection = ProductCategory::all();
        $data = Http::get(env("API_URL").'/api/products');
        $product = $data->json();        
        $productCollection = $this->arrayPaginator($product);
        return view('admin.adminproducts',["productCollection" => $productCollection])->with("categoryCollection",$categoryCollection);
    }

    public function arrayPaginator($data){
        $page = request()->get('page', 1);
        $perPage =  request()->get('perPage', 6);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($data, $offset, $perPage, true), count($data), $perPage, $page,
        ['path' => Paginator::resolveCurrentPath()]);
    }

    
}