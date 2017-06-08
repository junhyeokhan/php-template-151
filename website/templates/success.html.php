<h1>
<?php
if (isset($_SESSION["successMessage"]["register"]))
{
	echo $_SESSION["successMessage"]["register"];
}
?>
</h1>
<div>
	<?php 
		if (isset($_SESSION["successMessage"]["register"]))
		{
	?>
		<p>To <a href="/login">Login</a> page</p>
		<p>To <a href="/">Home</a> page</p>
	<?php 
		}
	?>
</div>