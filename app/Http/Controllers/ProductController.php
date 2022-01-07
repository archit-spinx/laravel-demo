<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Routing\UrlGenerator;
use DB;
use Illuminate\Support\Facades\Http;
class ProductController extends Controller
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

    public function getProducts(Request $request)
    {
        $response = Http::get('http://localhost/projects/laravel-demo/public/api/products', []);
        
        /*echo "<pre>";
        print_r( $response); exit;
        
        $productCollection =  Product::paginate(6);
        */

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/projects/laravel-demo/public/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        echo "<pre>";
        print_r( $response); exit;

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
        $product->category_id = $request->get('category_id');

        
        if (isset($_FILES['image']) && !!$request->file('image')) {
            $file = $request->file('image');
            //Move Uploaded File

            $destinationPath = 'uploads';

            $file->move($destinationPath,$file->getClientOriginalName());

            $product->image = $destinationPath.'/'.$file->getClientOriginalName();
        }

        $product->save();  

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