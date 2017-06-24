<h1>Login</h1>

<form action="/login" method="post">
	<?php echo $token; ?>
	<div class="errorMessage">
		<?= (isset($errorMessage) ? $errorMessage : "") ?>
	</div>
	<table>
		<tr>
			<td><label>Email:</label></td>
			<td><input type="text" name="email" value="<?= (isset($email) ? $email : "") ?>" /></td>
		</tr>
		<tr>
			<td><label>Password:</label></td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td><button type="submit">Submit</button></td>
			<td></td>
		</tr>
	</table>
</form>

<div>Forgot your password?</div>
<button onclick="siteGET('/forgotpassword');">Set new password</button>
<div>Do you have no account?<div>
<button onclick="siteGET('/register');">Register here</button>
