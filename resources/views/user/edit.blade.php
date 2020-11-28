@extends('layouts.master')
@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Edit user</h4>
                    @include('user.partials.form',['user' => $user])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection