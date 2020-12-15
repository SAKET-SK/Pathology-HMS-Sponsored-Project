<?php
require_once('connect.php');
if(isset($_GET['medicineKey'])){
	
	$medicineKey = $_GET['medicineKey'];

	$query = $mysqli->query("select * from medicine where medicieName like '%{$medicineKey}%'");
	
	$rows = $query->fetch_array();
	$amount = $rows['unitPrice'] * 1;
	$discountValue = ($amount * $rows['discount']) / 100;
	$total = $amount - $discountValue;

	$array = array('unitPrice' => $rows['unitPrice'], 'unit' => '1', 'amount' => $amount, 'discount' => $rows['discount'], 'total' => $total);
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>