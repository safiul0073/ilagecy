@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Products') }}</div>

                    <div class="card-body">
                        <a href="{{ route('dashboard', 0) }}" class="btn btn-light m-2">All</a>
                        @foreach ($products as $product)
                            <a href="{{ route('dashboard', $product->id) }}"
                                class="btn btn-light m-2">{{ $product->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
