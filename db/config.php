<?php
   $connected = false;

	//------ DB Connection ------
	$db_pswd="Wind123456";
	$db_login="infystra_web";
	$db_host="localhost";
	$db_name ="infystra_web";
	

	global $dbconnect;
		
	if (!$dbconnect = @mysql_connect($db_host, $db_login, $db_pswd)) {
    		echo 'Could not connect to mysql';
    		exit;
	}

	if (!@mysql_select_db($db_name, $dbconnect)) {
		echo 'Could not select database';
		exit;
	}
	
?>