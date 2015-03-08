<?php
	/*This page will process the add minutes form*/
	
	//start the session to access session variables
	session_start();
	
	//if the user is not logged in, redirect to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
	
	//this class adds timestamp functionality that is available in later versions of php
	class MyDateTime extends DateTime
	{
    	public function setTimestamp( $timestamp )
    	{
        	$date = getdate( ( int ) $timestamp );
        	$this->setDate( $date['year'] , $date['mon'] , $date['mday'] );
        	$this->setTime( $date['hours'] , $date['minutes'] , $date['seconds'] );
    	}

    	public function getTimestamp()
    	{
        	return $this->format( 'U' );
    	}
	}
	
	//include database_variables.php to access the session variables stored there
	include("database_variables.php");
	
	//connect to the database
    $db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
	or die ("unable to connect");
	
	//check to see if the add minutes form was submitted
	if(isset ($_POST['submit'])){
		//create an date object using class defined above
		$date = new MyDateTime($_POST['datepicker'], timezone_open('America/Chicago'));
		//create the timestamp to store in the database
		$dateTimeStamp = $date->getTimeStamp();
		
		//$filename will hold the name of uploaded file
		$fileName = $_FILES['file']['tmp_name'];
		
		//if the uploaded file is the wrong file type, redirect back to the login page with a status to indicate error message to display
		if($_FILES['file']['type'] != "application/pdf" ) {
				$loc = 'update_minutes.php';
				header("Location: $loc?status=badFile");
				die;
		}
		//if the uploaded file is too large, redirect back to the login page with a status to indicate error message to display
		if ($_FILES['file']['size']>1572864){
			$loc = 'update_minutes.php';
			header("Location: $loc?status=badFile");
			die;
		}
		
		//replace whitespace in the name of the file
		$name = $_FILES['file']['name'];
		$name = str_replace(" ","_", $name);
		
		//$filepath will be stored in the database
		$filePath = 'documents/'.$name;
		//$path will be used as the directory to upload the file
		$path = $_SESSION['documentsPath'].$name;
		//upload the file
		$uploadSuccess = move_uploaded_file($fileName, $path);
	}
	else{
		echo'<p>not submitted</p>';
	}
	
	//if the file was uploaded successfully, insert the new minutes into the database
	if($uploadSuccess){
		//insert the the timestamp and filepath into the minutes table in teh database
		$query = ("INSERT INTO minutes(date, filePath) VALUES ($dateTimeStamp, '$filePath')");
		
		$success = $db_selected->query($query);
		
		//redirect to the add/delete page with a status to indicate success message should be displyed
		if($success){
			$loc = 'update_minutes.php';
			header("Location: $loc?status=success");
			die;
		}
		else{
			echo $db_selected->error;
		}	
	}
	//close database
	mysqli_close($db_selected);
	

?>