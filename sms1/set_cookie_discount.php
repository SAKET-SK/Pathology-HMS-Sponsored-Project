<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$discountP = $_POST['discountP'];
	$discountVal = $_POST['discountVal'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][5]", $discountP);
	setcookie("pdetails[$firstIndex][$secondIndex][6]", $discountVal);


?>