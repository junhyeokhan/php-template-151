<?php
	include 'shared/header.html.php';
	
	if (isset($_SESSION["user"])) {
?>
<h1>
	<?php
		$hour = getdate()["hours"];
		echo "Good "; 
		if ($hour > 5 && $hour < 12) {
			echo "morning ";
		} else if ($hour < 18) {
			echo "afternoon ";
		} else {
			echo "evening ";
		}

		if (isset($_SESSION["user"]["gender"])) {
			if ($_SESSION["user"]["gender"] == "Male") {
				echo "Mr. ";
			} else if ($_SESSION["user"]["gender"] == "Female") {
				echo "Ms. ";
			}
		}
	
		if (isset($_SESSION["user"]["lastName"])) {
			echo $_SESSION ["user"]["lastName"];
		}
		echo "!";
	?>
</h1>

<h2>Monthly statistics</h2>
<div class="chart-block">
<h3>Amount</h3>
<div class="chart-legend">
	<span><i class="fa fa-square" style="color:#333333"></i>Used</span>
	<span><i class="fa fa-square" style="color:#FFFFFF"></i>Available</span>
	<span><i class="fa fa-square" style="color:#FF0000"></i>Exceeded</span>
</div>
<canvas id="monthlyAmountChart" width="400" height="400"></canvas>
	<script type="text/javascript">
		var monthlyAmountCtx = document.getElementById("monthlyAmountChart").getContext("2d");
		var data = [{
        	value: <?php echo $monthly['used'] ?>,
			color:"#333333",
			highlight: "#262626",
			label: "Used"
		},
    	{
	        value: <?php echo $monthly['free'] ?>,
	        color: "#FFFFFF",
	        highlight: "#f2f2f2",
	        label: "Available"
	    },
	    {
	        value: <?php echo $monthly['over'] ?>,
	        color: "#FF0000",
	        highlight: "#e60000",
	        label: "Exceeded"
	    }];
	    var options = {
	      animateScale: true,
	    };
	    var monthlyAmountChart = new Chart(monthlyAmountCtx).Pie(data,options);
  	</script>
</div>

<div class="chart-block">
<h3>Category</h3>
<div class="chart-legend">
<?php 
	$dummyColors = array("66ccff", "cc99ff", "ff99cc", "ffcc99", "ccff99", "99ffcc");
	$keys = array_keys($categories);
	
	for ($j = 0; $j < count($keys); $j ++)
	{
		echo "<span><i class=\"fa fa-square\" style=\"color:#$dummyColors[$j]\"></i>$keys[$j]</span>";
	}
?>
</div>
<canvas id="monthlyCategoryChart" width="400" height="400"></canvas>
	<script type="text/javascript">
		var monthlyCategoryCtx = document.getElementById("monthlyCategoryChart").getContext("2d");
		var data = [
			<?php 				
				for ($i = 0; $i < count($keys); $i++) {
					$key = $keys[$i];
					echo "{";
					echo "value: $categories[$key],";
					echo "color:\"#$dummyColors[$i]\",";
					echo "highlight:\"#$dummyColors[$i]\",";
					echo "label:\"$keys[$i]\",";
					echo "},";
				}
			?>
			];
	    var options = {
	      animateScale: true
	    };
	    var monthlyCategoryChart = new Chart(monthlyCategoryCtx).Pie(data,options);
  	</script>
</div>
<div class="clear"></div>
<?php
	} else {
?>
<h1>Welcome to Budget Knight!</h1>
<p class="home-description">Budget Knight is an application, which will
	protect your budget! You can record your daily budget, and the Budget
	Knight will show you the statistics of the month. Log-in now to start
	planning and protecting your own budget!</p>
<p>
	Is it first time? <a href="/register">Register</a> your new account!
</p>
<p>
	Do you already have an account? <a href="/login">Log-in</a> with your
	account!
</p>
<?php
}
include 'shared/footer.html.php';
?>