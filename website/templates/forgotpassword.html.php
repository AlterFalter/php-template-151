<h1>Forgot password</h1>

<form action="/forgotpassword" method="post">
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
			<td><button type="submit">Submit</button></td>
		</tr>
	</table>
</form>