<?php
ob_start();
session_start();
require_once('connect.php');

$delete = $mysqli->query("delete from tests where testId = '$_GET[testId]'");

if($delete){
	header("Location:test.php?active=test&delete=success");	
}

?>