<?php
	//start session to access session variables
    session_start(); 
	
	//if the user is not logged in redirect to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="UTF-8">
		<title>Events</title>
		<link rel="shortcut icon" href="../images/favicon.ico">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<!--jquery function creates tabs for adding and deleting evetns-->
		<script>
			$(function() {
			$( "#tabs" ).tabs();
		});
		</script>
		<link rel="stylesheet" href="styles/admin_style.css">
		<link rel="stylesheet" href="styles/update_style.css">
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div id="tabs">
			<!-- if the user was redirected to this page from the events_process or delete_events page after successfully adding or 
				deleting an event, display success message -->
			<?php
				if (array_key_exists('status', $_GET)) {
					if ($_GET['status'] == 'success')
	   					echo'<p class="success">Action completed successfully!</p>';
				}
			?>
			
			<header>
				<h1>Admin Control for Events</h1>
			</header>
			<nav>
			 	<ul>
			 		<!-- two tabs for adding and deleting -->
					<li><a href="#add">Add Event</a></li>
					<li><a href="#delete">Delete Event</a></li>
				</ul>
			</nav>
			<section>
				<!-- add event tab-->
				<div id="add">
					<!-- directions for adding an event -->
					<p class="directions">To add an event, fill out the following form</p>
					<p>Please Note:</p>
					<ul>
						<li><p>Accepted file types for upload: .jpeg, .jpg, .png, .gif</p>
						<li><p><strong>Accepted file size for upload: 1mb,</strong> however uploading images with smaller file sizes is recommended to prevent slow page loading</p></li>
						<li><p>Images of any proportions will be accepted by the form. However, the page will look best if all images are the same size and proportions</p></li>
						<li><p>At least two images are required. Up to 5 images are allowed</p></li>
						<li><p>Do not upload multiple files with the same file name</p></li>
						<li><p>Description limited to 5000 characters</p></li>
					</ul>
					<!-- form to add an event -->
					<form name="events" action="events_process.php" method="post" enctype="multipart/form-data">
						<label for="title">Title:</label>
						<input type="text" name="title" id="title" required  autofocus>
						<br>
						<label for="description">Description</label>
						<textarea name="description" id="description" required pattern ="{1, 5000}" title="limit to 5000 characters"></textarea>
						<br>
						<!-- two of the five image uploads are allowed -->
						<label for="image0">Image Upload</label>
						<input type="file" name="image0" id="image0" required title="image required">
						<br>
						<label for="image1">Image Upload</label>
						<input type="file" name="image1" id="image1" required title="image required">
						<br>
						<label for="image2">Image Upload</label>
						<input type="file" name="image2" id="image2">
						<br>
						<label for="image3">Image Upload</label>
						<input type="file" name="image3" id="image3">
						<br>
						<label for="image4">Image Upload</label>
						<input type="file" name="image4" id="image4">
						<br>
						<label for="submit">&nbsp;</label>
						<input name="submit" type="submit" value="Add Event" id="button">
					</form>
					
					<!-- if the user was redirected here because one of the images did not match requested format, display error message here -->
					<?php
						if (array_key_exists('status', $_GET)) {
							if ($_GET['status'] == 'badImage')
		   						echo '<p class="warning">Images must be under 1mb with the extensions .jpg, .jpeg, .gif, or .png</p>';
						}
					?>
				</div>
				
				<!-- delete event tab -->
				<div id="delete">
					<!-- directions for the delete event form -->
					<p class="directions">To delete an event, Choose the name of the event below</p>
					<p>Please Note:</p>
					<ul>
						<li><p class="warning">This action cannot be undone. Make sure that you want to delete this event before submitting</p></li>
						<li><p>When an event is deleted, all associated images are also deleted and the website will no longer be able to access them</p></li>
						<li><p>If you delete an event in error, you can use the add events form to enter the event again.</p></li>
					</ul>
					<!-- form to delete events -->
					<form name="delete_events" action="delete_events.php" method="post">
					<?php
						//include database_variables.php to access session variables stored there
						include("database_variables.php");
						
						//connect to the database
		    			$db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
						or die ("unable to connect");
							
						//select all rows from events table in database
						$query = "SELECT * FROM events";
											
						if($result = mysqli_query($db_selected, $query)){
							//loop through all the events from the events table and set variables to hold onto html attributes
							while($row = mysqli_fetch_array($result))
		  					{
		  						//the title of the event to be displayed in the radiobutton option
		  						$title = $row['title'];
								//id, type, name and value html attributes
								$id = $row['id'];
								$htmlType = ' type="radio" ';
								$htmlName = ' name="event" ';
								$htmlValue = ' value='."$id";
								$htmlRequired = ' required ';
								//radiobutton form created
								echo '<label for="officer">&nbsp;</label>';
								echo '<input'.$htmlType.$htmlName.$htmlValue.$htmlRequired.'>'.$title.'<br>';
		  					}
						}
						else{
							echo $db_selected->error;
						}
						//close the database connection
						mysqli_close($db_selected);
						
					?>
					
					<label for="submit">&nbsp;</label>
					<input name="submit" type="submit" value="Delete Event" id="button">
					</form>
				</div>
			</section>
			<footer>
				<a href="../index.php" >SCEC Home Page</a>
				<a href="../events.php">Past Events</a>
				<a href="admin_navigation.php">Admin Navigation</a>
				<form name = "done" action="logout.php" method=post>
					<input name="logout" type="submit" value="logout" id="logout">
				</form>
			</footer>
		</div>
	</body>
</html>