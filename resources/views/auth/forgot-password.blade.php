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

@section('body')
    <div class="head">
        @include('_top')
    </div>
    <div class="login-form">
        <div class="gradient"></div>
        <div class="container">
            <form class="form-remind" action="{{ route('password.request') }}" method="POST">
                @csrf
                <h1>{{ __('remind.reset_password') }}</h1>
                @if (Session::has('error'))
                <p class="errors">{{ Session::get('error') }}</p>
                @endif
                @if (Session::has('status'))
                <p class="status">{{ Session::get('status') }}</p>
                @endif
                <input type="email" name="email" class="form-control" placeholder="Email">
                <input type="submit" class="btn" value="{{ __('remind.submit') }}">
            </form>
        </div>
    </div>
@stop