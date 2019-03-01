<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css"
          integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/drop-zone.css') }}">
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.min.css') }}">
    <link href="{{ asset('css/aos.css') }}">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('css/admin/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin_style.css') }}" rel="stylesheet">

    <script>
        base_url = "<?php echo $app->make('url')->to('/');?>";
        action   = "<?php echo Route::getCurrentRoute()->getActionName();?>";
    </script>
</head>
<body>
<div>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- NAVBAR -->
        <nav class="navbar navbar-default navbar-fixed-top">
           {{-- <div class="brand">
                <a href="index.html"><img src="assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
            </div>--}}
            <div class="container-fluid">
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
               {{-- <form class="navbar-form navbar-left">
                    <div class="input-group">
                        <input type="text" value="" class="form-control" placeholder="Search dashboard...">
                        <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
                    </div>
                </form>--}}
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{--<img src="{{asset('user/'.Auth::guard('admin')->id.'/'.Auth::guard('admin'))}}" class="img-circle" alt="Avatar">--}} <span>{{--{{Auth::guard('admin')->name}}--}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
                                <li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
                                <li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
                                <li><a href="#"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                        <!-- <li>
                            <a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->
        <!-- LEFT SIDEBAR -->
        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav">
                        <li><a href="{{url('/admin/dashboard')}}" class="">Dashboard</a></li>
                        <li><a href="{{url('/admin/update_template')}}" class="">Update template</a></li>
                        <li>
                            <a href="#subject" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Subject</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="subject" class="collapse ">
                                <ul class="nav">
                                    <li><a href="{{url('/add_subject')}}" class="">Add Subject</a></li>
                                    <li><a href="{{url('/admin/all_subject')}}" class="">All subjects</a></li>
                                    <li><a href="{{url('/add_subject_type')}}" class="">Add Subject branch</a></li>
                                    <li><a href="{{url('/admin/all_subject_type')}}" class="">All Subject branch</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#Lesson" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Lesson</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="Lesson" class="collapse ">
                                <ul class="nav">
                                    <li><a href="{{url('/admin/add_lesson')}}" class="">Add Lesson</a></li>
                                    <li><a href="{{url('/admin/all_lesson')}}" class="">All Lesson</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#enable" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Enable Work</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="enable" class="collapse ">
                                <ul class="nav">
                                    <li><a href="{{url('/admin/enable_work')}}" class="">Enable Work</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#quiz" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Quiz</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="quiz" class="collapse ">
                                <ul class="nav">
                                    <li><a href="{{url('/admin/add_quiz')}}" class="">Add Quiz</a></li>
                                    <li><a href="{{url('/admin/all_quiz')}}" class="">All Quiz</a></li>
                                    <li><a href="{{url('/admin/add_example')}}" class="">Add Example</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#check" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>User</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="check" class="collapse ">
                                <ul class="nav">
                                    <li><a href="{{url('/admin/all_user_check')}}" class="">All User Check</a></li>
                                    <li><a href="{{url('/admin/add_user')}}" class="">Add User</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END LEFT SIDEBAR -->
        <!-- MAIN -->
        <div class="main" style="width: 80%;">
            @yield('content')
            </div>
            <!-- END MAIN CONTENT -->
        </div>
        <!-- END MAIN -->
        <div class="clearfix"></div>
        <footer>
            <div class="container-fluid">
            </div>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
{{--   <script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}
<script src="{{ asset('js/bootbox.min.js') }}"></script>

<script src="{{ asset('js/dropzone.js') }}"></script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/ajax_lib.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/validation_lib.js') }}"></script>
<script src="{{ asset('js/admin_main.js') }}"></script>
</body>
</html>
