<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Routing\UrlGenerator;
use DB;
use Response;
use Elasticsearch\ClientBuilder;
class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $url;

    protected $clientBuilder;

    public function __construct(
        UrlGenerator $url,
        ClientBuilder $clientBuilder
    )
    {
        $this->url = $url;
        $this->clientBuilder = $clientBuilder->create()->build();
        $this->middleware('auth');
    }

    public function getProducts(Request $request)
    {
        $productCollection =  Product::paginate(6);

        if ($request->ajax()) {
            if(!!$request->search){
                $productCollection = DB::table('products')->where('title','LIKE','%'.$request->search."%")->get();
                $view = view('products-data',compact('productCollection'))->render();
            } else {
                $view = view('products-data',compact('productCollection'))->render();
            }

            return response()->json(['html'=>$view]);
        }
        return view('products')->with("productCollection",$productCollection);
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);
  
        $product = new Product;  
        $product->title =  $request->get('title');  
        $product->price = $request->get('price');  
        $product->description = $request->get('description');  
        $product->special_price = $request->get('special_price');  

        if (isset($_FILES['image']) && !!$request->file('image')) {
            $file = $request->file('image');
            //Move Uploaded File

            $destinationPath = 'uploads';

            $file->move($destinationPath,$file->getClientOriginalName());

            $product->image = $destinationPath.'/'.$file->getClientOriginalName();
        }
        $product->save();  
        $this->setESIndexing($product->toArray());
        return redirect(route('products'))->with('message', 'New Product Added Successfully');
    }

    public function edit($id)  
    {  
        $product= Product::find($id);  
        return view('edit-product', compact('product'));  
    } 

    public function destroy($id)  
    {  
        $product = Product::find($id);  
        $product->delete();  
        return redirect()->back()->with('message', 'Product Deleted Successfully');
    }  

    public function update(Request $request, $id)  
    {  
        $request->validate([  
            'title'=>'required',  
            'price'=>'required|gt:0|numeric',  
            'special_price' => 'lt:price|numeric',
            'description'=>'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $product = Product::find($id);  
        $product->title =  $request->get('title');  
        $product->price = $request->get('price');  
        $product->description = $request->get('description');  
        $product->special_price = $request->get('special_price');

        if (isset($_FILES['image']) && !!$request->file('image')) {
            $file = $request->file('image');
            //Move Uploaded File

            $destinationPath = 'uploads';

            $file->move($destinationPath,$file->getClientOriginalName());

            $product->image = $destinationPath.'/'.$file->getClientOriginalName();
        }
        $product->save();  
        $del = $this->deleteESIndexing();
        if ($del == true) {
            $getAllProducts = Product::all(); 
            $this->setESIndexing($getAllProducts->toArray());
        }
        return redirect()->back()->with('message', 'Product Updated Successfully');
    }  

    public function validateRequest($request)
    {
        return $request->validate([  
            'title'=>'required|unique:products,title',  
            'price'=>'required|gt:0|numeric',   
            'special_price' => 'lt:price|numeric',
            'description'=>'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);
    }

    public function search(Request $req){
        $posts = Product::query()
            ->where('title', 'like', "%{$req->q}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('search', [
            'posts' => $posts,
        ]);
    }

    public function productElasticSearch(Request $request)
    {   
        $params['index'] = 'products_es_index';               
        $params['type'] = 'product_es_type';                             
        $params['body']['query']['match']['title'] = $request->title; 
        $products = $this->clientBuilder->search($params)['hits']['hits']; 
        return view('product-search', compact('products'));   
    }

    public function setESIndexing($products)
    {
        $params = array();
        $params['index'] = 'products_es_index';
        $params['type']  = 'product_es_type';
        foreach ($products as $key => $product) {
            $params['body']  = $product;
            $result = $this->clientBuilder->index($params);
        }
    }

    public function deleteESIndexing()
    {
        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,'http://localhost:9200/products_es_index');
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'DELETE'); 
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        if (empty($buffer)){
            return false;
        }
        return true;
    }

    public function singleProduct($id){
          $product= Product::find($id);
          $avgStar = Rating::where('product_id',$id)->get();
          

          $rating = 0;
          if(!$avgStar->isEmpty()){
              foreach ($avgStar as $rating) {
                  $avgStar['ratings'] = $rating->avg('rating');
              }
              $rating = $avgStar['ratings'];
          } 
          
            

          //return $avgrate;
          return view('view-product', compact('product','rating')); 
    }
    
   
}