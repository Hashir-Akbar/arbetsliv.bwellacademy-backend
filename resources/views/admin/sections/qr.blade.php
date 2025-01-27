@extends('user-layout-without-panel')
@section('page-header')
@if (config('fms.type') == 'work')
    QR Code
@else
    QR Code
@endif
@stop
@section('content')

<div>
    <h2>Use the QR Code and Secret Code to let users create their own profile.</h2>
    <h3>
        Secret Code: <strong>{{ $section->secret_code }}</strong>
    </h3>
    <h3>
        QR Code: </em>
    </h3>

    <div>
        <img src="data:image/png;base64,{{ base64_encode($qr_code) }}" alt="QR Code">
    </div>
</div>w
@stop