<?php
require_once('connect.php');
if(isset($_GET['query'])){
	
	$searchKey = (string)$_GET['query'];
	$query = $mysqli->query("select * from tests where testName like '%{$searchKey}%'");
	
	$array = array();

	while($rows = $query->fetch_array()){
		$array[] = $rows['testName'];
	}
	//$array = array('Jahid Hasan', 'Tauhid-ul-sadik');
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>