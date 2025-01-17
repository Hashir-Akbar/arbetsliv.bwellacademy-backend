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
            {{ Form::open(array('url' => '/register', 'method' => 'post', 'class' => 'form-register')) }}

                <h1>{{ __('register.registration') }} for {{$section->name}}</h1>

                @if ($errors->any())
                <div class="errors">
                    <div>{{ $errors->first('password') }}</div>
                    <div>{{ $errors->first('password_confirm') }}</div>
                </div>
                @endif

                {{ Form::hidden('id', $id) }}

                {{ Form::text('first_name', null, array('placeholder' =>'First Name', 'class' => 'form-control')) }}
                {{ Form::text('last_name', null, array('placeholder' =>'Last Name','class' => 'form-control')) }}

                {{ Form::email('email', null, array('placeholder' => __('register.email'), 'class' => 'form-control')) }}

                {{ Form::text('birth_date', null, array('placeholder' => 'åååå-mm-dd', 'class' => 'form-control')) }}

                {{ Form::select("sex", [
                    'U' => 'Okänt',
                    'M' => t("general.male"),
                    'F' => t("general.female")
                ], 'sex' ?? 'U', ['class' => 'form-control']) }}

                {{ Form::password('password', array('placeholder' => __('register.password'), 'class' => 'password-field form-control', 'required', 'autofocus')) }}               
                {{ Form::password('password_confirm', array('placeholder' => __('register.password_confirm'), 'class' => 'password-field2 form-control', 'required')) }}

                {{ Form::text('secret_code', null, array('placeholder' =>'Secret Code','class' => 'form-control')) }}

                {{ Form::submit(__('register.submit'), array('class' => 'btn')) }}

                <a class="back-link forgot" href="{{ url('/') }}">{{ __('register.cancel') }}</a>
 
            {{ Form::close() }}
        </div>
    </div>
@stop
