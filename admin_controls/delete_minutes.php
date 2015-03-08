<?php
	/*This page is used to delete minutes from the database*/
	
	//start the session to access session variables
    session_start();
	
	//if the user is not logged in, redirect to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
    
	//include database_variables.php to access session variables
	include("database_variables.php");
	
	//connect to database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//check to see if the delete minutes form was submitted
	if(isset ($_POST['submit'])){
		$id = $_POST['minutes'];
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//select the filepath column from the minutes table that match the minutes to be deleted
	$query = "SELECT filePath from minutes WHERE ID = $id";
	//execute query
	if ($result = mysqli_query($db_selected, $query)){
		$row = mysqli_fetch_assoc($result);
		$filePath = "../".$row['filePath'];
	}
	else{
		echo $db_selected->error;
	}
	
	//if the file exists, delete the file from the server
	if(file_exists ( $filePath )){
		$worked = unlink($filePath);
	}
	//otherwise, set $worked to true to execute the query below
	else	
		$worked = true;
	
	//delete the row from the minutes table
	if($worked){
		$query = "DELETE FROM minutes WHERE ".$id."=ID";
	
		$success = $db_selected->query($query);
		
		//redirect back to the add/delete minutes page
		if($success){
			$loc = 'update_minutes.php';
			header("Location: $loc?status=success");
			die;
		}
		else{
			echo $db_selected->error;
		}
	}
	else 
		echo "can't find file";
	
	//close the database	
	mysqli_close($db_selected);
	
	
?>