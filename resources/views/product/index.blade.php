@extends('layouts.master')
@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        @include('layouts.includes.alert')
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h4 class="card-title w-25">Products:</h4>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{ route('products.create') }}" class="float-right btn btn-success">Add Products</a>
                        </div>
                    </div>


                    <table class="table" id="product-datatable">
                        <thead>
                            <tr>
                                <th>Id </th>
                                <th>Name</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="/assets/custom-assets/js/products.js"> </script>
@endsection