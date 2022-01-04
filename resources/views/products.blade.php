@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    	<div class="form-group mb-4">
    		<label>{{ __('Search: ') }}</label>
			<input type="text" class="form-controller" id="search" name="search" placeholder="Search Products. . ."></input>
		</div>
    	@if(session()->has('message'))
			<div class="alert alert-success">
			    {{ session()->get('message') }}
			</div>
		@endif
    	@if(count($productCollection) > 0)
    		<div class="all-products row">
		    	@foreach($productCollection as $product)
		        <div class="col-md-4 products" style="margin-bottom: 80px;">
		            <div class="card">
		                <div class="card-header">
		                	<label>{{ __($product->title) }}</label>

		                	<div style="float: right;">
		                		<a class="btn btn-primary" href="{{route('edit-product',$product->id)}}">Edit</a>
		                		<a class="btn btn-danger" href="{{route('products').'/remove/'.$product->id}}">Delete</a>
		                	</div>
		                </div>
		                <div class="card-body row">
		                	<div class="col-md-12 text-center">
		                		<img src="{{ __( URL::asset($product->image) ) }}" width="250" height="250" class="rounded mx-auto d-block"/>
		                	</div>
		                	<div class="col-md-12">
		                		@if($product->special_price)
		                			<del>
		                		@endif
			                	<label><b>Price:</b>  </label><span>{{ __($product->price) }}</span>$<br>
			                	@if($product->special_price)
		                			</del>
		                			<label><b>Sale Price:</b> </label><span>{{ __($product->special_price) }}</span>$
		                			<br>
		                		@endif
			                	<p><b>Description:</b>  {{ __($product->description) }}</p>
		                	</div>
		                </div>
		            </div>
		        </div>
		        @endforeach
		        <div class="ajax-load text-center" style="display:none">
					<p>Loading More Products. . .</p>
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
<script type="text/javascript">
    var page = 1;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    } 
	});

	function loadMoreData(page){
	  	$.ajax(
        {
            url: '?page=' + page,
            type: "get",
            beforeSend: function()
            {
                $('.ajax-load').show();
            }
        })
        .done(function(data)
        {
            if(data.html == " "){
                $('.ajax-load').html("No more records found");
                return;
            }
            $('.ajax-load').hide();
            $(".products").last().after(data.html);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              alert('server not responding...');
        });
	}

	$('#search').on('keyup',function(){
		$value = $(this).val();
		$.ajax(
        {
            url: '?search=' + $value,
            type: "get",
            beforeSend: function()
            {
                $('.ajax-load').show();
            }
        })
        .done(function(data)
        {
            if(data.html == " "){
                $('.ajax-load').html("No more records found");
                return;
            }
            $('.ajax-load').hide();
            $(".all-products").html(data.html);
            page = 0;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              alert('server not responding...');
        });
	})
</script>
@endsection