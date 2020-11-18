@extends('layouts.master')
@section('contents')
    @include('layouts.includes.breadcrumb',['title' => 'Dashboard'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Leads:</h4>
                        <div class="filter row">
                            <div class="col-lg-4">
                                <div class="input-daterange input-group" id="date-range">
                                    <input type="text" class="form-control" id="start" name="start" placeholder="From Date">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-info b-0 text-white">TO</span>
                                    </div>
                                    <input type="text" class="form-control" name="end" id="end" placeholder="To Date">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <select name="" id="product_filter" class="select2">
                                    <option value="">Select a product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select name="" id="supplier_filter" class="select2">
                                    <option value="">Select a supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary filter-submit">Search</button>
                                <button class="btn btn-primary" onClick="(() => location.reload(true))()"><i
                                        class="mdi mdi-refresh"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 mt-4">
                                <div id="stats">
                                    <ul></ul>
                                </div>
                            </div>
                            <div class="col-lg-7 float-right">
                                <div class="mt-4 chart-div">
                                    <canvas id="pie-chart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('js')
    <script src="/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/custom-assets/js/dashboard.js"> </script>
@endsection
