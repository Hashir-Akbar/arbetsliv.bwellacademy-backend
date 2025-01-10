@extends('user-layout-with-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/profile.css')) }}">
@stop

@section('page-header')
Åtkomst nekad
@stop

@section('content')
<p>Du saknar behörigheten att se den här elevens profil.</p>
@stop