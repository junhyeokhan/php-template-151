<?php
	include 'shared/header.html.php';
?>

<?php 
	if (isset($_SESSION["user"]))
	{
?>
	<h1>
		<?php 
			echo "Good ";
			$hour = getdate()["hours"];
			if ($hour > 5 && $hour < 12)
			{
				echo "morning ";
			}
			else if ($hour < 18)
			{
				echo "afternoon ";
			}
			else
			{
				echo "evening ";
			}
			
			if (isset($_SESSION["user"]["gender"]))
			{
				if ($_SESSION["user"]["gender"] == "Male")
				{
					echo "Mr. ";	
				}
				else if ($_SESSION["user"]["gender"] == "Female")
				{
					echo "Ms. ";
				}		
			}
			
			if (isset($_SESSION["user"]["lastName"]))
			{
				echo $_SESSION["user"]["lastName"];
			}
			
			echo "!";
		?>
	</h1>
	
	<a href=/budeget>Budget</a>
	<a href=/logout>Logout</a>

<?php 
	}
	else
	{
?>
		<h1>
			Welcome to Budget Knight!
		</h1>
		<p class="home-description">
			Budget Knight is an application, which will protect your budget!
			You can record your daily budget, and the Budget Knight will show you the statistics of the month.
			Log-in now to start planning and protecting your own budget!
		</p>
		<p>Is it first time? <a href="/register">Register</a> your new account!</p>
		<p>Do you already have an account? <a href="/login">Log-in</a> with your account!</p>
<?php 
	}
?>