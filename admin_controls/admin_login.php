<!DOCTYPE html>
<!-- login page for the admin controls-->
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<link rel="shortcut icon" href="../images/favicon.ico">
	<link rel="stylesheet" href="styles/admin_style.css">
	
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
	
</head>
<body>
	<header>
		<h1>Admin Login</h1>
	</header>
	<!--log in form-->
	<form name="login" action="login_process.php" method="post">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" title="Enter Username" autofocus required>
		<br>
		<label for="password">Password</label>
		<input type="password" name="password" id="password" title="Enter Password" required>
		<br>
		<label for="button">&nbsp;</label>
		<input name="submit" type="submit" value="login" id="button">
	</form>
	
	<!-- Display password/username error message if the login_process.php redirected here with an error -->
	<?php
		if (array_key_exists('status', $_GET)) {
			if ($_GET['status'] == 'password')
   			echo '<p class="warning">Incorrect username or password. Please try again<p>';
		}
	?>
	<footer>
		<nav><a href="../index.php">return to homepage</a></nav>
	</footer>
</body> 
</html>






