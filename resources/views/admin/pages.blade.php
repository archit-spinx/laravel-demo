@extends('layouts.admin')

@section('content')
<div class="container py-4">
<div class="row">
<div class="col-lg-12">
@if(session()->has('message'))
	<div class="alert alert-success">
		{{ session()->get('message') }}
	</div>
@endif
<div class="add_new_btn mb-4">
<a class="btn btn-primary" href="{{ url('/admin/pages/add') }}">Add New Pages</a>

</div>
<div class="table_pages">
<table class="table table-striped">
<tr>
	<th style="width:5%">Page ID</th>
	<th style="width:15%">Title</th>
	<th style="width:10%">Slug</th>
	<th style="width:35%">Content</th>
	<th style="width:10%">Admin</th>
	<th style="width:25%">Action</th>

</tr>
@foreach($pagedatas as $singlepages)
<tr>
		<td>{{$singlepages->id}}</td>
		<td>{{$singlepages->title}}</td>
		<td>{{$singlepages->slug}}</td>
		<td>{{ trim_content($singlepages->content)}}</td>
		<td>{{ getUsername($singlepages->user_by) }}</td>
		<td><a class="btn btn-primary mx-1" href="{{ url('/') }}/{{$singlepages->slug}}">View</a>
			<a class="btn btn-primary mx-1" href="{{ url('/admin/pages/edit/') }}/{{$singlepages->id}}">Edit</a><a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ url('/admin/pages/delete/') }}/{{$singlepages->id}}">Delete</a></td>


	</tr>
@endforeach
</table>
<div class="d-flex justify-content-center pagination-custom">
    {!! $pagedatas->links() !!}
</div>
</div>

</div>
</div>
</div>

@endsection