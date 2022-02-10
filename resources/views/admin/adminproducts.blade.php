@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row">		
		<div class="col-md-12">
			<div class="justify-content-center">
		    	@if(session()->has('message'))
					<div class="alert alert-success">
					    {{ session()->get('message') }}
					</div>
				@endif
		    	@if(count($productCollection) > 0)
		    		<div class="">

					<div class="table_pages">
						<table>
						<tr>
							<th style="width:5%"> ID</th>
							<th style="width:15%">Title</th>
							<th style="width:10%">Image</th>
							<th style="width:10%">Price</th>
							<th style="width:10%">Sale Price</th>
							<th style="width:25%">Description</th>
							<th style="width:5%">View</th>
							<th style="width:5%">Edit</th>
							<th style="width:5%">Delete</th>

						</tr>
				    	@foreach($productCollection as $product)
				        <tr>
							<td >								
								<label>{{ __($product['id']) }}</label>
							</td>
							<td >
							
								<label>{{ __($product['title']) }}</label>
							</td>
				                	
							<td >
								<div class="col-md-12 text-center">
									<img src="{{ $product['image'] }}" width="50" height="50" class="rounded mx-auto d-block"/>
								</div>
							</td>	
							<td>		
								$<span>{{ __($product['price']) }}</span>								
							</td>
							<td>
							@if($product['special_price'] > 0)
								$<span>{{ __($product['special_price']) }}
							@endif
							</td>
							<td ><p> {{ __($product['description']) }}</p></td>
								
							<td ><a class="btn btn-primary" href="/product/{{$product['id']}}">View</a></td>
							<td ><a class="btn btn-primary" href="{{route('edit-product',$product['id'])}}">Edit</a></td>
							<td ><a class="btn btn-danger" onclick="return confirm('Are you sure, do you want delete this product?')" href="{{route('products').'/remove/'.$product['id']}}">Delete</a></td>
								
						</tr>
				        @endforeach
						</table>
						
						<div id="pagination-products" class="pagination-section">
							<input type="hidden" id="totalcount" name="totalcount" value="{{$productCollection->total()}}">
							<span class="pull-right">{{$productCollection->links()}}</span>
						</div>

						{{-- @if(count($products['meta']) > 0)						
						<div class="d-flex justify-content-center">
							<ul class="list-inline">
							@foreach($products['meta']['links'] as $productpag)
								@php
									$paelen = array();							
									if($productpag['url']){
									$paelen = explode("?page=",$productpag['url']) ;							
									}
								@endphp
								@if(!empty($paelen[1]))
									<li class="list-inline-item">
									<a href="?page={!! $paelen[1] !!}"> {!! $productpag['label'] !!}</a>
									</li>
								@endif
							@endforeach
							</ul>	
						</div>
						@endif --}}					
						
						</div>
					</div>
			    @else
			    	<div class="col-md-12">
			    		<div class="card">
			                <div class="card-header">{{ __('Product\'s were not found!') }}</div>

			                <div class="card-body">
			                	<div class="col-md-12 actions">
									<div class="add_new_product">
										<a href="{{ route('add-product') }}">
											<label> {{ __('Add New Product\'s to continue.') }}  </label>
										</a>
									</div>
								</div>
			                </div>
			            </div>
			    	</div>
			    @endif
		    </div>
		</div>
	</div>
</div>
<style>
	.table_pages table {
  empty-cells: show;
}
.w-5{
		display: none;
	}	
</style>
@endsection