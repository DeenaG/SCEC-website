<?php
	//start session to access session variables
    session_start(); 
	//if the pages is accessed when the user is not logged in, redirect to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
?>
<!DOCTYPE html>
<!-- navigation page for the admin controls -->
<html lang="en-us">
	<head>
		<meta charset="UTF-8">
		<title>Admin Navigation</title>
		<link rel="shortcut icon" href="../images/favicon.ico">
		<link rel="stylesheet" href="styles/admin_style.css">
		<link rel="stylesheet" href="styles/navigation_style.css">
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<header>
			<h1>Admin Navigation</h1>
		</header>
		<section>
			<p>Select a page to update</p>
			<!-- navigation link to the three admin tools -->
			<nav>
				<a href="update_officers.php">officers</a>
				<a href="update_minutes.php">minutes</a>
				<a href="update_events.php" class>events</a>
			</nav>
		</section>
		<footer>
			<!-- logout -->
			<form name = "done" action="logout.php" method=post>
				<input name="logout" type="submit" value="logout" id="logout">
			</form>
			<a href="../index.php">return to homepage</a>
		</footer>
	</body>
</html>