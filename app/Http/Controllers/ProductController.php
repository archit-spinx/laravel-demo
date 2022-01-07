<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Rating;
use Illuminate\Routing\UrlGenerator;
use DB;
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
        $productCollection =  Product::paginate(6);
        $categoryCollection = ProductCategory::all();
        if ($request->ajax()) {
            if(!!$request->search){
                $productCollection = DB::table('products')->where('title','LIKE','%'.$request->search."%")->get();
                $view = view('products-data',compact('productCollection'))->render();
            } elseif (!!$request->filter) {
                $price = $request->price;
                $category = $request->category;
                if(!!$category){
                    $productCollection = Product::query()->where('category_id','=',$category)->get();
                }
                if (!!$price) {
                    if(!!$category){
                        $productCollection = Product::query()->where('category_id','=',$category)->orderBy('price', $price)->get();
                    } else {
                        $productCollection = Product::query()->orderBy('price', $price)->get();
                    }
                } 
                $view = view('products-data',compact('productCollection'))->render();
            } else {
                $view = view('products-data',compact('productCollection'))->render();
            }

            return response()->json(['html'=>$view]);
        }
        return view('products')->with("productCollection",$productCollection)->with("categoryCollection",$categoryCollection);
    }

    public function getProductCategories(Request $request)
    {
        $categoryCollection =  ProductCategory::all();
        if ($request->route()->getName() == "add-product") {
            return view('add-product')->with("categoryCollection",$categoryCollection);
        }
        return view('product-categories')->with("categoryCollection",$categoryCollection);
    }

    public function create(Request $request)
    {
        $this->validateProductRequest($request);
  
        $product = new Product;  
        $product->title =  $request->get('title');  
        $product->category_id = $request->get('category'); 
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

    public function createCategory(Request $request)
    {
        $request->validate([  
            'category_name'=>'required|unique:product_categories,category_name',
        ]);
        $ProductCategory = new ProductCategory;  
        $ProductCategory->category_name =  $request->get('category_name');  
        $ProductCategory->category_description = $request->get('category_description');  
        $ProductCategory->save();
        return redirect(route('product.categories'))->with('message', 'New Product Category Added Successfully');
    }

    public function edit($id)  
    {  
        $product= Product::find($id); 
        $category =  ProductCategory::all(); 
        return view('add-product')->with('product',$product)->with('categoryCollection',$category);  
    } 

    public function editCategory($id)  
    {  
        $category= ProductCategory::find($id);  
        return view('add-product-category', compact('category'));  
    }

    public function destroy($id)  
    {  
        $product = Product::find($id);  
        $product->delete();  
        return redirect()->back()->with('message', 'Product Deleted Successfully');
    }  

    public function destroyCategory($id)  
    {  
        $category = ProductCategory::find($id);  
        $category->delete();  
        return redirect()->back()->with('message', 'Product Category Deleted Successfully');
    }

    public function update(Request $request, $id)  
    {  
        $request->validate([  
            'title'=>'required',  
            'category' => 'required',
            'price'=>'required|gt:0|numeric',  
            'special_price' => 'lt:price|numeric',
            'description'=>'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $product = Product::find($id);  
        $product->title =  $request->get('title');  
        $product->category_id = $request->get('category'); 
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

    public function updateCategory(Request $request, $id)  
    {  
        $request->validate([  
            'category_name'=>'required',
        ]);

        $category = ProductCategory::find($id);  
        $category->category_name =  $request->get('category_name');  
        $category->category_description = $request->get('category_description');  
        $category->save();  

        return redirect()->back()->with('message', 'Product Category Updated Successfully');
    }

    public function validateProductRequest($request)
    {
        return $request->validate([  
            'title'=>'required|unique:products,title',  
            'category' => 'required',
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
      $current_user_id = auth()->user()->id;
      $avgStar = Rating::where('product_id',$id)->get();
      $is_rated = Rating::where('product_id',$id)->where('rating_user', '=', $current_user_id)->get();
      if(count($is_rated) > 0){
        $rated = 1;
      } else {
        $rated = 0;
      }
      $rating = 0;
      $rating = $avgStar->avg('rating');
      return view('view-product', compact('product','rating','rated')); 
    }
}