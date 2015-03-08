<!DOCTYPE html>
<!--This page is used to hash the password that is stored in the database-->
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>
	<form name="login" action="password_hash.php" method="post">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" title="Enter Password" required>
			<br>
			<input name="submit" type="submit" value="Submit" id="button">
		</form>	
</body> 

<?php
	$username = 'drubin'; //username for database
	$password = ''; //password for database
	$hostname = 'localhost'; //host
	$db_name =  'test'; //name of database
	
	$db_selected = mysqli_connect($hostname, $username, $password, $db_name)//specify database
	or die ("unable to connect");
	
	if(isset ($_POST['submit'])){
		$password = ($_POST['password']);
		echo($password);
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	$salt = uniqid(mt_rand(), true);
	$hash = crypt($password, $salt);

	echo($hash);
	$query = "UPDATE user SET password='$hash' WHERE user='scec'";
	
	$success = $db_selected->query($query);
	
	if($success){
		echo('YAY');
	}
	else{
		echo $db_selected->error;
	}


?>