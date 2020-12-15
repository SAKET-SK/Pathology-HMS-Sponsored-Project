<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
	require_once('connect.php');
	
		$mysqli->query("delete from path_result_pages where idNo = '$_GET[idNo]'");
		$mysqli->query("delete from report_output where idNo = '$_GET[idNo]'");
		header("Location:report.php?&active=report&action=delete");
		
}else{
	header("Location:index.php");	
}
?>