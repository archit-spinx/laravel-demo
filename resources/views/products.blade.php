@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row loaderm">
		<div class="col-md-2">
			<form name="filter">
				@csrf
				<div class="form-group mb-4">
					<label>{{ __('Search: ') }}</label>
					<input type="text" class="form-controller" id="side-search" name="search" placeholder="Search Products. . ."></input>
					<p style="font-size: 12px;">Minimum 3 characters required</p>
				</div>
				<div class="form-group mb-4">
					<label>{{ __('Filter By Price: ') }}</label>
					<select class="form-select" name="price" data-value="price">
						<option value="">Select Option</option>
						<option value="ASC">Low  To High</option>
						<option value="DESC">High To Low</option>
					</select>
				</div>
				<div class="form-group mb-4">
					<label>{{ __('Filter By Category: ') }}</label>
					<select class="form-select" name="category" data-value="category_id">
						<option value="">Select Option</option>
						@if($categoryCollection)
							@foreach($categoryCollection as $category)
								<option value="{{ $category->id }}" >{{ $category->category_name }}</option>
							@endforeach
						@endif
					</select>
				</div>
				<input type="hidden" name="page" id="hidden_page" value="1" />
			</form>
		</div>
		<div class="col-md-10">
			<div class="justify-content-center">
		    	@if(session()->has('message'))
					<div class="alert alert-success">
					    {{ session()->get('message') }}
					</div>
				@endif
			</div>
		    	@if(count($productCollection) > 0)
		    		<div class="all-products row">
				    	@foreach($productCollection as $product)
				        <div class="col-md-4 products" style="margin-bottom: 80px;">
				            <div class="card">
				                <div class="card-header">
				                	<label>{{ __($product['title']) }}</label>

				                	<div style="float: right;">
				                		<a class="btn btn-primary" href="product/{{$product['id']}}">View</a>
				                		<a class="btn btn-primary" href="{{route('edit-product',$product['id'])}}">Edit</a>
				                		<a class="btn btn-danger" onclick="return confirm('Are you sure, do you want delete this product?')" href="{{route('products').'/remove/'.$product['id']}}">Delete</a>
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
				        </div>
				        @endforeach
						
						<div id="pagination" class="pagination-section">
							<input type="hidden" id="totalcount" name="totalcount" value="{{$productCollection->total()}}">
							<span class="pull-right">{{$productCollection->links()}}</span>
						</div>
						{{-- @if(count($productCollection['meta']) > 0)				
						<div class="d-flex justify-content-center">
							<ul class="list-inline">
							@foreach($productCollection['meta']['links'] as $productpag)
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
						@endif					 --}}
						
				        <!-- <div class="ajax-load text-center" style="display:none">
							<p>Loading More Products. . .</p>
						</div> -->
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
<!-- <input type="hidden" name="ajaxload" value="0" /> -->
@endsection

<style>
	.w-5{
		display: none;
	}	
</style>