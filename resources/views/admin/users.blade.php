@extends('layouts.admin')

@section('content')

<div class="add_new_btn">
<a href="/admin/users/add">Add New Users</a>
</div>
<div class="table_pages">
<table>
<tr>
	<th style="width:10%">Name</th>
	<th style="width:20%">Phone</th>
	<th style="width:55%">Email</th>
	<th style="width:50%">Role</th>
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
</div>
@endsection