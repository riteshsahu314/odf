<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'php') }}</title>

    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!};
    </script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}" defer></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}" defer></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('vendor/sb-admin.min.js') }}" defer></script>

    <script src="{{ asset('vendor/datatables.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css" />

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/sb-admin.min.css') }}" rel="stylesheet">


</head>

<body id="page-top">
<div id="app">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top px-5">
        <a href="{{ url('/') }}">
            <img src="{{ Storage::url('images/logo.svg') }}" alt="Logo" class="logo-img">
        </a>
        <a class="navbar-brand logo-text mr-1" href="{{ url('/') }}">ODF</a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0 ml-5" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

{{--        <!-- Navbar Search -->--}}
{{--        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">--}}
{{--            <div class="input-group">--}}
{{--                <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">--}}
{{--                <div class="input-group-append">--}}
{{--                    <button class="btn btn-primary" type="button">--}}
{{--                        <i class="fas fa-search"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto">
            <user-notifications></user-notifications>

            {{--            <li class="nav-item dropdown no-arrow mx-1">--}}
{{--                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    <i class="fas fa-envelope fa-fw"></i>--}}
{{--                    <span class="badge badge-danger">7</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">--}}
{{--                    <a class="dropdown-item" href="#">Action</a>--}}
{{--                    <a class="dropdown-item" href="#">Another action</a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item dropdown no-arrow">
                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar_path }}" alt="Avatar" class="avatar">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('profile', Auth::user()) }}">My Profile</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
        </ul>

    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Users</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">All Users</a>
                    <a class="dropdown-item" href="{{ route('admin.users.create') }}">Create User</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Channels</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="{{ route('admin.channels.index') }}">All Channels</a>
                    <a class="dropdown-item" href="{{ route('admin.channels.create') }}">Create Channel</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Threads</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="{{ route('admin.threads.index') }}">All Threads</a>
                    <a class="dropdown-item" href="{{ route('admin.subscriptions.index') }}">Subscriptions</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Replies</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="{{ route('admin.replies.index') }}">All Replies</a>
                </div>
            </li>
        </ul>

        <div id="content-wrapper" class="container">
            @yield('content')
        </div>

        <flash message="{{ session('flash') }}"></flash>
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <scroll-to target="#page-top"></scroll-to>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
