<?php
	//start the session to access session variables
    session_start();
	
	//if the user is not logged in, redirect to the login page
	if($_SESSION['loggedin']==false){
		$loc = 'admin_login.php';
		header("Location: $loc");
		die;
	}
	//destroy the session
	session_destroy();
?>
<!DOCTYPE html>
<!-- displays information after the admin has logged out -->
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<link rel="shortcut icon" href="../images/favicon.ico">
	<link rel="stylesheet" href="styles/admin_style.css">
	<link rel="stylesheet" href="styles/logout_style.css">
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
	<header>
		<h1>Logout Successful!</h1>
	</header>
	<section>
		<p >From here you can...</p>
		<p><a href='admin_login.php'>Click here </a> to log in again</p>
		<p><a href='../index.php'>Click here </a> For the homepage</p>
	</section>
</body>

	
