<?php
	include 'shared/header.html.php';
?>
<h1>Login</h1>
<p class="error">
	<?php 
		if(isset($_SESSION["login"]["error"]))
		{
			echo $_SESSION["login"]["error"];
		}
	?>
<p>
<form method="POST">
	<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
	<div>
		<label>Email: </label>
		<input type="email" name="email" value="<?php if (isset($email)) { echo $email; } ?>" >
	</div>
	<div>
		<label>Password: </label>
		<input type="password" name="password" value="<?php if (isset($password)) { echo $password; } ?>" >
	</div>
	<div class="button">
		<input value="Login" type="submit" name="submit">
	</div>
	<div class="button">
		<a href="/forgotpassword">Forgot Password?</a>
	</div>
</form>
<?php
	include 'shared/footer.html.php';
?>