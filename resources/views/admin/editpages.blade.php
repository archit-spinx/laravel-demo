@extends('layouts.admin')

@section('content')
<div class="container py-4">
<div class="row">
<div class="col-lg-12">
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form class="py-4" action="" method="POST">
@csrf
<input type="hidden" name="id"  class="form-control" value="{{$pagedata->id}}">
<div class="input_field mb-3">
<label>Title</label>
<input type="text" name="page_title"  class="form-control" value="{{$pagedata->title}}">
</div>
<div class="input_field mb-3">
<label>Content</label>
<textarea name="pagecontent" class="form-control">{{$pagedata->content}}</textarea>
</div>
<div class="submit_form">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
@if(session()->has('message'))
<div class="alert alert-success">
{{ session()->get('message') }}
</div>
@endif
</div>
</div>
</div>
@endsection
