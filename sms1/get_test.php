<?php
require_once('connect.php');
if(isset($_GET['testKey'])){
	
	$query = $mysqli->query("select * from items where item_name = '$_GET[testKey]'");
	
	while($rows = $query->fetch_array()){
		echo $rows['item_name'];
	}
}
?>