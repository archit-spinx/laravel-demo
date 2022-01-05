@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<div class="container">
    <div class="row justify-content-center">

    	<div class="col-md-6"><img src="{{ __( URL::asset($product->image) ) }}" width="250" height="250" class="rounded mx-auto d-block"/></div>
    	<div class="col-md-6">
    		<h2>{{ __($product->title) }}</h2>
    		<div class="product-rating">
    		  {{round($rating,2)}} Rating out of 5.00
    		  @if($rated == 1)
              <div class="br-wrapper br-theme-fontawesome-stars"><div class="br-widget">
                @for($i=0;$i<5;$i++)
                @if($rating > $i)
                <a class="br-selected"></a>
                @else
                <a class=""></a>
                @endif
                @endfor
              </div></div>
              @else
              	<form method="post" id="ratingform" action="/review-submit">
                	@csrf
                	<input type="hidden" name="product_id" value="{{request()->id}}">
                    <select id="example" name="rating">
            		  <option value="1" <?php if($rating >= 0 && $rating <= 1){ ?> selected <?php } ?>>1</option>
            		  <option value="2" <?php if($rating > 1 && $rating <= 2){ ?> selected <?php } ?>>2</option>
            		  <option value="3" <?php if($rating > 2 && $rating <= 3){ ?> selected <?php } ?>>3</option>
            		  <option value="4" <?php if($rating > 3 && $rating <= 4){ ?> selected <?php } ?>>4</option>
            		  <option value="5" <?php if($rating > 4 && $rating <= 5){ ?> selected <?php } ?>>5</option>
            		</select>
                </form>
                @endif  
			</div>
			@if($product->special_price)
    			<del>
    		@endif
        	<label><b>Price:</b>  </label>$<span>{{ __($product->price) }}</span><br>
        	@if($product->special_price)
    			</del>
    			<label><b>Sale Price:</b> </label>$<span>{{ __($product->special_price) }}</span>
    			<br>
    		@endif
        	<p><b>Description:</b>  {{ __($product->description) }}</p>
    	</div>	

    </div>
</div>
<script type="text/javascript">
   $(function() {
      $('#example').barrating({
        theme: 'fontawesome-stars',
        onSelect: function(value, text, event) {
        	$("#ratingform").submit();
        }
      });
   });

</script>
@endsection