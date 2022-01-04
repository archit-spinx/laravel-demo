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
    		  {{$rating}} Rating out of 5.00
              <div class="br-wrapper br-theme-fontawesome-stars"><div class="br-widget">
              	@for($i=0;$i<5;$i++)
              	@if($rating > $i)
              	<a class="br-selected"></a>
              	@else
              	<a class=""></a>
              	@endif
              	@endfor
              </div></div>
              
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

    <div class="col-md-12 mt-4">
    	<h2>Leave a Rating</h2>

    <form method="post" action="/review-submit">
    	@csrf
    	<input type="hidden" name="product_id" value="{{request()->id}}">
        <select id="example" name="rating">
		  <option value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5" selected>5</option>
		</select>
		<input type="submit" name="submit" value="SUBMIT">
    </form>
	    @if(session()->has('message'))
	<div class="alert alert-success">
	    {{ session()->get('message') }}
	</div>
	@endif
    </div>
    </div>
</div>
<script type="text/javascript">
   $(function() {
      $('#example').barrating({
        theme: 'fontawesome-stars'
      });
   });

</script>
@endsection