<?php
	include 'shared/header.html.php';
?>
<h1>Delete account</h1>
<h2></h2>
<p class="error">
	<?php 
		if (isset($_SESSION["deleteaccount"]["error"]))
		{
			echo $_SESSION["deleteaccount"]["error"];
		}
	?>
</p>

<form method="POST" id="form">
	<div>
		<label>Password: </label>
		<input type="password" name="password">
	</div>
</form>
<div class="button">
	<button class="button-half" onclick="confirmDeletion()">Delete acccount</button>
</div>
<script>
	function confirmDeletion() {
	    var dialog = confirm("All your data will be deleted. Do you really want to delete your account?");
	    if (dialog == true) {
			alert("Thank you for using Budget Knight! Good bye!");
			setTimeout("submitForm()");
	    }
	}

	function submitForm() {	
		var form = document.getElementById("form");
		form.submit();
	}
</script>
<?php
	include 'shared/footer.html.php';
?>