<?php
require_once('connect.php');
if(isset($_GET['query'])){
	
	$query = $mysqli->query("select * from pathology where header like '%{$_GET[query]}%'");
	
	$array = array();
	
	while($rows = $query->fetch_array()){
		$array[] = $rows['header'];
	}
	//$array = array('Jahid Hasan', 'Tauhid-ul-sadik');
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>