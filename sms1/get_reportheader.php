<?php
require_once('connect.php');
if(isset($_GET['query'])){
	
	$search = $_GET['query'];
	$query = $mysqli->query("select * from report_header where reportHeader like '%{$search}%'");
	
	$array = array();
	
	while($rows = $query->fetch_array()){
		$array[] = $rows['reportHeader'];
	}
	//$array = array('Jahid Hasan', 'Tauhid-ul-sadik');
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>