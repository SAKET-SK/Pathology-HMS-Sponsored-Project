<?php
ob_start();
@session_start();
require_once('connect.php');

$delete = $mysqli->query("delete from test_category where categoryId = '$_GET[categoryId]'");
$delete = $mysqli->query("delete from tests where testCategoryId = '$_GET[categoryId]'");

if($delete){
	header("Location:category.php?active=category&delete=success");	
}

?>