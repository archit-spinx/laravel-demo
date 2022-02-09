@php 
	$role = Auth::user()->role;
@endphp
@extends(($role ==0) ? 'layouts.admin': 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" >
            <div class="card">
                <div class="card-header">{{ (isset($product)) ? __('Edit Product') : __('Add New Product') }}</div>

                <div class="card-body">
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
			        @if(isset($product))
			        <form action="{{ route('edit-product',$product->id) }}" method="POST" enctype="multipart/form-data" id="update_form">
			        @else
                	<form action="{{ route('add-product') }}" method="POST" enctype="multipart/form-data" id="insert_form">
                	@endif
                		@csrf
                		@if(isset($product))
                			<input type="hidden" name="product_id" value="{{ $product->id }}" />
                		@endif
                		<div class="form-group mb-2">
						    <label for="prod_name">Product Name</label>
						    <input type="text" class="form-control" id="prod_name" placeholder="" name="title" value="{{ (isset($product)) ? $product->title : old('title') }}" >
						</div>
						<div class="form-group mb-2">
							<label for="prod_name">Category</label>
							<select class="form-select form-control" name="category_id">
								<option value=""></option>
								@foreach($categoryCollection as $category)
									<?php
										$selected = '';
										if (isset($product) && $category->id == $product->category_id) {
											$selected = 'selected';
										}
									?>
									<option value="{{ __($category->id) }}" <?= $selected ?> >{{ __($category->category_name) }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-2">
						    <label for="prod_price">Price</label>
						    <input type="text" class="form-control" id="prod_price" placeholder="$" name="price" value="{{ (isset($product)) ? $product->price : old('price') }}" >
						</div>
						<div class="form-group mb-2">
						    <label for="prod_special_price">Special Price</label>
						    <input type="text" class="form-control" id="prod_special_price" placeholder="$" name="special_price" value="{{ (isset($product)) ? $product->special_price : old('special_price') }}" >
						</div>
						<div class="form-group mb-2">
						    <label for="prod_desc">Description</label>
						    <textarea class="form-control" id="prod_desc" rows="4" name="description" value="{{ (isset($product)) ? $product->title : old('title') }}" >{{ (isset($product)) ? $product->description : old('description') }}</textarea>
						</div>
						<input type="hidden" name="image" id="image">
						<div class="form-group mb-2">
						    <label for="prod_image">Choose Product Image </label>
						    <input type="file" class="form-control-file" id="prod_image" onchange="encodeImageFileAsURL(this)" name="prod_image">
						    @if(isset($product))
						    <img src="{{ __($product->image) }}" id="product_image" height="100" width="100" >
						    @endif
						</div>
						<br>
						<button type="submit" class="btn btn-primary {{ (isset($product)) ? 'update-product' : 'add-product' }}">{{ (isset($product)) ? 'Update Product' : 'Add Product' }}</button>
						<a href="{{ url('/products') }}" class="btn btn-primary">Back To List</a>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection