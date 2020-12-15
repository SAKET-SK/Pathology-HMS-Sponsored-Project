<?php
	
	$firstIndex = $_POST['firstIndex'];
	$secondIndex = $_POST['secondIndex'];
	$sex = $_POST['sex'];
	$invoiceType = $_POST['invoiceType'];
	$paid = $_POST['paid'];
	$invoiceId = $_POST['invoiceId'];
	
	setcookie("pdetails[$firstIndex][$secondIndex][0]", $sex);
	setcookie("pdetails[$firstIndex][$secondIndex][8]", $invoiceType);
	setcookie("pdetails[$firstIndex][$secondIndex][9]", $paid);
	setcookie("pdetails[$firstIndex][$secondIndex][10]", $invoiceId);
	

?>