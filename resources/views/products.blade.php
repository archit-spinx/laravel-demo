@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    	@if(session()->has('message'))
			<div class="alert alert-success">
			    {{ session()->get('message') }}
			</div>
		@endif
    	@if(count($productCollection) > 0)
	    	@foreach($productCollection as $product)
	        <div class="col-md-4">
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
	        </div><br>
	        @endforeach
	        <p class="text-center loading">Loading...</p>
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
    var paginate = 1;
    loadMoreData(paginate);
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            paginate++;
            loadMoreData(paginate);
          }
    });
    // run function when user reaches to end of the page
    function loadMoreData(paginate) {
        $.ajax({
            url: '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('.loading').show();
            }
        })
        .done(function(data) {
            if(data.length == 0) {
                $('.loading').html('No more posts.');
                return;
              } else {
                $('.loading').hide();
                $('#post').append(data);
              }
        })
           .fail(function(jqXHR, ajaxOptions, thrownError) {
              alert('Something went wrong.');
           });
    }
</script>
@endsection