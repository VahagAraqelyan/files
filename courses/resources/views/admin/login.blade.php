<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.css') }}">
    <link href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('css/themify-icons.css') }}">
    <link href="{{ asset('css/typography.css') }}">
    <link href="{{ asset('css/default-css.css') }}">
    <link href="{{ asset('css/admin_style.css') }}">
</head>
<body>

<div id="preloader">
    <div class="loader"></div>
</div>
<div class="login-area">
    <div class="container">


        <div class="login-box ptb--100" id="admin_login" style=" padding: 50px;  width: 60%;  margin: auto;">
            <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email_inp" class="sr-only"></label>
                    <input type="email" class="form-control" id="email_inp" aria-describedby="emailHelp"
                           placeholder="Email address or username"  name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="pass" class="sr-only"></label>
                    <input type="password" class="form-control" id="pass" placeholder="Password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary login_btn">
                    Continue
                </button>

            </form>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/validation_lib.js') }}"></script>
    <script src="{{ asset('js/ajax_lib.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/slicknav.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/admin_main.js') }}"></script>
</div>
</body>
</html>
