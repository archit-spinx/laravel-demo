@extends('layouts.admin')

@section('content')

<div class="add_new_btn">
<a href="/admin/pages/add">Add New Pages</a>
</div>
<div class="table_pages">
<table>
<tr>
	<th style="width:5%">Page ID</th>
	<th style="width:20%">Title</th>
	<th style="width:55%">Content</th>
	<th style="width:55%">Admin</th>
	<th style="width:20%">Action</th>
</tr>
@foreach($pagedatas as $singlepages)
<tr>
		<td>{{$singlepages->id}}</td>
		<td>{{$singlepages->title}}</td>
		<td>{{$singlepages->content}}</td>
		<td>{{getUsername(1)}}</td>
		<td><a class="btn btn-primary mx-1" href="/admin/pages/edit/{{$singlepages->id}}">Edit</a><a class="btn btn-primary" onclick="return confirm('Are you sure?')" href="/admin/pages/delete/{{$singlepages->id}}">Delete</a></td>

	</tr>
@endforeach
</table>
</div>
@endsection