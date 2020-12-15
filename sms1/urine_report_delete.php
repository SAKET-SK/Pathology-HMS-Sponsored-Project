<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
	require_once('connect.php');
	
		$mysqli->query("delete from urine where idNo = '$_GET[idNo]'");
		
		header("Location:urine_report.php?&active=urine_report&action=delete");
		
}else{
	header("Location:index.php");	
}
?>