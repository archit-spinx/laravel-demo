<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
}