<?php
require_once('connect.php');
if(isset($_GET['query'])){
	
	$medicieName = $_GET['query'];

	$query = $mysqli->query("select * from medicine where medicieName like '%{$medicieName}%'");
	
	$array = array();
	
	while($rows = $query->fetch_array()){
		$array[] = $rows['medicieName'];
	}
	
	//$array = array($_GET['query'], 'Tauhid-ul-sadik');
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>