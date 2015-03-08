<?php
	/*this page will process the login form*/
	
	//start session to access session variables
	session_start();
	
	//include database_variables to access the session variables stored there
    include("database_variables.php");
    
	//connect to the database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//check to see if the login form was submitted
	if(isset ($_POST['submit'])){
		$password = ($_POST['password']);
		$userName = ($_POST['username']);
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//select the password from the user table where the username matches the username entered by the user
	$query = "select password from user where user = '$userName'";
	
	if($result = mysqli_query($db_selected, $query)){
		$row = mysqli_fetch_assoc($result);
		//$hash will store the password from the query result
		$hash = $row["password"];
	}
	else{
		echo $db_selected->error;
	}
		
	//crypt method matches the password entered by the user to the hashed passwordd stored in the database
	if (crypt($password, $hash)==$hash) {
		//if the passwords match, a session variable called "loggedin" is set to true. Each page will check to see 
		//if the user is logged in before granting access to the page
    	$_SESSION['loggedin'] = 'yes';
		//redirect to the admin navigation page
		$loc = 'admin_navigation.php';
		header("Location: $loc");
		exit;
	}
	else {
		//if the passwords do not match, redirect back to the login page with a status to indicate that the wrong
		//username and/or password have been entered
    	$loc = 'admin_login.php';
		header("Location: $loc?status=password");
		die;
	}
	//close the database
	mysqli_close($db_selected);
	
	
	
?>