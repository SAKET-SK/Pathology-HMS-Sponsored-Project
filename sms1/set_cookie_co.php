<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$co = $_POST['co'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][3]", $co);

?>