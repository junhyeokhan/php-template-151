<?php
	include 'shared/header.html.php';
?>
<h1>Register</h1>
<h2>
	<?php 
		if(isset($_SESSION["register"]["errorMessage"]))
		{
			echo $_SESSION["register"]["errorMessage"];
		}
	?>
</h2>
<form method="POST">
	<fieldset>
		<legend>Account information:</legend>
		<div>
			<label>Email: </label>
			<input type="email" name="email"> 
		</div>
		<div>
			<label>Password: </label>
			<input type="password" name="password">
		</div>
	</fieldset>
	<fieldset>
			<legend>Personal information</legend>
		<div>
			<label>First name: </label>
			<input type="text" name="firstName">
		</div>
		<div>
			<label>Last name: </label>
			<input type="text" name="lastName">
		</div>
		<div>
			<label>Gender: </label>
		</div>
		<div class="radio">
			<label for="genderMale">Male</label> 
			<input type="radio" id="genderMale" name="gender" value="Male">
		</div>
		<div class="radio">
			<label for="genderMale">Female</label> 
			<input type="radio" id="genderFemale" name="gender" value="Female">
		</div>
		<div>
			<label>Date of birth: </label> 
			<input type="date" name="dateOfBirth">
		</div>
	</fieldset>
	<div class="button-fieldset">
		<input value="Submit" type="submit" name="submit">
	</div>
</form>
<?php
	include 'shared/footer.html.php';
?>