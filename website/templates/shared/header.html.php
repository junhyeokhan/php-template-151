<html>
<head>
<title>Budget Knight</title>
<link rel="stylesheet" href="css/frame.css" />
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
	
</head>
<body>
	<div class="header">
		<img class="logo" alt="Home" src="/image/logo.png">
	</div>
	<div class="navigation">
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/budget">Budget</a></li>
			<li><a href="/configuration">Configuration</a></li>
			  <?php
					if (isset ( $_SESSION ["user"] )) {
						?>
	  				<li style="float: right;"><a href="/logout">Logout</a><li>
			  <?php
					} else {
						?>
			<li style="float: right;"><a href="/register">Register</a><li>
			<li style="float: right;"><a href="/login">Login</a><li>
				  <?php
					}
					?>
		</ul>
	</div>
	<div class="content">