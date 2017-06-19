<?php
	include 'shared/header.html.php';
?>
<h1>Register</h1>
<p class="error">
	<?php 
		if(isset($_SESSION["register"]["error"]))
		{
			echo $_SESSION["register"]["error"];
		}
	?>
</p>
<form method="POST">
	<input type="hidden" name="csrf" value="<?= $_SESSION["register"]["csrf"]; ?>" />
	<fieldset>
		<legend>Account information:</legend>
		<div>
			<label>Email: </label>
			<input type="email" name="email" value="<?php if (isset($email)) { echo $email; } ?>"> 
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
			<input type="text" name="firstName" value="<?php if (isset($firstName)) { echo $firstName; } ?>" >
		</div>
		<div>
			<label>Last name: </label>
			<input type="text" name="lastName" value="<?php if (isset($lastName)) { echo $lastName; } ?>" >
		</div>
		<div>
			<label>Gender: </label>
		</div>
		<div class="radio">
			<label for="genderMale">Male</label> 
			<input type="radio" id="genderMale" name="gender" value="Male" <?php if (isset($gender)) { if ($gender == 'Male') { echo 'checked="checked"';}} ?> >
		</div>
		<div class="radio">
			<label for="genderMale">Female</label> 
			<input type="radio" id="genderFemale" name="gender" value="Female" <?php if (isset($gender)) { if ($gender == 'Female') { echo 'checked="checked"';}} ?>>
		</div>
		<div>
			<label>Date of birth: </label> 
			<input type="date" name="dateOfBirth" value="<?php if (isset($dateOfBirth)) { echo $dateOfBirth; } ?>" >
		</div>
	</fieldset>
	<div class="button-fieldset">
		<input value="Submit" type="submit" name="submit">
	</div>
</form>
<?php
	include 'shared/footer.html.php';
?>