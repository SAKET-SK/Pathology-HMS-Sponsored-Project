<?php
ob_start();
session_start(); 
if(!isset($_SESSION['userId'])){
	header("Location:index.php");
}
else
{

require_once('connect.php');


$update = $mysqli->query("update invoice set isCancel = '1' where invoiceId = '$_GET[invoiceId]'");

$update = $mysqli->query("update patient_payment set isCancel = '1' where invoiceId = '$_GET[invoiceId]'");

$update = $mysqli->query("update patient_due_payment set isCancel = '1' where invoiceId = '$_GET[invoiceId]'");

$update = $mysqli->query("update patient_discount set isCancel = '1' where invoiceId = '$_GET[invoiceId]'");

$update = $mysqli->query("update refdfeeamount set isCancel = '1' where invoiceId = '$_GET[invoiceId]'");

	if($update){
		
		header("Location:receipt_report.php?active=receipt_report&delete=success");
	}
       
}


?>