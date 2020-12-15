<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$age = $_POST['age'];
	$ageType = $_POST['ageType'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][1]", $age);
	setcookie("pdetails[$firstIndex][$secondIndex][2]", $ageType);

?>