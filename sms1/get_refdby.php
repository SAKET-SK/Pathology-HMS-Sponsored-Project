<?php
require_once('connect.php');
if(isset($_GET['query'])){
	
	$searchDoc = $_GET['query'];
	$query = $mysqli->query("select * from doctor where doctor_name like '%{$searchDoc}%'");
	
	$array = array();
	
	while($rows = $query->fetch_array()){
		$array[] = $rows['doctor_name'];
	}
	//$array = array('Jahid Hasan', 'Tauhid-ul-sadik');
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>