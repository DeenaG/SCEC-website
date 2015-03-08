<?php
	/*this page will process the add officers form*/
	
	//start session to access session variables
	session_start();
	
	//if user is not logged in, redirect back to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
	
	//include database_variables.php to access the session variables stored there
	include("database_variables.php");
	
	//connect to the database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//check to see if the add officers form was submitted
	if(isset ($_POST['submit'])){
		//set variables to the values submitted in the form
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$position = $_POST['position'];
		$description = $_POST['description'];
		
		//$filename store the name of the file submitted with the form
		$fileName = $_FILES['image']['tmp_name'];
		
		//if the file is not one of the permitted filetypes redirect back to the add/delete officers page with a status
		//indicating error message to display
		if($_FILES['image']['type'] != "image/jpeg" 
			&& $_FILES['image']['type'] != "image/jpg"
			&& $_FILES['image']['type'] != "image/png"
			&& $_FILES['image']['type'] != "image/gif") {
				$loc = 'update_officers.php';
				header("Location: $loc?status=badImage");
				die;
		}
		//if the file size is too large, redirect back to the add/delete officers page with a status indicating error message to display
		if ($_FILES['image']['size']>819200){
			$loc = 'update_officers.php';
			header("Location: $loc?status=badImage");
			die;
		}
		
		//replace whitespace in the name of the file
		$name = $_FILES['image']['name'];
		$name = str_replace(" ","_", $name);
		
		//$imagePath stores the path that will be stored in the database
		$imagePath = 'images/'.$name;
		//$path stores the path where the image will be uploaded onto the server
		$path = $_SESSION['imagesPath'].$name;
		
		//upload the file to the server
		$uploadSuccess = move_uploaded_file($fileName, $path);
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//if the file was uploaded successfully, insert new officer into database
	if($uploadSuccess){
		//insert the form data into the database
		$query = ("INSERT INTO officers (firstName, lastName, position, description, imagePath) VALUES ('$firstName', '$lastName', '$position', '$description', '$imagePath')");
		//execute query
		$success = $db_selected->query($query);
		
		//redirect back to the add/delete officers page with status to indicate success message to display
		if($success){
			$loc = 'update_officers.php';
			header("Location: $loc?status=success");
			die;
		}
		else{
			echo $db_selected->error;
		}	
	}
	//close the database connection
	mysqli_close($db_selected);
	
?>