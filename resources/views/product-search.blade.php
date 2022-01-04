@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-primary" style="text-align: center;">Elasticsearch</h1>
    </div>
</div>
<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div class="row">
      <div class="col-lg-6">
        <div class="input-group">
          <input name="es_search" value="{{ old('search') }}" type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default es_search" >Go!</button>
          </span>
        </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    </div>
    <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            @if(!empty($products))
              @foreach($products as $key => $value)
                <h3 class="text-danger">{{ $value["_source"]['title'] }}</h3>
                <p>{{ $value["_source"]['price'] }}</p>
                <p>{{ $value["_source"]['special_price'] }}</p>
              @endforeach
            @else 
              {{ __('Product\'s were not found!!') }}
            @endif
          </div>
        </div>
    </div>
  </div>
</div>
@endsection