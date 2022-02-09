@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @guest
                        {{ __('Please Login or Register for access this website.') }}
                    @else
                        <div class="view-product">
                            <span>We have {{ $productCounter }} Products.</span>
                            <a class="btn btn-primary" href="{{  route('products') }}">View All Products</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
