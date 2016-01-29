<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>
	<body>
		
		<h1>{{ trans('auth.welcome') }}</h1>
		
		<p>{{ $body_message }}</p>
		{{ URL::route('verify-register', [$confirmation_code]) }}<br/>
	</body>
</html>