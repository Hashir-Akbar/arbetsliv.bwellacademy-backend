<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Bwell</title>

    <link rel="icon" href="{{ asset(version('/images/cropped-logo-green-512x512-32x32.png')) }}" sizes="32x32" />
    <link rel="icon" href="{{ asset(version('/images/cropped-logo-green-512x512-192x192.png')) }}" sizes="192x192" />
    
    <link rel="stylesheet" href="{{ asset('/vendor/normalize.css-8.0.1/normalize.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans">
    <link rel="stylesheet" href="{{ asset('/css/proxima-nova.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/jquery-ui-1.12.1/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/magnific-popup-1.1.0/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset(version('/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset(version('/css/mobile.css')) }}">
    <link rel="stylesheet" href="{{ asset(version('/css/mfp.css')) }}">

    @yield('styles')

    <link rel="stylesheet" href="{{ asset(version('/css/print.css')) }}" media="print">

    <script type="text/javascript" src="{{ asset('/vendor/jquery-1.12.4/jquery-1.12.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/magnific-popup-1.1.0/jquery.magnific-popup.min.js') }}"></script>

    <script type="text/javascript">
        window.fms_type = '{{ config('fms.type') }}';
        window.fms_lang = '{{ App::getLocale() }}';
        window.fms_url = '{{ url('/') }}';
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        });
    </script>
</head>
<body>
    @if (Auth::check())
    <div class="mobile-sidebar">
        @include('_mobile-sidebar', ['user' => Auth::user(), 'active' => $active ?? ''])
    </div>
    <div class="mobile-sidepanel">
        @include('_mobile-sidepanel', ['user' => Auth::user()])
    </div>
    @endif
    
    @yield('body')

    <script type="text/javascript" src="{{ asset(version('/js/fms.js')) }}"></script>
</body>
</html>