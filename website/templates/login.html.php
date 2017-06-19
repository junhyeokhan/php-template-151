<?php
	include 'shared/header.html.php';
?>
<h1>Login</h1>
<h2>
	<?php
		if (isset($_SESSION["register"]["success"])) {
			echo $_SESSION["register"]["success"];
		}	
	?>
</h2>
<form method="POST">
	<div>
		<label>Email: </label>
		<input type="email" name="email">
	</div>
	<div>
		<label>Password: </label>
		<input type="password" name="password">
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