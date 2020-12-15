<?php
ob_start();
if (isset($_COOKIE['dms1'])) {
    
    $index = explode('/', $_GET['index']);
    
    $convertFirstIndex = $index[0];
	$secondIndex = $index[1];
	$countIndex = $index[2];

	$active = $convertFirstIndex.$secondIndex;

	$patientName = explode('_', $convertFirstIndex);
	$convertPN = '';
	$space = '';
	foreach ($patientName as $Pkey => $Pvalue) {
		$convertPN .= $space.$Pvalue;
		$space = ' ';
	}

	$getIndex = $_COOKIE['dms1'];
	$getIndexArray = $getIndex[$convertFirstIndex][$secondIndex][$countIndex];

	foreach ($getIndexArray as $key => $value) {
		setcookie ("dms1[$convertFirstIndex][$secondIndex][$countIndex][$key]", "", time() - 1);
	}

	$countArray = $getIndex[$convertFirstIndex][$secondIndex];
	$cA = sizeof($countArray);


	if($cA > 1){
		?>
		<script>
			$.post('get_cookie_value.php?active=<?php echo $active; ?>', function(data){
                
                $('#patientName').val("<?php echo $convertPN; ?>");
				
				$('#mobile').val('<?php if($secondIndex != '-'){echo $secondIndex;}else{echo '';} ?>');
				
				$('#searchTest').focus();

				$('.displayDetails').html(data);
            });
		</script>
		<?php
	}else{

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

}
?>