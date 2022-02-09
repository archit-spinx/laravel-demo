@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" >
            <div class="card">
                <div class="card-header">
                	<a href="{{ route('product.categories') }}" class="btn btn-secondary"> Go Back </a>
                	<span>{{ (isset($category)) ? __('Edit Category') : __('Add New Category') }}</span>
                </div>

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
			        @if(isset($category))
			        <form action="{{ route('edit.product.category',$category->id) }}" method="POST" enctype="multipart/form-data">
			        @else
                	<form action="{{ route('add.product.category') }}" method="POST" enctype="multipart/form-data">
                	@endif
                		@csrf
                		<div class="form-group mb-2">
						    <label for="cat_name">Category Name</label>
						    <input type="text" class="form-control" id="cat_name" placeholder="" name="category_name" value="{{ (isset($category)) ? $category->category_name : old('category_name') }}" required>
						</div>
						<div class="form-group mb-2">
						    <label for="cat_desc">Description</label>
						    <textarea class="form-control" id="cat_desc" rows="4" name="category_description" value="{{ (isset($category)) ? $category->category_description : old('category_description') }}">{{ (isset($category)) ? $category->category_description : old('category_description') }}</textarea>
						</div>
						<button type="submit" class="btn btn-primary">{{ (isset($category)) ? 'Update Category' : 'Add Category' }}</button>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection