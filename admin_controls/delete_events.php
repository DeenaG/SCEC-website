<?php
	/*This page is used to delete events*/
	
	//start session
    session_start();
	
	//if user is not logged in, redirect to login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
	
	//include database_variables.php to access session variables
	include("database_variables.php");
	
	//connect to the database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//check to see if the delete form was submitted
	if(isset ($_POST['submit'])){
		$id = $_POST['event']; 
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//select all rows from pictures table where the eventID column matches the id of the event being deleted
	$query = "SELECT * from pictures WHERE eventID = $id";
	
	//execute the query
	if($result = mysqli_query($db_selected, $query)){
		//loop through the images selected by the query
		while($row = mysqli_fetch_array($result))
  		{
  			//create the path to the image
  			$imagePath = "../".$row['imagePath'];
			
			//if the file exists, delete the picture from the server
			if(file_exists ( $imagePath )){
				$worked = unlink($imagePath);
			}
			//otherwise, set $worked to true so that the query can be executed below. Worked will only be false if the
			//file exists, but the unlink function above failed
			else{
				$worked = true;
			}
			
			//delete the rows from the pictures table database
			if($worked){
				$queryPictures = "DELETE FROM pictures WHERE eventID = $id";
				$success = $db_selected->query($queryPictures);
			}
			else{
				echo $db_selected->error;
			}
			
		}
  	
	}
	else{
		echo $db_selected->error;
	}
	
	//delete event from the event database
	$queryEvents = "DELETE FROM events WHERE id = $id";
	$success = $db_selected->query($queryEvents);
	
	//redirect back to the add/delete events page with success status used to display success message
	if($success){
			$loc = 'update_events.php';
			header("Location: $loc?status=success");
			die;
	}
	else{
		echo $db_selected->error;
	}
	
	//close the database
	mysqli_close($db_selected);
	
?>