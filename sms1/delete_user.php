<?php
ob_start();
session_start();
require_once('connect.php');

$delete = $mysqli->query("delete from user where id = '$_GET[userId]'");

if($delete){
	header("Location:user_management.php?active=user_management");	
}

?>