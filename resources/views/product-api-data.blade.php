@extends('layouts.app')

@section('content')
<div class="all-products row">
	@foreach($products as $product)
	    <div class="col-md-4 products" style="margin-bottom: 80px;">
	        <div class="card">
	            <div class="card-header">
	            	<label>{{ __($product['title']) }}</label>

	            	<div style="float: right;" class="actions">
	                    <a class="btn btn-primary" href="/product/{{$product['id']}}">View</a>
	            		<a class="btn btn-primary" href="{{route('edit-product',$product['id'])}}">Edit</a>
	            		<a class="btn btn-danger product-delete" href="javascript:;" data-id="{{ $product['id'] }}">Delete</a>
	            	</div>
	            </div>
	            <div class="card-body row">
	            	<div class="col-md-12 text-center">
	            		<img src="{{ $product['image'] }}" width="250" height="250" class="rounded mx-auto d-block"/>
	            	</div>
	            	<div class="col-md-12">
	            		@if($product['special_price'])
	            			<del>
	            		@endif
	                	<label><b>Price:</b>  </label>$<span>{{ __($product['price']) }}</span><br>
	                	@if($product['special_price'])
	            			</del>
	            			<label><b>Sale Price:</b> </label>$<span>{{ __($product['special_price']) }}</span>
	            			<br>
	            		@endif
	                	<p><b>Description:</b>  {{ __($product['description']) }}</p>
	            	</div>
	            </div>
	        </div>
	    </div><br>
	@endforeach
</div>
@endsection