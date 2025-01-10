@extends('base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    <!--[if gte IE 9]>
    <style type="text/css">
        .gradient {
            filter: none;
            behaviour: url(/js/PIE.htc);
        }
    </style>
    <![endif]-->
    <style type="text/css">
        h1 {
            margin-bottom: 30px;
            color: #fff;
            text-align: center;
        }
        .container {
            top: -160px;
        }
    </style>
@stop

@section('body')
    <div class="head">
        @include('_top')
    </div>
    <div class="login-form">
        <div class="gradient"></div>
        <div class="container">
            <h1>{{ __('login.title') }}</h1>
            <form method="POST" action="{{ route('login') }}" class="form-login">
                @csrf

                <div class="profile-placeholder"></div>

                @if (Session::has('status'))
                <p class="status">
                    {{ Session::get('status') or '' }}
                </p>
                @endif

                @if ($errors->any())
                <p class="errors">
                    {{ $errors->first('email') }}
                    {{ $errors->first('password') }}
                </p>
                @endif

                <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('login.email') }}" class="form-control" required autofous>
                <input type="password" name="password" placeholder="{{ __('login.password') }}" class="form-control" required>

                <input type="submit" value="{{ __('login.login') }}" class="btn">

                <a href="{{ route('password.request') }}" class="forgot">{{ __('login.forgot_password') }}</a>
            </form>
        </div>
    </div>
@stop