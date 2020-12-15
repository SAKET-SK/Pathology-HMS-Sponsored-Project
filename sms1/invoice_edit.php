<?php
ob_start();
@session_start();
require_once('connect.php');

$invoiceId = $_GET['invoiceId'];

$query = $mysqli->query("select * from invoice join invoice_tests on invoice.invoiceId = invoice_tests.invoiceId where invoice.invoiceId = '$invoiceId'");

if($query->num_rows > 0){

	$i = 0;
	while($rows = $query->fetch_array()){
		$patientName = $_GET['patientName'];
		$patientSex = $rows['patientSex'];
		$patientAgeArray = explode(" ", $rows['patientAge']);
		$patientAge = $patientAgeArray[0];
		$patientAgeType = $patientAgeArray[1];
		$refdId = $rows['refdId'];
		$coId = $rows['coId'];

		$firstIndex = explode(' ', $_GET['patientName']);
		$convertFirstIndex = '';
		$underscore = '';
		foreach ($firstIndex as $key => $value) {
			$convertFirstIndex .= $underscore.$value;
			$underscore = '_';
		}
		$secondIndex = $rows['patientMobile'];
		
		$testArray = array($rows['testId'], $rows['discount']);

		$j = 0;
		foreach($testArray as $value){
			setcookie("dms1[$convertFirstIndex][$secondIndex][$i][$j]", $value);
			//echo "[$convertFirstIndex][$secondIndex][$i][$j]=".$value;
			echo '<br/>';
			$j++;
		}
		
		
		$i++;
	}
	
	$getPay = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$invoiceId'");
	$payArray = $getPay->fetch_array();

	$getDuePay = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$invoiceId'");
	$payDueArray = $getDuePay->fetch_array();

	$getDis = $mysqli->query("select sum(disPersent) from patient_discount where invoiceId = '$invoiceId'");
	$disArray = $getDis->fetch_array();

	$getDisTk = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$invoiceId'");
	$disTkArray = $getDisTk->fetch_array();

	$getRefd2 = $mysqli->query("select * from doctor where id = '$refdId'");
	$refdArray2 = $getRefd2->fetch_array();

	$getCO2 = $mysqli->query("select * from co where coId = '$coId'");
	$coArray2 = $getCO2->fetch_array();

	$cashBack = $mysqli->query("select sum(cashBackAmount) from cash_back where invoiceId = '$invoiceId'");
	$cashBackArray = $cashBack->fetch_array();
 	
	$paid = $payArray[0] + $payDueArray[0];
	$discountP = $disArray[0];
	$discountVal = $disTkArray[0];
	$co = $coArray2['coName'];
	$refd = $refdArray2['doctor_name'];
	$invoiceType = 'old';
	$pay = 0;
	$cashBackAmount = $cashBackArray[0];

	setcookie("pdetails[$convertFirstIndex][$secondIndex][0]", $patientSex);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][1]", $patientAge);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][2]", $patientAgeType);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][3]", $co);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][4]", $refd);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][5]", $discountP);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][6]", $discountVal);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][7]", $pay);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][8]", $invoiceType);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][9]", $paid);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][10]", $invoiceId);
	setcookie("pdetails[$convertFirstIndex][$secondIndex][11]", $cashBackAmount);

	header("Location:receipt.php?active=receipt");
}
