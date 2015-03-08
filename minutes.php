
<!DOCTYPE html>
<!--Meeting minutes for the SCEC-->
<html lang="en-us">
	<head>
		<title>SCEC Minutes</title>
		<meta charset="UTF-8">
		<meta name="description" content="SCEC meeting minutes">
		<meta name="keywords" content="NEIU, SCEC, CEC, Student Council for Exceptional Children, 
			Council for Exceptional Children, special education">
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="stylesheet" href="styles/main_style.css">
		<link rel="stylesheet" href="styles/header_style.css">
		<link rel="stylesheet" href="styles/navigation_bar_style.css">
		<link rel="stylesheet" href="styles/minutes_style.css">
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div id="test">
			<div id="minutes">
				<?php
						$header = "Meeting Minutes";
						include "includes/header.php";
						include "includes/navigation.php";
				?>
			
				<section>
					<h2>Click on the dates below to view the Meeting Minutes</h2>
					<?php
						//include the database_variables page to access session variables
						include("admin_controls/database_variables.php");
						$db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
						or die ("unable to connect");
						
						//set default time zone
						//set_default_timezone('America/Chicago');
						//date_default_timezone_set('America/Chicago');
						
						//select all rows from minutes table
						$query = "SELECT * FROM minutes ORDER BY date";
						
						if($result = mysqli_query($db_selected, $query)){
							//loop through rows and display the date with a link to the meeting minutes
							while($row = mysqli_fetch_array($result))
		  					{
		  						$link = $row['filePath'];
								$date = $row['date'];
								$dateFormat = date('m/d/Y', $date);
								echo "<a href=".$link.">".$dateFormat."</a>";
								echo "<br>";		
		  					}
						}
						else{
							echo $db_selected->error;
						}
						
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