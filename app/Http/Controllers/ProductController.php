<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\UrlGenerator;

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

    public function getProducts()
    {
        $productCollection =  Product::paginate(6);
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

    public function ajaxProducts(Request $request)
    {
        $products = Product::paginate(6);

        if ($request->ajax()) {
            $html = '';

            foreach ($products as $product) {


                $html.= '<div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <label>{{ __($product->title) }}</label>

                        <div style="float: right;">
                            <a class="btn btn-primary" href="'.route('edit-product',$product->id).'">Edit</a>
                            <a class="btn btn-danger" href="'.route('products').'/remove/'.$product->id.'">Delete</a>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-12 text-center">
                            <img src'. __( URL::asset($product->image) ) .'" width="250" height="250" class="rounded mx-auto d-block"/>
                        </div>
                        <div class="col-md-12">
                            @if($product->special_price)
                                <del>
                            @endif
                            <label><b>Price:</b>  </label><spa'. __($product->price) .'</span>$<br>
                            @if($product->special_price)
                                </del>
                                <label><b>Sale Price:</b> </label><spa'. __($product->special_price) .'</span>$
                                <br>
                            @endif
                            <p><b>Description:</b>'. __($product->description) .'</p>
                        </div>
                    </div>
                </div>
            </div><br>';
            }

            return $html;
        }

        return view('products')->with("productCollection",$products);;
    }
}