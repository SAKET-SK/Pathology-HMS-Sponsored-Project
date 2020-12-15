<?php
ob_start();
if (isset($_COOKIE['dms1'])) {
    
    $index = explode('/', $_GET['index']);
    
    $convertFirstIndex = $index[0];
	$secondIndex = $index[1];

	$getIndex = $_COOKIE['dms1'];
	$getIndexArray = $getIndex[$convertFirstIndex][$secondIndex];

	foreach ($getIndexArray as $key1 => $value1) {
		if(is_array($value1)){

			foreach ($value1 as $key2 => $value2) {
				setcookie ("dms1[$convertFirstIndex][$secondIndex][$key1][$key2]", "", time() - 1);
			}
		}
	}

	if(isset($_COOKIE['pdetails'])){
	
		$getIndex2 = $_COOKIE['pdetails'];
	
		if(array_key_exists($convertFirstIndex, $_COOKIE['pdetails'])){
			$getIndexArray2 = $getIndex2[$convertFirstIndex][$secondIndex];

			foreach ($getIndexArray2 as $key2 => $value2) {
				setcookie ("pdetails[$convertFirstIndex][$secondIndex][$key2]", "", time() - 1);
			}
		}
	}
	

	?>
    <script>
		$.post('get_cookie_value2.php', function(data){
			$('.displayDetails').html(data);
		});
	</script>
    <?php

}
?>