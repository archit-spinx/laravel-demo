@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<a href="{{ route('add.product.category') }}" class="btn btn-primary">Add New Category</a>
		</div>
	</div>
	<table class="table table-striped">
	  	<thead>
		    <tr>
		      	<th scope="col" width="10">#</th>
		      	<th scope="col" width="10">Name</th>
		      	<th scope="col" width="60">Description</th>
		      	<th scope="col" width="20">Action</th>
		    </tr>
	  	</thead>
	  	<tbody>
	  		@if(session()->has('message'))
				<div class="alert alert-success">
				    {{ session()->get('message') }}
				</div>
			@endif
	    	@if(count($categoryCollection) > 0)
	    		@foreach($categoryCollection as $count => $category)
				    <tr>
				      	<th scope="row">{{ __($count + 1) }}</th>
				      	<td>{{ __($category->category_name) }}</td>
				      	<td>{{ __($category->category_description) }}</td>
				      	<td>
				      		<a href="{{route('edit.product.category',$category->id)}}" class="btn btn-primary">
				      			Edit
				      		</a>
				      		<a href="{{route('remove.product.category',$category->id)}}"  
								onclick="return confirm('Are you sure, do you want delete this category?')"
				      			class="btn btn-danger">
				      			Delete
				      		</a>
				      	</td>
				    </tr>
				@endforeach
			@else
				<tr> 
			      	<th scope="row" colspan="4">{{ __("No Categories Found") }}</th>
			    </tr>
		    @endif
	  	</tbody>
	</table>
</div>
@endsection