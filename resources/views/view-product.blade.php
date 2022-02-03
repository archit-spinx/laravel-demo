@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<div class="container">
    <div class="row justify-content-center">

    	<div class="col-md-6"><img src="{!! $product->image !!}" width="250" height="250" class="rounded mx-auto d-block"/></div>
    	<div class="col-md-6">
    		<h2>{{ __($product->title) }}</h2>
    		<div class="product-rating">
    		  {{$rating}} Rating out of 5.00
    		  @if($rated == 1)
              <div id="demo-2"></div>
              <script>

            $(function () {

            $("#demo-2").jRate({
                rating: {{$rating}},
                strokeColor: 'black',
                width:30,
                height:30,
                 startColor:"yellow",
				endColor:"yellow",
                readOnly:true
            });
        });
    </script>
              @else
              <form method="post" id="ratingform" action="review-submit">
                    @csrf
                    <input type="hidden" name="product_id" value="{{request()->id}}">
                    <input type="hidden" name="rating" id="rating" value="">
                </form>
              	<div id="demo-1"></div>
              	 <script>

            $(function () {

            $("#demo-1").jRate({
                rating: {{$rating}},
                strokeColor: 'black',
                width:30,
                height:30,
                startColor:"yellow",
				endColor:"yellow",

                onSet: function(rating) {
                    $("#rating").val(rating);
                    $("#ratingform").submit();
                }
            });
        });
    </script>
                @endif  
			</div>
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
@endsection