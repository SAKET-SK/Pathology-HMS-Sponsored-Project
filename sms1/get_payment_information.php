<?php
require_once('connect.php');
if(array_key_exists('rmdd', $_COOKIE)){
	
	$cookie = $_COOKIE['rmdd'];
	
	$totalAmount = 0;
	$totalRefdFee = 0;
	foreach($cookie as $index => $array){
		$getTest = $mysqli->query("select * from tests where testId = $array[0]");
		$testArray = $getTest->fetch_array();
		$totalAmount += $testArray['rate'];
		$totalRefdFee += $testArray['refdFeeAmount'];
	}
	
	$json_array = array("totalAmount" => $totalAmount, "totalRefdFee" => $totalRefdFee);
}else{
	$json_array = array("totalAmount" => 0, "totalRefdFee" => 0);
}
echo json_encode($json_array);