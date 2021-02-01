@extends('layouts.master')
@section('contents')
    @include('layouts.includes.breadcrumb',['title' => 'Lead Timeline'])


<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ date("h:m a , d-m-Y ") }}


                    <ul class="chat-list chat active-chat">
                        @foreach ($timelines as $timeline)
                            <li class="chat-item">
                                <div class="chat-img">
                                    <img src="../../assets/images/users/2.jpg" alt="user">
                                </div>

                                <div class="chat-content">
                                    <h6 class="font-medium">{{ $timeline->caller->name }}</h6>
                                    <div class="box bg-light-info">{{ $timeline->task }}</div>
                                </div>
                                <div class="chat-time">

                                    {{ $timeline->updated_at->format("h:m a , d-m-Y ") }} ( {{ $timeline->created_at->diffForHumans() }} )
                                </div>
                            </li>

                        @endforeach
                    </ul>





                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>

@endsection