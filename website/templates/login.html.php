<!DOCTYPE>
<html>
	<head>
		<title>Login form</title>
	</head>
	<body>
		<h1>Login</h1>
		<h2>
		<?php 
			if (isset($_SESSION["successMessage"]["register"]))
			{
				echo "Thank you for registering!";
			}
		?>
		</h2>
		<form method="POST">
			<label>
				Email:
				<input type="email" name="email">
			</label>
			<label>
				Password:
				<input type="password" name="password">
			</label>
			<input value="Login" type="submit" name="submit">
		</form>
	</body>
</html>