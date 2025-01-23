<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Välkommen, {{ $name }}!</h2>
        <p>
            För att logga in behöver du skapa ett lösenord.<br><br>
            <strong>Skapa lösenord:</strong> <a href="{{ URL::to('complete?' . $queryString) }}">{{ URL::to('complete?' . $queryString) }}</a>
        </p>
        <p>
            Har du några frågor eller funderingar, hör av dig!
        </p>
        <hr style="width: 325px; float: left">
        <p style="clear: left">
            Acki Wästlund<br>
            Bewell Academy AB<br>
            VD, grundare<br>
            acki@bwellacademy.com<br>
            0708 280918<br>
        </p>
    </body>
</html>