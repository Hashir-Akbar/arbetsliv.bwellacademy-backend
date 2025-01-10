<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            @if ($isMentor)
            Din mentor, {{ $mentor }}, 
            @else
            {{ $mentor }} 
            @endif
            har begärt att se din Bwell livsstilsplan.<br>
            På din profil kan de som har åtkomst se när du loggat in samt dina Bwell livsstilsplaner.
        </div>

        <div>
            Om du vill ge {{ $mentor }} åkomst, klicka på den här länken: {{ URL::to('user/accept', array($token)) }}
        </div>
    </body>
</html>
