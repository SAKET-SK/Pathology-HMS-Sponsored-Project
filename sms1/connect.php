<?php
	$mysqli = new MySQLi("localhost", "root", "", "lab3");
	$mysqli->set_charset('utf8');
	
	if($mysqli->connect_error)
	{
		echo $mysqli->connect_errno;	
	}
	
?>