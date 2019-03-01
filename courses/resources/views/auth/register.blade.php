@extends('layouts.app')

@section('content')
<main>
    <section class="login_form">
        <div class="form_context">
            <div class="logo_wrapper">
            <a class="#" href=""><img src="{{ asset('img/logo.png') }}" alt=""><span>Study</span>Courses</a>
            </div>
            <form method="post" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="sr-only">

                    </label>
                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                           placeholder="Your name"  name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email_inp1" class="sr-only"></label>
                    <input type="email" class="form-control" id="email_inp1" aria-describedby="emailHelp"
                           placeholder="Email address " name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group ">
                    <label for="year" class="sr-only"></label>
                    <input type="text" class="form-control" id="year" placeholder="Year in school" name="shcool_year">
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="pass" class="sr-only"></label>
                    <input type="password" class="form-control" id="pass" name="password" required placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="conf_pass" class="sr-only"></label>
                    <input type="password" class="form-control" name="password_confirmation" required id="conf_pass" placeholder="Confirm password">
                </div>
                <button type="submit" class="btn btn-primary login_btn">Continue</button>
                {{--<a href="#">Already have an account? </a>--}}
                <div class="forget_pass">
                    <a href="{{ route('login') }}">Log In</a>
                </div>
            </form>
        </div>
    </section>
</main>

@endsection
