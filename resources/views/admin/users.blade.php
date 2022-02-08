@extends('layouts.admin')

@section('content')
<div class="container py-4">
<div class="row">
<div class="col-lg-12">
<div class="add_new_btn mb-4">
<a class="btn btn-primary" href="/admin/users/add">Add New Users</a>
</div>
<div class="table_pages">
<table>
<tr>
	<th style="width:15%">Name</th>
	<th style="width:20%">Phone</th>
	<th style="width:35%">Email</th>
	<th style="width:15%">Role</th>
	<th style="width:20%">Action</th>
</tr>
@foreach($pagedatas as $singlepages)
<tr>
		<td>{{$singlepages->name}}</td>
		<td>{{$singlepages->phone}}</td>
		<td>{{$singlepages->email}}</td>
		<td>{{getRole($singlepages->role)}}</td>
		<td><a class="btn btn-primary mx-1" href="/admin/users/edit/{{$singlepages->id}}">Edit</a><a class="btn btn-primary" onclick="return confirm('Are you sure?')" href="/admin/users/delete/{{$singlepages->id}}">Delete</a></td>

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