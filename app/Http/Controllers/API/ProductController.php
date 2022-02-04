<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\ProductCategory;
use Validator;
use App\Http\Resources\ProductResource as ProductResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
   
class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate();
    
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'title'=>'required',  
            'price'=>'required|gt:0|numeric',  
            'special_price' => 'lt:price|numeric',
            'description'=>'required',
            'category_id' => 'numeric',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = new Product();
        $product->title = $input['title'];
        $product->price = $input['price'];
        $product->special_price = $input['special_price'];
        $product->description = $input['description'];
        $product->image = $input['image'];
        $product->category_id = $input['category_id'];
        $product->save();
   
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id)
    {
      
        $product = Product::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'title'=>'required',  
            'price'=>'required|gt:0|numeric',  
            'special_price' => 'lt:price|numeric',
            'description'=>'required',
            'category_id' => 'numeric',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $product->title = $input['title'];
        $product->price = $input['price'];
        $product->special_price = $input['special_price'];
        $product->description = $input['description'];
        if (!is_null($input['image'])) {
            $product->image = $input['image'];
        }
        $product->category_id = $input['category_id'];
        $product->update();
   
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Product $product)
    {

        $product = Product::find($id); 
        $product->status = 0; 
        $product->update();      
        //$product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }

    public function searchName($name = null) {
        if (is_null($name)) {
            $products = Product::where('title', 'LIKE', "%$name%")->get();
            //return json_decode($products);
            return view('products-data',["productCollection" => $products]);
        } else {
            $productCollection = Product::all();
            return view('products-data',["productCollection" => $productCollection]);
        }
    }

    public function filterPrice(Request $request) {

        $price = $request->price;
        $category = $request->category;
        if($category){
            $productCollect = Product::query()->where('category_id','=',$category)->get();
            return view('products-data',["productCollection" => $productCollection]);
        } else {
            $productCollection = Product::all();
            return view('products-data',["productCollection" => $productCollection]);
        }
        if ($price) {
            if($category){
                $productCollection = Product::query()->where('category_id','=',$category)->orderBy('price', $price)->get();
                return view('products-data',["productCollection" => $productCollection]);
            } else {
                $productCollection = Product::query()->orderBy('price', $price)->get();
                return view('products-data',["productCollection" => $productCollection]);
            }
        } else {
            $productCollection = Product::all();
            return view('products-data',["productCollection" => $productCollection]);
        }
}

}