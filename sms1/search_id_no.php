<?php
require_once('connect.php');
if(isset($_GET['query'])){
	
	$searchKey = $_GET['query'];
	$query = $mysqli->query("select * from invoice where idNo like '%{$searchKey}%' order by idNo desc");
	
	$array = array();

	while($rows = $query->fetch_array()){
		$array[] = $rows['idNo'];
	}
	//$array = array('Jahid Hasan', 'Tauhid-ul-sadik');
	
	echo json_encode($array);
	//echo $_POST['query'];
}
?>