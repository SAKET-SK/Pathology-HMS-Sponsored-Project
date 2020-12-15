<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
	require_once('connect.php');
	
		$mysqli->query("delete from cbc where idNo = '$_GET[idNo]'");
		
		header("Location:cbc_report.php?&active=cbc_report&action=delete");
		
}else{
	header("Location:index.php");	
}
?>