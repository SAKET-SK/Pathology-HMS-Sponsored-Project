<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$ageType = $_POST['ageType'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][2]", $ageType);

?>