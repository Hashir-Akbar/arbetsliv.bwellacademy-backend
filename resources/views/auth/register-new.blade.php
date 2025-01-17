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
            {{ Form::open(array('url' => '/complete', 'method' => 'post', 'class' => 'form-register')) }}

                <h1>{{ __('register.registration') }} for {{$section->name}}</h1>

                @if ($errors->any())
                <div class="errors">
                    <div>{{ $errors->first('password') }}</div>
                    <div>{{ $errors->first('password_confirm') }}</div>
                </div>
                @endif

                {{ Form::text('first_name', array('class' => 'form-control')) }}
                {{ Form::text('last_name', array('class' => 'form-control')) }}

                {{ Form::label('email', __('register.email')) }}
                {{ Form::email('email', array('class' => 'form-control')) }}

                {{ Form::password('password', array('placeholder' => __('register.password'), 'class' => 'password-field form-control', 'required', 'autofocus')) }}               
                {{ Form::password('password_confirm', array('placeholder' => __('register.password_confirm'), 'class' => 'password-field2 form-control', 'required')) }}

                {{ Form::text('code', array('class' => 'form-control')) }}

                {{ Form::submit(__('register.submit'), array('class' => 'btn')) }}

                <a class="back-link forgot" href="{{ url('/') }}">{{ __('register.cancel') }}</a>
 
            {{ Form::close() }}
        </div>
    </div>
@stop
