<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Välkommen, {{ $name }}!</h2>

        <div>
            För att skapa ett lösenord till din Bwell inloggning, fyll i det här formuläret:
            <a href="{{ URL::to('complete?' . $queryString) }}">{{ URL::to('complete?' . $queryString) }}</a>
        </div>
    </body>
</html>
