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
    <link href="{{ asset('css/bootstrap.min.css') }}">
    {{--  <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css"
          integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script>
        base_url = "<?php echo $app->make('url')->to('/');?>";
        action = "<?php echo Route::getCurrentRoute()->getActionName();?>";
    </script>

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
</head>
<body>

<div id="" class="admin">
    @guest

    @else
        {{--        <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                <li class="">
                    <a href="#">
                        {{ Auth::user()->name }}
                    </a>
                </li>--}}
        <aside>
            <a class="navbar-brand logo dashboard_logo" href="#"><img src="{{ asset('img/logo.png') }}"
                                                                      alt=""><span>Study</span>Courses</a>
            <nav class="admin__nav">
                <ul class="menu">
                    <?php
                    if(!empty($subjects)){

                    foreach ($subjects as $single => $val){ ?>
                    <li class="menu__item open_drop">
                        <a class="menu__link active" href="#"> <?php echo $val['name']; ?> <i
                                    class="fas fa-caret-right"></i></a>
                        <div class="tab">
                            <ul class="dropdown_menu">
                                <?php
                                if(!empty($subject_type)){

                                foreach ($subject_type as $single){

                                if ($single->subject_id != $val['id']) {
                                    continue;
                                }

                                ?>
                                <li class="menu__item">
                                    <a class="menu__link tablinks" id="algebra1"
                                       onclick="opencourse(event, '{{ $single->name}}')"><?php echo $single->name;?>
                                        <span>({{count($subject_type)}})</span></a>
                                </li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </li>
                    <?php } } ?>
                </ul>
            </nav>
        </aside>
    @endguest
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootbox.min.js') }}"></script>
<script src="{{ asset('js/validation_lib.js') }}"></script>
<script src="{{ asset('js/ajax_lib.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
{{--<script src="{{ asset('js/chart.js') }}"></script>--}}
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
