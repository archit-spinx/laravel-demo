@extends('layouts.app')

@section('content')

<div class="page_header">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				{{$pagedata->title}}
			</div>
		</div>
	</div>
</div>
<div class="page_content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				{!!html_entity_decode($pagedata->content)!!}
			</div>
		</div>
	</div>
</div>
@endsection