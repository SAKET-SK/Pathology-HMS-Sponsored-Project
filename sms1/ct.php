<?php
if (isset($_COOKIE['dms1'])) {
    
    //$index = explode('/', $_GET['index']);
    
    $convertFirstIndex = 'Md._Jahid_Hasan';
	$secondIndex = '-';

	$getIndex = $_COOKIE['dms1'];
	$getIndexArray = $getIndex[$convertFirstIndex][$secondIndex];

	foreach ($getIndexArray as $key1 => $value1) {
		echo $value1[0];
	}
}

?>