@extends('user-layout-without-panel')

@section('title')
Ändra användare
@stop

@section('page-header')
Godkänn villkor
@stop

@section('content')
<div class="page">
    {{ Form::open(array('url' => '/terms', 'method' => 'post', 'class' => 'info-form'))  }}

    <p>
        Godkänner du att dina avidentifierade data får användas i samband med forskning?
    </p>

    <input type="submit" name="accept" value="Ja" class="btn">
    <input type="submit" name="accept" value="Nej" class="btn">

    {{ Form::close() }}
</div>
@stop