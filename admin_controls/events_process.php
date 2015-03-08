<?php
	/*This page is used to add an officer to the database*/
	
	//start session to access session variables
	session_start();
	
	//if user is not logged in, redirect to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
	
	//include database_variables.php to access session variables
	include("database_variables.php");
	
	//connect to the database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//this variable will become false if any of the image uploads fails
	$imageUploadSuccess = true;
	
	//check to see if the add events form was submitted
	if(isset ($_POST['submit'])){
		//create an array to store the image
		$imagePathArray = array();
		
		//store the title of the event
		$title = $_POST['title'];
		
		//store the description of the event
		$description = $_POST['description'];
		
		//a total of five images are allowed. in this loop, we check which form uploads were used
		for($i=0; $i<5; $i++){
			//in the form, the id's and names of the images are all set to image0 - image4. To access these images, 
			//a variable called $inputField is set to 'image' is concatenated with the current value of i to match the id and name. 
			//This will be used in the $_FILE array to access each image
			//in this loop, each image that the user entered will be uploaded to the server
			$inputField = 'image'.$i;
			
			//if the file was uploaded in thi form field
			if(file_exists($_FILES[$inputField]['tmp_name']) || is_uploaded_file($_FILES[$inputField]['tmp_name'])) {
				//create the filename
				$fileName = $_FILES[$inputField]['tmp_name'];
				
				//check to see if the wrong file type is used
				if($_FILES[$inputField]['type'] != "image/jpeg" 
					&& $_FILES[$inputField]['type'] != "image/jpg"
					&& $_FILES[$inputField]['type'] != "image/png"
					&& $_FILES[$inputField]['type'] != "image/gif") {
						//if the wrong file type is uploaded, redirect back to the add events page with a 
						//status that will indicate an error message to display
						$loc = 'update_events.php';
						header("Location: $loc?status=badImage");
						die;
				}
				//check to see if the file size is too large
				if ($_FILES[$inputField]['size']>1048576){
					//if the file size is too large, redirect back to the add events page with a 
					//status that will indicate an error message to display
					$loc = 'update_events.php';
					header("Location: $loc?status=badImage");
					die;
				}
				
				//replace whitespace in the name of the file
				$name = $_FILES[$inputField]['name'];
				$name = str_replace(" ","_", $name);
				
				//create the name of imagepath that will be stored in the database
				$imagePath = 'images/'.$name;
				
				//store that imagepath in the array
				$imagePathArray[$i] = $imagePath;
				
				//create the imagepath that will be used to upload the image to the appropriate folder.
				//The session variable defined in database_variables.php is concatenated with the name of the file
				$path = $_SESSION['imagesPath'].$name;
				
				//upload the image
				$imageUploadSuccess = move_uploaded_file($fileName, $path);
			}
		}
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//if all of the images were uploaded successfully, insert the event into the database
	if($imageUploadSuccess){
		//query to insert the title and description to the events page
		$query = ("INSERT INTO events (title, description) VALUES ('$title', '$description')");
		//execute the query
		$success = $db_selected->query($query);
		
		//if the query was successful
		if($success){
			//select the id that was automatically created when the event was inserted into the database
			$query=("SELECT id FROM events WHERE title = '$title' and description = '$description'");
			$result = mysqli_query($db_selected, $query);
			$row = mysqli_fetch_assoc($result);
			
			//temp id (which is the primary key of the events table) will become the foreign key of the pictures table
			$tempID = $row['id'];
			
			//loop through the array containing the image paths to store each image path in the pictures array
			for($i=0; $i<count($imagePathArray); $i++){
				$imageFromArray = $imagePathArray[$i];
				//store the image path and the eventID in the pictures table
				$query = ("INSERT INTO pictures (eventID, imagePath) VALUES ($tempID, '$imageFromArray')");
				$success = $db_selected->query($query);
				if(!$success)
					echo $db_selected->error;
			}
		}
		else{
			echo $db_selected->error;
		}	
		
		//if the uploads and database insert were successful, redirect back to the add/delete events page with a status of success to display success message
		if($success){
			$loc = 'update_events.php';
			header("Location: $loc?status=success");
			exit;
		}
	}
	//close the database connection
	mysqli_close($db_selected);
	
?>
