<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
	require_once('connect.php');
	
		$mysqli->query("delete from semen where idNo = '$_GET[idNo]'");
		
		header("Location:semen_report.php?&active=semen_report&action=delete");
		
}else{
	header("Location:index.php");	
}
?>