@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" onclick="">
            <div class="card">
                <div class="card-header">{{ __('Edit Product') }}</div>

                <div class="card-body">
                	 @if ($message = Session::get('success'))
				        <div class="alert alert-success alert-block">
				                <strong>{{ $message }}</strong>
				        </div>
				    @endif
				  
			        @if (count($errors) > 0)
			            <div class="alert alert-danger">
			                <strong>Whoops!</strong> There were some problems with your input.
			                <ul>
			                    @foreach ($errors->all() as $error)
			                        <li>{{ $error }}</li>
			                    @endforeach
			                </ul>
			            </div>
			        @endif
			        @if(session()->has('message'))
						<div class="alert alert-success">
						    {{ session()->get('message') }}
						</div>
					@endif
                	<form action="{{ route('edit-product',$product->id) }}" method="POST" enctype="multipart/form-data">
                		@csrf
                		<div class="form-group mb-2">
						    <label for="prod_name">Product Name</label>
						    <input type="text" class="form-control" id="prod_name" placeholder="" name="title" value="{{ $product->title }}" required>
						</div>
						<div class="form-group mb-2">
						    <label for="prod_price">Price</label>
						    <input type="text" class="form-control" id="prod_price" placeholder="$" name="price" value="{{ $product->price }}" required>
						</div>
						<div class="form-group mb-2">
						    <label for="prod_special_price">Special Price</label>
						    <input type="text" class="form-control" id="prod_special_price" placeholder="$" name="special_price" value="{{ $product->special_price }}">
						</div>
						<div class="form-group mb-2">
						    <label for="prod_desc">Description</label>
						    <textarea class="form-control" id="prod_desc" rows="4" name="description" required>{{ $product->description }}</textarea>
						</div>
						<div class="form-group mb-2">
							@if(!route('edit-product',$product->id))
							    <label for="prod_image">
							    		{{ __('Choose Product Image') }}
							    </label>
							@endif
						    <input type="file" id="prod_image" name="image"
						     value="{{ __(URL::asset($product->image)) }}" />
						    <img src="{{ __(URL::asset( $product->image)) }}" height="100" width="100">
						</div>
						<br>
						<button type="submit" class="btn btn-primary">Update Product</button>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection