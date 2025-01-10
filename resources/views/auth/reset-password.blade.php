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
            <h1>{{ __('remind.reset_password') }}</h1>



            <form class="form-register" action="{{ route('password.update') }}" method="POST">
                @csrf

                @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <input type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                <input type="password" placeholder="Lösenord" class="form-control" name="password" required>
                <input type="password" placeholder="Bekräfta lösenord" class="form-control" name="password_confirmation" required>

                <input type="submit" class="btn" value="Skicka">
            </form>
        </div>
    </div>
@stop