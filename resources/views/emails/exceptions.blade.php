<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        Ett fel uppstod i Bwell: {{ $errorMsg }}<br>
        <br>
        URL: {{ $url }}<br>
        <br>
        Fil: {{ $errorFile }}<br>
        <br>
        Rad: {{ $errorLine }}<br>
        <br>
        Stacktrace:<br>
        <pre>
        {{ $errorStackTrace }}
        </pre>
    </body>
</html>
