<?php
	include 'shared/header.html.php';
?>
<h1>Reset Password</h1>
<h2></h2>
<p>Link for resetting password will be sent via an email.</p>

<form method="POST">
	<div>
		<label>Email: </label>
		<input type="email" name="email">
	</div>
	<div class="button">
		<input class="button-half" value="Send link" type="submit" name="submit">
	</div>
</form>
<?php
	include 'shared/footer.html.php';
?>