@extends('layouts.app')

@section('content')
    <main>
        <section class="login_form">
            <div class="form_context">
                <div class="logo_wrapper">
                    <a class="" href="#"><img src="{{ asset('img/logo.png') }}" alt=""><span>Study</span>Courses</a>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
{{--                    <a href="{{url('auth/google')}}" class="btn btn-primary google_btn">
                        <i class="fab fa-google-plus"></i>
                        Continue with Google+
                    </a>--}}
                    <span class="or">or</span>
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
                    <label class="checkbox_cont">Remember me for 30 days?
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                    <div class="forget_pass text-center">
                        <h5 href="#" class="text-center">Don’t have an account yet?</h5>
                        <a href="{{ route('register') }}">Create account</a>

                    </div>
                    <div class="forget_pass text-center">
                        <a href="{{ url('reset_password') }}">Reset Password</a>
                    </div>

                </form>
            </div>
        </section>
    </main>
@endsection
