<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$refdby = $_POST['refdby'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][4]", $refdby);

?>