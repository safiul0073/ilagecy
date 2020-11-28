@extends('layouts.master')
@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Edit Supplier</h4>
                    @include('supplier.partials.form',['supplier' => $supplier])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection