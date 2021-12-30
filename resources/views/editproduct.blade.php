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
<form class="py-4" action="" method="POST" enctype="multipart/form-data">
	@csrf
    <input type="hidden" name="id" value="{{$productdata->id}}">
  <div class="mb-3">
    <label for="name">Product Title</label>
    <input type="text" class="form-control" name="ptitle" id="name" placeholder="Enter Title" value="{{$productdata->title}}">
  </div>
    <div class="mb-3">
    <label for="sku">SKU</label>
    <input type="text" class="form-control" name="sku" id="sku" placeholder="Enter SKU" value="{{ $productdata->sku }}">
  </div>
   <div class="mb-3">
    <label for="exampleInputEmail1">Price</label>
    <input type="text" class="form-control" name="price" id="exampleInputEmail1"  placeholder="Enter price" value="{{ $productdata->price }}">
  </div>
   <div class="mb-3">
    <label for="exampleInputEmail2">Sale Price</label>
    <input type="text" class="form-control" name="sale_price" id="exampleInputEmail2"  placeholder="Enter sale price" value="{{ $productdata->sale_price }}">
  </div>
   <div class="mb-3">
    <label for="role">Image</label>
    <input type="file" class="form-control" name="image" id="role" value="{{ asset('file/'.$productdata->image) }}">
    <img style="max-width: 100px; margin-top: 20px;" src="{{ asset('file/'.$productdata->image) }}">
  </div>
   <div class="mb-3">
    <label for="msg">Description</label>
    <textarea name="description" placeholder="Description" id="msg" class="form-control">{{ $productdata->description }}</textarea>
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
