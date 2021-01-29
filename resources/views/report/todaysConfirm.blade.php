@extends('layouts.master')
@section('contents')
    {{-- @include('layouts.includes.lead_modal_note')
    @include('layouts.includes.lead_modal_edit')
    @include('layouts.includes.lead_duplicate_modal') --}}

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <h4 class="ml-4 mb-0 pb-0">Filter Lead</h4>

                    <div class="card-body">
                        <form action="{{ route('reports.export') }}" method="POST">
                            @csrf
                            <div class="filter row mb-3">
                                <div class="col-lg-4">
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" id="startDate" name="start"
                                            placeholder="From Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info b-0 text-white">TO</span>
                                        </div>
                                        <input type="text" class="form-control" name="end" id="endDate" placeholder="To Date">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="orderId" name="orderId"
                                            placeholder="Order Id">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button class="btn btn-primary filter-search-submit">Search</button>
                                    <button class="btn btn-primary" id="export-to-excel">Export to Excel</button>
                                    <button class="btn btn-primary" onClick="(() => location.reload(true))()"><i
                                            class="mdi mdi-refresh text-white"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-lg-6 statuses mb-4 mt-2">
                                <input type="hidden" name="role" value="{{ auth()->user()->role }}" id="role">
                                <a href="javascript;" id="changeStatus" data-status="">All</a>
                                @can('isAdmin')

                                    @foreach (App\Models\Lead::statuses as $status)
                                        - <a href="javascript;" id="changeStatus" data-status="{{ $status }}">{{ ucwords($status) }}</a>
                                    @endforeach

                                @elsecan('isCaller')

                                    @foreach (App\Models\Lead::CALLER_STATUS as $status)
                                        - <a href="javascript;" id="changeStatus" data-status="{{ $status }}">{{ ucwords($status) }}</a>
                                    @endforeach

                                @endcan

                            </div>

                            <div class="col-lg-6 mb-4 ">
                                <div class="goto-wrapper float-right">
                                    <label for="page">Page:</label>
                                    <input type="number" class="p-1" id="gotoPageNumber">
                                    <button id="gotoPage" class="btn btn-primary">Go</button>
                                </div>

                            </div>
                        </div>

                        <table class="table" id="report-datatable">
                            <thead>
                                <tr>
                                    <th>Lead ID</th>
                                    <th>OrderID</th>
                                    <th>Customer</th>
                                    <th>Caller </th>
                                    <th>Product</th>
                                    <th>Last Modified At</th>
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

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
@endsection
@section('js')
    <script src="/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/custom-assets/js/todaysConfirm.js"> </script>
@endsection
