<!DOCTYPE html>
<!--This is the main page for the Student Council for Exceptional Children(SCEC) at NEIU-->
<html lang="en-US">
	<head>
		<title>SCEC Student Council for Exceptional Children at NEIU</title>
		<meta charset="UTF-8">
		<meta name="description" content="Homepage for NEIU student organization: 
			Student Council for Exceptional Children(SCEC)">
		<meta name="keywords" content="NEIU, SCEC, CEC, Student Council for Exceptional Children, 
			Council for Exceptional Children, special education">
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="stylesheet" href="styles/main_style.css">
		<link rel="stylesheet" href="styles/header_style.css">
		<link rel="stylesheet" href="styles/navigation_bar_style.css">
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>

	<body>
		<div id="test">
			<div id="index">
				
				<!--include header and navigation pages-->
				<?php
					$header = "Welcome to the SCEC";
					include "includes/header.php";
					include "includes/navigation.php";
				?>
		
				<section>
					<h2>What is SCEC?</h2>
					<!--description of the SCEC-->
					<p>
						The SCEC is the Student Council for Exceptional Children.  The SCEC is dedicated to advancing excellence in education through 
						quality professional preparation and service to exceptional learners.  The SCEC shall be an association of all future 
						educators with an interest in special education.  In all endeavors, the SCEC promotes its members operating as a cohesive 
						unit, with respect to the varied constituencies herein.  The SCEC will adhere to the highest standards of ethical conduct, 
						professional accountability, and respect for diversity. 
					</p>
				</section>
			
				<?php
					include "includes/footer.php";
				?>
	
			</div>
		</div>
	</body>
</html>