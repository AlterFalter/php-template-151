<h1>Set new password</h1>

<form action="/setpassword" method="post">
    <?php echo $token; ?>
    <div class="errorMessage">
        <?= (isset($errorMessage) ? $errorMessage : "") ?>
		<input type="hidden" name="guid" value="<?php echo $guid ?>" />
		<input type="hidden" name="userId" value="<?php echo $userId ?>" />
	</div>
	<table>
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