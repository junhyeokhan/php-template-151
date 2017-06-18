<h1>Configuration</h1>
<h2>
	Configure your budget planner.
</h2>
<p>
	<?php 
		if (isset($_SESSION["errorMessage"]["configuration"]))
		{
			echo $_SESSION["errorMessage"]["configuration"];
		}
		else
		{
			echo "First thing first! Please configure your budget knight! This configuration could be changed again anytime.";
		}
	?>
</p>
<form method="POST">
	<fieldset>
		<legend>Configuration</legend>
		<label>
			Monthly budget: CHF 
		<input type="text" placeholder="00.00" value="<?php if (isset($monthlyBudget)) { echo $monthlyBudget; } ?>" name="monthlyBudget">
		</label>
		<label>
			Reset type:
		</label>
		<label for="resetTypeBeginMonth">Beginning of the month</label>
		<input type="radio" id="resetTyepBeginMonth" name="resetType" value="beginMonth" <?php if (isset($resetType)) { if ($resetType == 'beginMonth') { echo 'checked="checked"';}} ?>>
		
		<label for="resetTypeEndMonth">End of the month</label>
		<input type="radio" id="resetTypeEndMonth" name="resetType" value="endMonth" <?php if (isset($resetType)) { if ($resetType == 'endMonth') { echo 'checked="checked"';}} ?>>
		
		<label for="resetTypeUserDate">On certain day</label>
		<input type="radio" id="resetTypeUserDate" name="resetType" value="userDate" <?php if (isset($resetType)) { if ($resetType == 'userDate') { echo 'checked="checked"';}} ?>>
		<label>
			Day:
			<input type="number" <?php if (isset($resetType)) { if ($resetType != 'userDate') { echo 'disabled="disabled"';} }else { echo 'disabled="disabled"'; } ?> placeholder="1-28" name="resetDate" value="<?php if (isset($resetDate)) { echo $resetDate; } ?>" >
		</label>
	</fieldset>
	<input value="Save" type="submit" name="submit">
</form>
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