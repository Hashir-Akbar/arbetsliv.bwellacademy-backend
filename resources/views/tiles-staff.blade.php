@extends('user-layout-with-panel')

@section('page-header')
Välkommen {{ $user->full_name() }}
@stop
@section('content')
<div class="center-screen" style="display:none;">
    <img src="{{ asset('images/fms_logo_blue.png') }}">
</div>
<script>
    $('.center-screen').fadeIn(4000);
</script>
@stop
