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
<!--this page contains forms to add and delete items from the minutes page -->
<html lang="en-us">
	<head>
		<meta charset="UTF-8">
		<title>Minutes</title>
		<link rel="shortcut icon" href="../images/favicon.ico">
		<link rel="stylesheet" href="styles/admin_style.css">
		<link rel="stylesheet" href="styles/update_style.css">
	
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script>
			//jquery function adds tabs 
			$(function() {
				$( "#tabs" ).tabs();
			});
			//jquery function adds a calendar to choose a date
			$(function() {
				$( "#datepicker" ).datepicker();
			});
		</script>
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div id="tabs">
			<!-- if the user was redirected to this page from the minutes_process or delete_minutes page, 
				a success message will be displayed here -->
			<?php
				if (array_key_exists('status', $_GET)) {
					if ($_GET['status'] == 'success')
	   					echo '<p class="success">Action completed successfully!</p>';
					}
				?>
			<header>
				<h1>Admin Control for Minutes</h1>
			</header>
			<nav>
			 	<ul>
			 		<!-- tabs to add and delete minutes -->
					<li><a href="#add">Add Minutes</a></li>
					<li><a href="#delete">Delete Minutes</a></li>
				</ul>
			</nav>
			<section>
				<!-- add minutes tab -->
				<div id="add">
					<!-- directions for the add minutes form-->
					<p class="directions">To add an entry to Minutes, fill out the following form</p>
					<p>Please Note:</p>
					<ul>
						<li><p>Accepted file type for upload: .pdf</p></li>
						<li><p>Accepted file size for upload: 1.5mb</p></li>
						<li><p>Do not upload multiple files with the same file name</p></li>
					</ul>
					<!--form to add minutes-->
					<form name="minutes" action="minutes_process.php" method="post" enctype="multipart/form-data">
						<label for="datepicker">Date</label>
						<input type="text" id="datepicker" name="datepicker" placeholder="Choose Date" required >
						<br>
						<label for="file">PDF Upload</label>
						<input type="file" name="file" id="file" required title="file upload required">
						<br>
						<label for="submit">&nbsp;</label>
						<input name="submit" type="submit" value="Submit Minutes" id="button">
					</form>
			
					<?php
						if (array_key_exists('status', $_GET)) {
							if ($_GET['status'] == 'badFile')
		   						echo '<p class="warning">Files must be under 1.5MB with the extension .pdf</p>';
							}
					?>
				</div>
				
				<!-- delete minutes tab -->
				<div id="delete">
					<!-- directions for the delete minutes form -->
					<p class="directions">To delete an entry from Minutes, Choose the date of the meeting below</p>
					<p>Please Note:</p>
					<ul>
						<li><p class="warning">This action cannot be undone. Make sure that you want to delete this entry before submitting</p></li>
						<li><p>When minutes are deleted, the PDF file associated with the minutes is deleted as well and the website will no longer be able to access it</p></li>
						<li><p>If you delete an entry by mistake, you can use the form above to enter it again.</p></li>
					</ul>
					<form name="delete_minutes" action="delete_minutes.php" method="post">
						<?php
							//include database_variables.php to access session variables stored there
							include("database_variables.php");
							
							//connect to the database
		    				$db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
							or die ("unable to connect");
							
							//Some versions of php require a default time zone to be set. use the appropriate method for php version on server
							//set_default_timezone('America/Chicago');
							//date_default_timezone_set('America/Chicago');
							
							//select all rows from minutes table in chronological order
							$query = "SELECT * FROM minutes ORDER BY date";
							if($result = mysqli_query($db_selected, $query)){
								//loop through the rows and display the dates in radiobuttons
								while($row = mysqli_fetch_array($result))
		  						{
		  							//the timestamp stored in the database
		  							$date = $row['date'];
									$id = $row['id'];
									//format the date based on the timestamp shown above
									$dateFormat = date('m/d/Y', $date);	
									//variables for html attributes
									$htmlType = ' type="radio" ';
									$htmlName = ' name="minutes" ';
									$htmlValue = ' value='."$id";
									$htmlRequired = ' required ';
									//radiobuttons to be displayed in form
									echo '<label for="minutes">&nbsp;</label>';
									echo '<input'.$htmlType.$htmlName.$htmlValue.$htmlRequired.'>'.$dateFormat.'<br>';
		  						}
							}
							else{
								echo $db_selected->error;
							}
							//close database
							mysqli_close($db_selected);
							
						?>
						<label for="submit">&nbsp;</label>
						<input name="submit" type="submit" value="Delete Minutes" id="button">
					</form>
				</div>
			</section>
		<footer>
			<a href="../index.php">SCEC Home Page</a>
			<a href="../minutes.php">Minutes</a>
			<a href="admin_navigation.php">Admin Navigation</a>
			<form name = "done" action="logout.php" method=post>
				<input name="logout" type="submit" value="logout" id="logout">
			</form>
		</footer>
		</div>
	</body>
</html>