@extends('layouts.master')
@section('contents')
    @include('layouts.includes.breadcrumb',['title' => 'Dashboard'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Leads:</h4>
                        <div class="filter">
                            {{-- <span> Filter By: </span> --}}
                            <div class="col-lg-6">
                                <div class="input-daterange input-group" id="date-range">
                                    <input type="text" class="form-control" id="start" name="start" placeholder="From Date">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-info b-0 text-white">TO</span>
                                    </div>
                                    <input type="text" class="form-control" name="end" id="end" placeholder="To Date">
                                    <button class="btn btn-primary date-submit ">Search</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <canvas id="pie-chart"></canvas>
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
