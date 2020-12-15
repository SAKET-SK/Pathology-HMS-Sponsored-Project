<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('connect.php');
$mktime = mktime(date("H")+6, date("i"), date("s"));
$date = date('Y-m-d',$mktime);
$time = date('h:i:s A', $mktime);

if(isset($_GET['payment'])){
	
	$insert = $mysqli->query("insert into patient_payment values('', '$_GET[patientId]', '$_GET[payment]', '$date')");	
	
	if($insert){
		header("Location:due_payment.php?active=due_payment&patientId=$_GET[patientId]&payment=success");
	}
}

}else{
	header("Location:index.php");	
}
?>