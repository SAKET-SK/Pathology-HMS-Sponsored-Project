<?php
ob_start();
session_start();
require_once('connect.php');

$delete = $mysqli->query("delete from co where coId = '$_GET[coId]'");

if($delete){
	header("Location:co.php?active=co&delete=success");	
}

?>