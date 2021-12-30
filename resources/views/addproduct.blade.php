@extends('layouts.app')

@section('content')
<div class="container py-4">
<div class="row">
<div class="col-lg-12">
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form class="py-4" action="{{ route('create.product') }}" method="POST" enctype="multipart/form-data">
	@csrf
  <div class="mb-3">
    <label for="name">Product Title</label>
    <input type="text" class="form-control" name="ptitle" id="name" placeholder="Enter Title" value="{{ old('ptitle') }}">
  </div>
    <div class="mb-3">
    <label for="sku">SKU</label>
    <input type="text" class="form-control" name="sku" id="sku" placeholder="Enter SKU" value="{{ old('sku') }}">
  </div>
   <div class="mb-3">
    <label for="exampleInputEmail1">Price</label>
    <input type="text" class="form-control" name="price" id="exampleInputEmail1"  placeholder="Enter price" value="{{ old('price') }}">
  </div>
   <div class="mb-3">
    <label for="exampleInputEmail2">Sale Price</label>
    <input type="text" class="form-control" name="sale_price" id="exampleInputEmail2"  placeholder="Enter sale price" value="{{ old('sale_price') }}">
  </div>
   <div class="mb-3">
    <label for="role">Image</label>
    <input type="file" class="form-control" name="image" id="role" value="{{ old('image') }}">
  </div>
   <div class="mb-3">
    <label for="msg">Description</label>
    <textarea name="description" placeholder="Description" id="msg" class="form-control">{{ old('description') }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
</div>
</div>
</div>
@endsection
