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
                            <h4 class="card-title w-25">Users:</h4>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{ route('users.create') }}" class="float-right btn btn-success">Add User</a>
                        </div>
                        <div class="col-lg-6">
                            <a href=" {{ route('users.index') }} ">Active Users ( {{$users->count()}})</a>
                            - <a href="  {{ route('users.trash') }} ">Trash ({{$trashes->count()}})</a>
                            - <a href=" {{ route('users.restore.all') }}">Restore All</a>
                        </div>
                    </div>


                    <table class="table" id="trash-user-datatable">
                        <thead>
                            <tr>
                                <th>Id </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
    <script src="/assets/custom-assets/js/users-trash.js"> </script>
@endsection