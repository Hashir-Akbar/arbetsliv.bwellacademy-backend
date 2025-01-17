@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    QR Code
@else
    QR Code
@endif
@stop

@section('content')


    <p>
        QR code for department <em>{{ $section->name }}</em>
    </p>
    <p>
        Secret Code: <strong>{{ $section->secret_code }}</strong>
    </p>

    <div>
        <img src="data:image/png;base64,{{ base64_encode($qr_code) }}" alt="QR Code">
    </div>

@stop