<?php
ob_start();
session_start();
require_once('connect.php');

$delete = $mysqli->query("delete from doctor where id = '$_GET[doctorId]'");

if($delete){
	header("Location:doctor.php?active=doctor&delete=success");	
}

?>