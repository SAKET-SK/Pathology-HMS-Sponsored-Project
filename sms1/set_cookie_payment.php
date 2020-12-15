<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$pay = $_POST['pay'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][7]", $pay);

?>