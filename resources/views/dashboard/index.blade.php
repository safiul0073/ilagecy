@extends('layouts.master')
@section('contents')
    @include('layouts.includes.breadcrumb',['title' => 'Dashboard'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pie Chart</h4>
                        <div>
                            <canvas id="pie-chart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
