<?php
    if(!isset($_SESSION)){
    	session_start();
}?>
<!DOCTYPE html>
<html lang="en-us">
	
	<head>
		<title>SCEC Officers</title>
		<meta charset="UTF-8">
		<meta name="description" content="SCEC Officer descriptions and contact information">
		<meta name="keywords" content="NEIU, SCEC, CEC, Student Council for Exceptional Children, 
			Council for Exceptional Children, special education">
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="stylesheet" href="styles/main_style.css">
		<link rel="stylesheet" href="styles/header_style.css">
		<link rel="stylesheet" href="styles/navigation_bar_style.css">
		<link rel="stylesheet" href="styles/officers_style.css">
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div id="test">
			<div id="officers">
				<?php
					//include the header and navigation pages
					$header = "Meet the Officers";
					include "includes/header.php";
					include "includes/navigation.php";
				?>
			
				<section>
					<?php
						//include database_variables.php to access session variables
						include("admin_controls/database_variables.php");
						
						//connect to database
						$db_selected = mysqli_connect($_SESSION['hostName'],$_SESSION['username'], $_SESSION['password'], $_SESSION['db_name'])//specify database
						or die ("unable to connect");
						
						//select all rows from officers table ordered by last name
						$query = "SELECT * FROM officers ORDER BY lastName";
						
						//variables for html attributes
						$classDescription = ' class="description" ';
						$className = ' class="right name" ';
						$classPosition = ' class="right position" ';
						$alt = ' alt="picture of officer" ';
							
						if($result = mysqli_query($db_selected, $query)){
							//loop through the rows and display the information
							while($row = mysqli_fetch_array($result))
		  					{
								echo "<p".$className.">".$row['firstName'] . " " . $row['lastName']."</p>";
		  						echo "<p".$classPosition.">".$row['position']."</p>";
								echo "<img src=".$row['imagePath'].$alt.">";
		  						echo "<p".$classDescription.">".$row['description']."</p>";
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