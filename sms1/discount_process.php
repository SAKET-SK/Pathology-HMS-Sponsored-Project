<?php
ob_start();
@session_start();

	if(isset($_GET['value'])){
		$id = explode('/', $_GET['id']);
		$convertFirstIndex = $id[0];
		$secondIndex = $id[1];
		$countIndex = $id[2];

		$active = $convertFirstIndex.$secondIndex;

		$patientName = explode('_', $convertFirstIndex);
		$convertPN = '';
		$space = '';
		foreach ($patientName as $Pkey => $Pvalue) {
			$convertPN .= $space.$Pvalue;
			$space = ' ';
		}

		setcookie("dms1[$convertFirstIndex][$secondIndex][$countIndex][1]", $_GET['value']);

		setcookie ("pdetails[$convertFirstIndex][$secondIndex][5]", "", time() - 1);
		setcookie ("pdetails[$convertFirstIndex][$secondIndex][6]", "", time() - 1);
		setcookie ("pdetails[$convertFirstIndex][$secondIndex][7]", "", time() - 1);

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
	}
?>