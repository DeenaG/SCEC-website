
<!DOCTYPE html>
<!-- Past Events of the SCEC-->
<html lang="en-us">
	<head>
		<title>SCEC Past Events</title>
		<meta charset="UTF-8">
		<meta name="description" content="SCEC Events descriptions">
		<meta name="keywords" content="NEIU, SCEC, CEC, Student Council for Exceptional Children, 
			Council for Exceptional Children, special education">
		<link rel="shortcut icon" href="images/favicon.ico">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		 <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<!--jquery accordion function-->
		<script>
   			$(function() {
			$( "#accordion" ).accordion({heightStyle: "content"});
		});</script>
		
		<link rel="stylesheet" href="styles/main_style.css">
		<link rel="stylesheet" href="styles/header_style.css">
		<link rel="stylesheet" href="styles/navigation_bar_style.css">
		<link rel="stylesheet" href="styles/events_style.css">
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div id="test">
			<div id="events">
			
				<!--include header and navigation pages-->
				<?php
					$header = "Past Events";
					include "includes/header.php";
					include "includes/navigation.php";
				?>
				<section>
					<?php
						//include database_variables.php to access session variables
						include("admin_controls/database_variables.php");
						
						//connect to the database
						$db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
						or die ("unable to connect");
						
						//select all rows from events
						$query = "SELECT * FROM events";
						
						//alt variable for all images on the page
						$alt = ' alt="picture of event" ';
						
						//start accordion
						echo '<div id="accordion">';
						
							//loop through the events. Each event will be displayed within one section of the accordion
							if($result = mysqli_query($db_selected, $query)){
								while($row = mysqli_fetch_array($result))
			  					{
			  						//title of event
									echo "<h3>".$row['title']."</h3>";
									//accordion section starts here
									echo "<div>";
									//description of event
			  						echo "<p>".$row['description']."</p>";
									//select all pictures from the pictures table with the eventID that matches the id of the current event
									$queryPicture = "SELECT * FROM pictures WHERE eventID = ".$row['id'];
									//loop through all pictures from the current event and diplay
									if($resultPicture = mysqli_query($db_selected, $queryPicture)){
										echo '<div id=images>';
										while($rowPicture = mysqli_fetch_array($resultPicture)){
											echo "<img src=".$rowPicture['imagePath'].$alt.">";
										}
										echo '</div>';
									}
									//end accordion section
									echo "</div>";
			  					}
							}
							else{
								echo $db_selected->error;
							}
						echo "</div>";//end accordion
						mysqli_close($db_selected);
					?>
				</section>
				
				<?php
					include "includes/footer.php";
				?>
			
			</div>
		</div>
	</body>
</html>