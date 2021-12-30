@extends('layouts.app')

@section('content')
<div class="container py-4">
		<div class="row">
			<div class="col-lg-12">
<h1>Products List</h1>
<table class="table">
	 <thead>
	<tr>
		<td>ID</td>
		<td>Title</td>
		<td>Sku</td>
		<td>Price</td>
		<td>Sale Price</td>
		<td>Image</td>
		<td>Description</td>
		<td>Action</td>
	</tr>
	</thead>
	<tbody>
	@php $i=1; @endphp
	@foreach($products as $product)
	<tr>
		<td>{{$i}}</td>
		<td>{{$product->title}}</td>
		<td>{{$product->sku}}</td>
		<td>{{$product->price}}</td>
		<td>{{$product->sale_price}}</td>
		<td><img style="max-width: 100px;" src="{{ asset('file/'.$product->image) }}"></td>
		<td>{{$product->description}}</td>
		<td><a class="btn btn-primary mx-1" href="edit/{{$product->id}}">Edit</a><a class="btn btn-primary" onclick="return confirm('Are you sure?')" href="deleteproduct/{{$product->id}}">Delete</a></td>

	</tr>
	@php $i++; @endphp
	@endforeach
</tbody>
</table>
</div>
</div>
</div>
<div class="pagination_custom">
<div class="container py-4">
<div class="row">
<div class="col-lg-12">
{{ $products->onEachSide(5)->links() }}
</div>
</div>
</div>
</div>
<style>.pagination_custom svg{width: 20px;}.pagination_custom a{text-decoration: none;}
.pagination_custom span, .pagination_custom a{display: inline-block;}.pagination_custom .shadow-sm{box-shadow: none !important;}</style>

@endsection