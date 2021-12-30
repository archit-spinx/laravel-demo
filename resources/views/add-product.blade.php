@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" >
            <div class="card">
                <div class="card-header">{{ __('Add New Product') }}</div>

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
                	<form action="{{ route('add-product') }}" method="POST" enctype="multipart/form-data">
                		@csrf
                		<div class="form-group mb-2">
						    <label for="prod_name">Product Name</label>
						    <input type="text" class="form-control" id="prod_name" placeholder="" name="title" value="{{ old('title') }}" required>
						</div>
						<div class="form-group mb-2">
						    <label for="prod_price">Price</label>
						    <input type="text" class="form-control" id="prod_price" placeholder="$" name="price" value="{{ old('price') }}" required>
						</div>
						<div class="form-group mb-2">
						    <label for="prod_special_price">Special Price</label>
						    <input type="text" class="form-control" id="prod_special_price" placeholder="$" name="special_price" value="{{ old('special_price') }}" >
						</div>
						<div class="form-group mb-2">
						    <label for="prod_desc">Description</label>
						    <textarea class="form-control" id="prod_desc" rows="4" name="description" value="{{ old('description') }}" required></textarea>
						</div>
						<div class="form-group mb-2">
						    <label for="prod_image">Choose Product Image</label>
						    <input type="file" class="form-control-file" id="prod_image" name="image" value="{{ old('image') }}">
						</div>
						<br>
						<button type="submit" class="btn btn-primary">Add Product</button>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection