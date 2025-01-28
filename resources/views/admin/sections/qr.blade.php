@extends('user-layout-without-panel')
@section('page-header')
@if (config('fms.type') == 'work')
    QR-kod
@else
    QR-kod
@endif
@stop
@section('content')

<div>
    <h2>Använd QR-koden och den hemliga koden för att låta användare skapa sin egen profil.</h2>
    <h3>
        Hemlig kod: <strong>{{ $section->secret_code }}</strong>
    </h3>
    <h3>
        QR-kod: </em>
    </h3>

    <div>
        <img src="data:image/png;base64,{{ base64_encode($qr_code) }}" alt="QR Code">
    </div>
</div>
@stop