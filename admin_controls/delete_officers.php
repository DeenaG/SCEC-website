<?php
	/*This page will be used to delete officers from the database*/
	
	//start the session to access session variables
    session_start();
	
	//if the user is not logged in, redirect users to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
	
	//include databases_variables.php to access session variables
	include("database_variables.php");
	//connect to the database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//check to see if the delete officers form has been submitted
	if(isset ($_POST['submit'])){
		$id = $_POST['officer'];
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//select the image path of the image to be deleted
	$query = "SELECT imagePath from officers WHERE ID = $id";
	//execute query
	if ($result = mysqli_query($db_selected, $query)){
		$row = mysqli_fetch_assoc($result);
		$imagePath = "../".$row['imagePath'];
	}
	else{
		echo $db_selected->error;
	}
	
	//if the file exists in the server, delete the file from the server
	if(file_exists ( $imagePath )){
		$worked = unlink($imagePath);
	}
	//otherwise, set $worked to true to execute the query below
	else{
		$worked = true;
	}
	
	//delete the row from the officers table in the database
	if($worked){
		$query = "DELETE FROM officers WHERE ".$id."=ID";
	
		$success = $db_selected->query($query);
		
		//redirect to the add/delete officers page
		if($success){
			$loc = 'update_officers.php';
			header("Location: $loc?status=success");
			die;
		}
		else{
			echo $db_selected->error;
		}
	}
	else 
		echo "can't find picture";
	
	//close database connection
	mysqli_close($db_selected);
	
	
?>