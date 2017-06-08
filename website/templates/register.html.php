<!DOCTYPE>
<html>
	<head>
		<title>Register</title>
	</head>
	<body>
		<h1>Register</h1>
		<form method="POST">
			<fieldset>
    			<legend>Account information:</legend>
				<label>
					Email:
					<input type="email" name="email">
				</label>
				<label>
					Password:
					<input type="password" name="password">
				</label>
			</fieldset>
			<fieldset>
				<legend>Personal information</legend>
				<label>
					First name:
				<input type="text" name="firstName">
				</label>
				<label>
					Last name:
					<input type="text" name="lastName">
				</label>
				<label>
					Gender:
					<label for="genderMale"> Male</label>
					<input type="radio" id="genderMale" name="gender" value="Male">
					<label for="genderFemale"> Female</label>
					<input type="radio" id="genderFemale" name="gender" value="Female">
				</label>
				<label>
					Date of birth:
					<input type="date" name="dateOfBirth">
				</label>
			</fieldset>
			
			<input value="Submit" type="submit" name="submit">
		</form>
	</body>
</html>