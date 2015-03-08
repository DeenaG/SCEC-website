<?php
	//start session to access session variables
    session_start(); 
	
	//if the user is not logged in, redirect to the login page
	if($_SESSION['loggedin']==false){
		header( 'Location: admin_login.php' );
		die;
	}
?>
<!DOCTYPE html>
<!-- this page includes forms to add and delete officers-->
<html lang="en-us">
	<head>
		<meta charset="UTF-8">
		<title>Officers</title>
		<link rel="shortcut icon" href="../images/favicon.ico">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script>
			//jquery function adds tabs to the website
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
			<!-- if the user was redirected here from the officers_process or delete_officers page, a success message will be displayed-->
			<?php
				if (array_key_exists('status', $_GET)) {
					if ($_GET['status'] == 'success')
	   					echo'<p class="success">Action completed successfully!</p>';
				}
			?>
			
			<header>
				<h1>Admin Control for Officers</h1>
			</header>
			<nav>
				<!-- tabs to add and delete officers -->
			 	<ul>
					<li><a href="#add">Add Officer</a></li>
					<li><a href="#delete">Delete Officer</a></li>
				</ul>
			</nav>
			<section>
				<!-- tab to add officer-->
				<div id="add">
					<!-- directions for the add officer form-->
					<p class="directions">To add an officer, fill out the following form</p>
					<p>Please Note:</p>
					<ul>
						<li><p>Accepted file types for upload: .jpeg, .jpg, .png, .gif</p></li>
						<li><p><strong>Accepted file size for upload: 1mb,</strong> however uploading images with smaller file sizes is recommended to prevent slow page loading</p></li>
						<li><p>Images will be resized to 100x100kb. To avoid distortion, resize images to be proportional to 100x100(a square)</p></li>
						<li><p>Do not upload multiple files with the same file name</p></li>
						<li><p>Description limited to 5000 characters</p></li>
					</ul>
					<!-- add officer form-->
					<form name="officers" action="officers_process.php" method="post" enctype="multipart/form-data">
						<label for="firstName">First Name:</label>
						<input type="text" name="firstName" id="firstName" required  autofocus>
						<br>
						<label for="lastName">Last Name:</label>
						<input type="text" name="lastName" id="lastName" required>
						<br>
						<label for="position">Position:</label>
						<input type="text" name="position" id="position" required>
						<br>
						<label for="description">Description</label>
						<textarea name="description" id="description" required pattern ="{1, 5000}"title="limit to 5000 characters"></textarea>
						<br>
						<label for="image">Image Upload</label>
						<input type="file" name="image" id="image" required title="image required">
						<br>
						<label for="submit">&nbsp;</label>
						<input name="submit" type="submit" value="Add Officer" id="button">
					</form>
					<!-- if the user was redirected here from the officers_process page because the image did not meet standards
						a warning message will be displayed -->
					<?php
						if (array_key_exists('status', $_GET)) {
							if ($_GET['status'] == 'badImage')
		   						echo '<p class="warning">Images must be under 1mb with the extensions .jpg, .jpeg, .gif, or .png</p>';
						}
					?>
				</div>
				
				<!-- tab to delete officers-->
				<div id="delete">
					<!-- directions for the delete officer form-->
					<p class="directions">To delete an officer, Choose the name of the officer below</p>
					<p>Please Note:</p>
					<ul>
						<li><p class="warning">This action cannot be undone. Make sure that you want to delete this officer before submitting</p></li>
						<li><p>When an officer is deleted, the associated image is also deleted and the website will no longer be able to access them</p></li>
						<li><p>If you delete an officer in error, you can use the add officers form to enter the officer again.</p></li>
					</ul>
					
					<!-- delete officer form-->
					<form name="delete_officers" action="delete_officers.php" method="post">
					<?php
						//include database_variables.php to access session variables stored there
						include("database_variables.php");
						
						//connect to the database
		    			$db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
						or die ("unable to connect");
							
						//select all rows from the officers table in the database
						$query = "SELECT * FROM officers ORDER BY lastName";				
						if($result = mysqli_query($db_selected, $query)){
							//loop through the officers and display their names as radio buttons
							while($row = mysqli_fetch_array($result)){
								//name officer to be diplayed
		  						$name = $row['firstName'] . " " . $row['lastName'];
								//variables for html attributes
								$id = $row['ID'];
								$htmlType = ' type="radio" ';
								$htmlName = ' name="officer" ';
								$htmlValue = ' value='."$id";
								$htmlRequired = ' required ';
								//display the radio buttons
								echo '<label for="officer">&nbsp;</label>';
								echo '<input'.$htmlType.$htmlName.$htmlValue.$htmlRequired.'>'.$name.'<br>';
		  					}
						}
						else{
							echo $db_selected->error;
						}
						//close the database connection
						mysqli_close($db_selected);
					?>
					<label for="submit">&nbsp;</label>
					<input name="submit" type="submit" value="Delete Officer" id="button">
					</form>
				</div>
			</section>
		<footer>
			<a href="../index.php">SCEC Home Page</a>
			<a href="../officers.php">Officers</a>
			<a href="admin_navigation.php">Admin Navigation</a>
			<form name = "done" action="logout.php" method=post>
				<input name="logout" type="submit" value="logout" id="logout">
			</form>
		</footer>
		</div>
	</body>
</html>