<!DOCTYPE html>
<!--outside resources for the SCEC-->
<html lang="en-us">
	<head>
		<title>SCEC external resources</title>
		<meta charset="UTF-8">
		<meta name="description" content="CEC Constitution">
		<meta name="keywords" content="NEIU, SCEC, CEC, Student Council for Exceptional Children, 
			Council for Exceptional Children, special education, constitution">
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="stylesheet" href="styles/main_style.css">
		<link rel="stylesheet" href="styles/header_style.css">
		<link rel="stylesheet" href="styles/navigation_bar_style.css">
		<link rel="stylesheet" href="styles/resources_style.css">
		
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>

	<body>
		<div id="test">
			<div id="resources">
				<?php
					//include header and navigation pages
					$header = "External Resources";
					include "includes/header.php";
					include "includes/navigation.php";
				?>
			
				<section>
					<!-- display resource logo nd caption -->
					<figure>
						<figcaption>Council for Exceptional Children</figcaption>
						<a href="http://www.cec.sped.org/" target="_blank"><img src="images/CEC.jpg" alt="CEC logo"></a>
					</figure>
					<figure>
						<figcaption>Epilepsy Foundation of Greater Chicago</figcaption>
						<a href="http://www.epilepsychicago.org/" target="_blank"><img src="images/epilepsy.jpg" alt="epilepsy foundation logo"></a>
					</figure>
					<figure>
						<figcaption>Autism Speaks</figcaption>
						<a href="http://www.autismspeaks.org/" target="_blank"><img src="images/autism_speaks.jpg" alt="autism speaks logo"></a>
					</figure>
					<figure>
						<figcaption>Teaching Tolerance</figcaption>
						<a href="http://www.tolerance.org/" target="_blank"><img src="images/teaching_tolerance.jpg" alt="teaching tolerance logo"></a>
					</figure>
				</section>
				
				<?php
					include "includes/footer.php";
				?>
		
			</div>
		</div>
		
	</body>
</html>
