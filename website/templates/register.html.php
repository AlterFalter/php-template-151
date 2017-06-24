<h1>Register</h1>

<form action="/register" method="post">
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
			<td><label>Firstname:</label></td>
			<td><input type="text" name="firstname" value="<?= (isset($firstname) ? $firstname : "") ?>" /></td>
		</tr>
		<tr>
			<td><label>Surname:</label></td>
			<td><input type="text" name="surname" value="<?= (isset($surname) ? $surname : "") ?>" /></td>
		</tr>
		<tr>
			<td><label>Password:</label></td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td><label>Confirm password:</label></td>
			<td><input type="password" name="password2" /></td>
		</tr>
		<tr>
			<td><button type="submit">Submit</button></td>
		</tr>
	</table>
</form>

<div>Have you already an account?<div>
<button onclick="siteGET('/login');">Login here</button>

