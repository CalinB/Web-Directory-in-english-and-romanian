<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('auth.password_reset') }}</h2>

		<div>
			{{ trans('auth.password_reset_form') }} {{ URL::route('password-reset', [$token]) }}.<br/>
			{{ Lang::get('auth.password_reset_expiration', ['exp' => Config::get('auth.reminder.expire', 60)]) }}.
		</div>
	</body>
</html>
