<?php
	include 'shared/header.html.php';
?>
<h1>Reset Password</h1>
<h2></h2>
<p>Enter your new password.</p>

<form method="POST">
	<input class="hidden" name="email" value="<?php echo $email; ?>" />
	<input class="hidden" name="key" value="<?php echo $key; ?>" />
	<div>
		<label>Password: </label>
		<input type="password" name="password">
	</div>
	<div class="button">
		<input class="button-half" value="Save password" type="submit" name="submit">
	</div>
</form>
<?php
	include 'shared/footer.html.php';
?>