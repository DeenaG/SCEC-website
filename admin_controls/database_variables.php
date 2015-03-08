<?php
	/*This page defines session variables to be used by the other pages accessing the database*/
	
	
	//variables to connect to the database
	$_SESSION['username'] = 'drubin'; //username for database
	$_SESSION['password'] = ''; //password for database
	$_SESSION['hostName'] = 'localhost'; //host
	$_SESSION['db_name'] =  'test'; //name of database
	
	//paths to images and documents folder. changes based on the server being used
	$_SESSION['imagesPath'] = '../images/';
	$_SESSION['documentsPath'] = '../documents/';
	
	//for neiu server: /home/staff/scec/http/name_of_folder/
	//for cs server: /home/drubin/public_html/SCEC/name_of_folder/
	
?>