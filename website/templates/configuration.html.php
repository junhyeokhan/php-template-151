 <?php
	include 'shared/header.html.php';
?>
<h1>Configuration</h1>
<p class="error">
	<?php 
		if (isset($_SESSION["configuration"]["error"]))
		{
			echo $_SESSION["configuration"]["error"];
		}
	?>
</p>
<form method="POST">
	<fieldset>
		<legend>Configuration</legend>
		<div>
			<label>Monthly budget: </label>
			<input type="text" placeholder="00.00" value="<?php if (isset($monthlyBudget)) { echo $monthlyBudget; } ?>" name="monthlyBudget">
		</div>
		<div>
			<label>Reset type:</label>
		</div>
		<div class="radio">
			<label for="resetTypeBeginMonth">Beginning of the month</label>
			<input type="radio" id="resetTyepBeginMonth" name="resetType" value="beginMonth" <?php if (isset($resetType)) { if ($resetType == 'beginMonth') { echo 'checked="checked"';}} ?>>
		</div>
		<div class="radio">
			<label for="resetTypeEndMonth">End of the month</label>
			<input type="radio" id="resetTypeEndMonth" name="resetType" value="endMonth" <?php if (isset($resetType)) { if ($resetType == 'endMonth') { echo 'checked="checked"';}} ?>>
		</div>
		<div class="radio">
			<label for="resetTypeUserDate">On certain day</label>
			<input type="radio" id="resetTypeUserDate" name="resetType" value="userDate" <?php if (isset($resetType)) { if ($resetType == 'userDate') { echo 'checked="checked"';}} ?>>
		</div>
		<div>
			<label>Day:</label>
			<input type="number" <?php if (isset($resetType)) { if ($resetType != 'userDate') { echo 'disabled="disabled"';} }else { echo 'disabled="disabled"'; } ?> placeholder="1-28" name="resetDate" value="<?php if (isset($resetDate)) { echo $resetDate; } ?>" >
		</div>
	</fieldset>
	<input class="button-fieldset" value="Save" type="submit" name="submit">
</form>
<div class="button-fieldset">
	<a href="/deleteaccount">Delete account?</a>
</div>
<script>
	var rad = document.getElementsByName('resetType');
	for(var i = 0; i < rad.length; i++) {
	    rad[i].onclick = function() {
		    if (this.checked == true)
		    {
		    	var inputDate = document.getElementsByName('resetDate');
		    	inputDate[0].disabled = this.value != "userDate";
		    }
	    };
	}
</script>
<?php 
	include 'shared/footer.html.php';
?>