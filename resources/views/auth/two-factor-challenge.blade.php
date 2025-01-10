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
            <h1>Ange din kod för tvåfaktorsautentisering</h1>

            <form class="form-register" action="{{ url('two-factor-challenge') }}" method="POST">
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

                <input type="text" class="form-control" name="code" required>

                <input type="submit" class="btn" value="Logga in">
            </form>
        </div>
    </div>
@stop