<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
  
    function validateproduct(Request $req){
        $product = new Product;
        $req->validate([
            'ptitle' => 'required|max:255',
            'sku' => 'required|max:255|unique:products,sku,',
            'price'=> 'required',
            'sale_price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sale_price'=> 'lt:price',
        ],
         [
                'ptitle.required' => 'Product Title is required',
                'sku.required' => 'SKU is required',
                'sku.unique' => 'SKU is already exists',
                'price.required' => 'Price is required',
                'sale_price.required' => 'Sale price is required',
                'description.required' => 'Description is required',

        ]);


        $fileName = time().'.'.$req->image->extension();  
        $req->image->move(public_path('file'), $fileName);


        $product->title = $req->ptitle;
        $product->sku = $req->sku;
        $product->price = $req->price;
        $product->sale_price = $req->sale_price;
        $product->description = $req->description;
        $product->image = $fileName;
        $product->save();

        return redirect()->back()->with('message', 'Product added successfully.');

    }

    function showProducts(){
         $data = DB::table('products')->paginate(5);
        return view('products',['products'=>$data]);
    }

    function deleteProduct($id){
        $data = Product::find($id);
        $data->delete();
       return redirect('products');
    }

    function editproduct($id){
        $data = Product::find($id);
        return view('editproduct',['productdata'=>$data]);

    }

    function updateProduct(Request $req){
            
         $req->validate([   
            'ptitle' => 'required|max:255',
            'sku' => 'required|max:255|unique:products,sku,'.$req->id,
            'price'=> 'required',
            'sale_price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sale_price'=> 'lt:price',
        ],
         [
                'ptitle.required' => 'Product Title is required',
                'sku.required' => 'SKU is required',
                'sku.unique' => 'SKU is already exists',
                'price.required' => 'Price is required',
                'sale_price.required' => 'Sale price is required',
                'description.required' => 'Description is required',

        ]);

        $data = Product::find($req->id);

        $fileName = time().'.'.$req->image->extension();  
        $req->image->move(public_path('file'), $fileName);

        $data->title = $req->ptitle;
        $data->sku = $req->sku;
        $data->price = $req->price;
        $data->sale_price = $req->sale_price;
        $data->description = $req->description;
        $data->image = $fileName;

        $data->update();

        return redirect()->back()->with('message', 'Product updated successfully.');
    }
}
