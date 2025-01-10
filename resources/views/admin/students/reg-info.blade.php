<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registreringsinfo - Bwell</title>
    
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
    <h1>Registreringsinformation</h1>
    <table class="table-register-info">
        <thead>
            <tr>
                <th>{{ __('general.first_name') }}</th>
                <th>{{ __('general.last_name') }}</th>
                <th>{{ __('students.unit') }}</th>
                <th>{{ __('students.section') }}</th>
                <th>{{ __('students.code') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <?php if (is_null($user)) {
    continue;
} ?>
            <tr>
                <td class="first_name">{{ $user->first_name }}</td>
                <td class="last_name">{{ $user->last_name }}</td>
                <td class="unit">
                    @if ($user->section()->count() > 0)
                    {{ $user->section->unit->name }}
                    @endif
                </td>
                <td class="section">
                    @if ($user->section()->count() > 0)
                    {{ $user->section->full_name() }}
                    @endif
                </td>
                <td class="registration_code">{{ $user->registration_code }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>