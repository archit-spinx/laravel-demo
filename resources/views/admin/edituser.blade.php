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
<label>Name</label>
<input type="text" name="name"  class="form-control" value="{{$pagedata->name}}">
</div>
<div class="input_field mb-3">
<label>Email</label>
<input type="email" name="email"  class="form-control" value="{{$pagedata->email}}" readonly>
</div>
<div class="input_field mb-3">
<label>Phone</label>
<input type="text" name="phone"  class="form-control" value="{{$pagedata->phone}}">
</div>
<div class="input_field mb-3">
<label>Role</label>
<select name="role" class="form-control">
<option value="">Select</option>
<option value="0" @if($pagedata->role == 0) selected @endif>Admin</option>
<option value="1" @if($pagedata->role == 1) selected @endif>Subscriber</option>
</select>

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
