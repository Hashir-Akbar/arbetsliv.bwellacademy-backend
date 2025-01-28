{{-- @extends('user-layout-without-panel')
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
@stop --}}


<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR-kod</title>
    
    <link rel="stylesheet" href="{{ asset('/vendor/normalize.css-8.0.1/normalize.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset(version('/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset(version('/css/students.css')) }}">

    <style>
        body {
            padding: 25px 55px 0;
        }

        .no-print i {
            padding-right: 0.5em;
            transition: opacity 200ms ease;
        }
        .no-print:hover i {
            opacity: 0.8;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <a href="javascript:window.print();" class="no-print"><i class="fa fa-print"></i>Skriv ut</a>
    <h1>QR-kod {{ $section->full_name() }}</h1>
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
</body>
</html>