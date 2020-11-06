@extends('layouts.master')
@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Leads:</h4>

                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Supplier Name</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Note</th>
                            <th>Order Id</th>
                            <th>Admin Status </th>
                            <th>Caller Status </th>
                            <th>Create At</th>
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('js')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: '{!!  route('leads.get') !!}',
                columns: [
                    {data: 'product_id', name: 'product_id'},
                    {data: 'supplier_id', name: 'supplier_id'},
                    {data: 'customer_id', name: 'customer_id'},
                    {data: 'customer_phone', name: 'customer_phone'},
                    {data: 'customer_address', name: 'customer_address'},
                    {data: 'note', name: 'note'},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'status_admin', name: 'status_admin'},
                    {data: 'status_caller', name: 'status_caller'},
                    {data: 'created_at', name: 'created_at'},
                ]
            });
        });

    </script>
@endsection
