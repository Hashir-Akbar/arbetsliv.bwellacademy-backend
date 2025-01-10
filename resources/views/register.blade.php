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
@stop

@section('title', 'Registrera')

@section('body')
    <div class="head">
        <div class="top">
            <a href="{{ url('/') }}" class="logo"></a>
            <div class="slogan">
                <span>Fysisk │ Mental │ Social</span>
            </div>
            @include('_nav-lang')
        </div>
    </div>
    <div class="login-form">
        <div class="gradient"></div>
        <div class="container">
            <form method="POST" action="{{ url('register') }}" class="form-login">
                @csrf

                <h1>{{ __('register.registration') }}</h1>

                @if (!$errors->isEmpty())
                <div class="errors">
                    <div>{{ $errors->first('name') }}</div>
                    <div>{{ $errors->first('code') }}</div>
                </div>
                @endif

                <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('register.first_name') }}" class="form-control" required autofocus>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="{{ __('register.code') }}" class="form-control" required>

                <input type="submit" value="{{ __('register.submit') }}" class="btn">
                <a href="{{ url('/') }}" class="forgot">{{ __('register.cancel') }}</a>
 
            </form>
        </div>
    </div>
@stop