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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/font-awesome.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.min.css') }}">
    <link href="{{ asset('css/aos.css') }}">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @if (\Request::is('change_plan'))
        <?php
        $class = 'global_body';
        ?>
    @else
        <?php
        $class = '';
        ?>
    @endif
    <script>
        base_url = "<?php echo $app->make('url')->to('/');?>";
        action = "<?php echo Route::getCurrentRoute()->getActionName();?>";
    </script>
</head>
<?php
$serv = Request::server();
$statistic = StatisticService::insert_statistic($serv);
$view = StatisticService::enable_working();
if($view){ ?>
<div class="under_workin_main">
    <p class="under_review">Under Working</p>
</div>
<?php
  return false;
}
?>

<body class="{{$class}}">

<div id="">
    @guest
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="content">
                <a class="navbar-brand" href="{{ url('/')}}"><img src="{{ asset('img/logo.png') }}"
                                                                  alt=""><span>Study</span>Courses</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item sign_up">
                            <a class="nav-link" href="{{ url('/pricing_plan')}}">Get started</a>
                        </li>
                        {{--  <li class="nav-item">
                              <a class="nav-link" href="#">Courses</a>
                          </li>--}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about_us')}}"> About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact')}}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/faq')}}">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in</a>
                        </li>
                        <li class="nav-item sign_up">
                            <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="content">
                <a class="navbar-brand" href="{{ url('/')}}"><img src="{{ asset('img/logo.png') }}"
                                                                  alt=""><span>Study</span>Courses</a>
                {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>--}}
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home')}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about_us')}}"> About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact')}}">Contact</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        {{--      <li class="">
                                  <a href="#">
                                      {{ Auth::user()->name }}
                                  </a>
                              </li>--}}
                    </ul>
                </div>
            </div>
        </nav>
    @endguest
    @yield('content')
</div>
<footer>
    <div class="content">
        <?php

        $action = Route::getCurrentRoute()->getActionName();
        $method = explode('@', $action);
        if($method[1] == 'main' || $method[1] == 'about_us'){ ?>
        <div class="row">
            <div class="col-md-4">
                <div class="footer_logo">
                    <h4 class="footer_logo_and_text">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                        <span>Study</span>Courses</h4>
                    <p>Our company lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                        ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <ul>
                        <li>
                            <a href="#" class="active"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer_box">
                    <h4>Courses</h4>
                    <ul>
                        {{--  <li><a href="#">Courses</a></li>--}}
                        <li><a href="{{ url('/about_us')}}">About Us</a></li>
                        <li><a href="{{ url('/contact')}}">Contact</a></li>
                        <li><a href="{{ route('login') }}">Log in</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <div class="footer_box">
                    <h4>contact us</h4>
                    <ul>
                        <li><p><i class="fas fa-phone"></i>+1 234 567-89-00</p></li>
                        <li><p><i class="fas fa-envelope"></i>abcdff@gmail.com</p></li>
                        <li><p><i class="fas fa-map-marker-alt"></i>Attorney at Law
                                1556 Broadway, suite 416
                                New York, NY, 10120, USA </p></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
    <div class="copyright">
        <div class="copy_text">
            <p>© Copyright 2018. StudyCourses.All rights reserved.</p>
        </div>
    </div>
</footer>
<!-- Scripts -->
<script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/bootbox.min.js') }}"></script>
<script src="{{ asset('js/validation_lib.js') }}"></script>
<script src="{{ asset('js/ajax_lib.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
