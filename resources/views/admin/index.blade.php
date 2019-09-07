@extends('layouts.admin')

@section('content')
        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Weekly Overview</li>
            </ol>

            <!-- Icon Cards-->
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-user fa-fw"></i>
                            </div>
{{--                            @dd($updates)--}}
                            <div class="mr-5">{{ $updates['users_count'] }} New {{ Str::plural('User', $updates['users_count']) }}!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.users.index') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-secondary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-comment-alt"></i>
                            </div>
                            <div class="mr-5">{{ $updates['replies_count'] }} New {{ Str::plural('Reply', $updates['replies_count']) }}!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.replies.index') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-question-circle"></i>
                            </div>
                            <div class="mr-5">{{ $updates['threads_count'] }} New {{ Str::plural('Thread', $updates['threads_count']) }}!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.threads.index') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-list-alt"></i>
                            </div>
                            <div class="mr-5">{{ $updates['channels_count'] }} New {{ Str::plural('Channel', $updates['channels_count']) }}!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.channels.index') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    Weekly Replies Chart</div>
                <div class="card-body">
{{--                    <canvas id="myAreaChart" width="100%" height="30"></canvas>--}}
                    <chart :labels="{{ json_encode(array_keys($replies_data)) }}"
                           :values="{{ json_encode(array_values($replies_data)) }}"
                           label="Replies"
                    ></chart>
                </div>
                <div class="card-footer small text-muted">Updated at {{ \Carbon\Carbon::now('Asia/Kolkata')->toDayDateTimeString() }}</div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © ODF 2019</span>
                </div>
            </div>
        </footer>
@endsection
