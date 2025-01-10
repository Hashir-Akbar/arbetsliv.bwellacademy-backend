<!DOCTYPE html>
<html lang="sv">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Återställ lösenord</h2>
		<p>
			För att återställa ditt lösenord, gå till den här länken:<br>
			<a href="{{ URL::to('password/reset?' . $queryString) }}">{{ URL::to('password/reset?' . $queryString) }}</a>
		</p>
	</body>
</html>
