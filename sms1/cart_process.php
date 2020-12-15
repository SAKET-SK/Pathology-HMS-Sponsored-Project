<?php
ob_start();
@session_start();

	if(isset($_GET['testKey'])){
		require_once('connect.php');
		
		$searchKey = $_GET['testKey'];
		
		$query = $mysqli->query("select * from tests where testName = '$searchKey'");
		
		$count = $query->num_rows;
		
		if($count > 0){
			$array = $query->fetch_array();
			
			$firstIndex = explode(' ', $_GET['patientName']);
			$convertFirstIndex = '';
			$underscore = '';
			foreach ($firstIndex as $key => $value) {
				$convertFirstIndex .= $underscore.$value;
				$underscore = '_';
			}

			if($_GET['mobile'] <> ''){
				$secondIndex = $_GET['mobile'];
			}
			
			$active = $convertFirstIndex.$secondIndex;

			$testId = $array['testId'];
			
			if(array_key_exists('dms1', $_COOKIE)){
				
				$getIndex = $_COOKIE['dms1'];
				if(@array_key_exists($convertFirstIndex, $getIndex)){
					if(@array_key_exists($secondIndex, $getIndex[$convertFirstIndex])){
						

						$getCountIndex = $getIndex[$convertFirstIndex][$secondIndex];
						//print_r($getCountIndex);
						$countIndex = 0;
						foreach ($getCountIndex as $key => $value) {
							$countIndex = $key;
							if($value[0] == $testId){
								//echo $testId. ' allready exists';
								?>
									<script>
						                $.post('get_cookie_value.php?active=<?php echo $active; ?>', function(data){
						                    
						                    $('#patientName').val("<?php echo $_GET['patientName']; ?>");
											
											$('#mobile').val('<?php if($secondIndex != '-'){echo $secondIndex;}else{echo '';} ?>');
											
											$('#searchTest').focus();

											$('.displayDetails').html(data);
						                });
						            </script>
								<?php
								exit();
							}
						}

						$insertCount = $countIndex + 1;
						setcookie("dms1[$convertFirstIndex][$secondIndex][$insertCount][0]", $testId);
						setcookie("dms1[$convertFirstIndex][$secondIndex][$insertCount][1]", 0);
						//echo 'Last Ok';
					}else{
						setcookie("dms1[$convertFirstIndex][$secondIndex][0][0]", $testId);
						setcookie("dms1[$convertFirstIndex][$secondIndex][0][1]", 0);
						//echo 'First Ok';
					}
					/*foreach ($getIndex as $key1 => $value1) {
						echo $key1;
						if(is_array($value1)){
							foreach ($value1 as $key2 => $value2) {

							}
						}
					}*/
				}else{
					setcookie("dms1[$convertFirstIndex][$secondIndex][0][0]", $testId);
					setcookie("dms1[$convertFirstIndex][$secondIndex][0][1]", 0);
					//echo 'First Ok';
				}
			}else{
				setcookie("dms1[$convertFirstIndex][$secondIndex][0][0]", $testId);
				setcookie("dms1[$convertFirstIndex][$secondIndex][0][1]", 0);
				//echo 'First Ok';
			}
			?>
			<script>
                $.post('get_cookie_value.php?active=<?php echo $active; ?>', function(data){
                    
                    $('#patientName').val("<?php echo $_GET['patientName']; ?>");
					
					$('#mobile').val('<?php if($secondIndex != '-'){echo $secondIndex;}else{echo '';} ?>');
					
					$('#searchTest').focus();

					$('.displayDetails').html(data);
                });
            </script>
            <?php	
		}else{
			echo "<center><font color='#F00' size='5'><b>Test Not Found! $searchKey </b></font></center>";
		}
	
	}
?>