<!doctype>
<html>
	<head>
	</head>
	<body>
		Login Site
		<form action="/login" method="post">
			<div>
				<label>Email:</label>
				<input type="text" name="email" value="<?= (isset($email) ? $email : "") ?>" />
			</div>
			<div>
				<label>Password:</label>
				<input type="text" name="password" />
			</div>
			<button type="submit">Submit</button>
		</form>
	</body>
</html>