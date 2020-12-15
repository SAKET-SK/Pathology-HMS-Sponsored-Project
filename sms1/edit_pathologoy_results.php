<?php
ob_start();
@session_start();
if(isset($_SESSION['userId'])){
require_once('connect.php');
?>
<style>
#result{
	width:700px;
	min-height:200px;
	height:auto;
	margin:auto;
}
#main_page{
	width:700px;
	height:auto;
	margin:auto;
}
#page_1{
	width:700px;
	height:792px;
	margin-top:100px;
}
ul{
	list-style:none;
	margin:0;
	padding:0;
}
ul li ul{
	list-style:none;
}
</style>
<style media="print">
.btn{
	display:none;
}
</style>
<title>Pathology Result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="btn" align="center"><button onclick="window.print()" style="padding:3px 15px; font-weight:bold">Print</button><button onclick="window.location='report.php?active=report'" style="padding:3px 15px; font-weight:bold">Back</button></div>
<?php
	$mktime = mktime(date("H")+6, date("i"), date("s"));
	$date = date('Y-m-d', $mktime);
	$time = date('H:i:s', $mktime);
	
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	
	//$mysqli->query("insert into path_result_pages values('', '$_POST[idNo]', '$_POST[pageCombination]', '$date', '$time')") or die($mysqli->error);
	
	$mysqli->query("update path_result_pages set pages = '$_POST[pageCombination]' where idNo = '$_POST[idNo]'");
	
	$postValue = $_POST['value'];
		$pageSl = $_POST['pageSl'];
		$i=0;
		foreach ($postValue as $key => $value) {
				
				foreach ($value as $key2 => $value2) {
					if($value2 <> ''){

						$checkValue = $mysqli->query("select * from report_output where reportContentId = '$key' and reportId = '$key2' and idNo = '$_POST[idNo]'");
						if($checkValue->num_rows > 0){
							$mysqli->query("update report_output set value = '$value2' where reportContentId = '$key' and reportId = '$key2' and idNo = '$_POST[idNo]'");
						}else{
							$mysqli->query("insert into report_output values('', '$key', '$key2', '$_POST[idNo]', '$value2', '$pageSl[$i]')");
						}
					}
				}
				$i++;
		}
	
	
	
	//if($addResult){
		$getPage = $mysqli->query("select * from path_result_pages join invoice on path_result_pages.idNo = invoice.idNo where path_result_pages.idNo = '$_POST[idNo]'");
		$metaArray = $getPage->fetch_array();
		?>
        <div id="main_page">
        <?php
		$SeperatePage = explode("-",$metaArray['pages']);
		
		$i=1;
		foreach($SeperatePage as $index => $array){
			
			$samePage = explode(",", $array);
			?>
            <style>
			#page_<?php echo $i+1; ?>{
				width:700px;
				height:792px;
				margin-top:100px;
			}
			</style>
			<style media="print">
				#page_<?php echo $i; ?>{
					display:inline-table;
				}
			
			</style>
            
            <div id="page_<?php echo $i; ?>">
                <div id="result">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
			<td width="120px" style="font-weight:bold; border:1px solid">&nbsp;&nbsp;Lab ID NO : <?php echo $metaArray['pathDailySl']; ?></td>
			<td colspan="2" width="120px" style="font-weight:bold; border:1px solid; border-left:none; text-align:center">Date : 
			<?php
				$resultDate = new DateTime($metaArray['resultDate']);
				echo '<i>'.$resultDate->format('M d, Y').'</i>';
							?>
			</td>
		</tr>
		<tr>
			<td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;ID No : <?php echo $metaArray['idNo']; ?></td>
		</tr>
		<tr>
			<td width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Name : <?php echo $metaArray['patientName']; ?></td>
			<td width="120px" style="font-weight:bold; border:1px solid; border-left:none; border-top:none; text-align:left">&nbsp;&nbsp;Age : <?php echo $metaArray['patientAge']; ?></td>
			<td width="120px" style="font-weight:bold; border:1px solid; border-left:none; border-top:none; text-align:left">&nbsp;&nbsp;Gender : <?php echo $metaArray['patientSex']; ?></td>
		</tr>
		<tr>
			<td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Ref By : 
			<?php
				$getRefd = $mysqli->query("select * from doctor where id = '$metaArray[refdId]'");
				$refdArray = $getRefd->fetch_array();
									
				echo $refdArray['doctor_name'];
			?>
			</td>
		</tr>
		<tr>
			<td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Nature of Specimen : Blood</td>
		</tr>
		
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                	<td colspan="2" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
                    <br />
                        LABORATORY REPORT
                    </td>
                </tr>
                <tr>
                <td colspan="2" style="padding-top:20px">
                    <!--<table border="0" width="100%" cellspacing="0">
                    <tr>
                        <td width="35%" style="font-weight:bold; border: 1px solid; padding: 5px">Test</td>
                        <td width="30%" style="font-weight:bold; border: 1px solid; padding: 5px; border-left: none;">Result</td>
                        <td width="35%" style="font-weight:bold; border: 1px solid; padding: 5px; border-left: none;">Reference range</td>
                    </tr>
                    </table>-->
                <?php
			
		$head = '<table border="0" width="100%" cellspacing="0">
                    <tr>
                        <td width="35%" style="font-weight:bold; border: 1px solid; padding: 5px">Test</td>
                        <td width="30%" style="font-weight:bold; border: 1px solid; padding: 5px; border-left: none;">Result</td>
                        <td width="35%" style="font-weight:bold; border: 1px solid; padding: 5px; border-left: none;">Reference range</td>
                    </tr>
                    </table>';

        $head2 = '<table border="0" width="100%" cellspacing="0">
                    <tr>
                        <td width="35%" style="font-weight:bold; border: 1px solid; padding: 5px">Test</td>
                        <td width="65%" style="font-weight:bold; border: 1px solid; padding: 5px; border-left: none;" colspan="2">Result</td>
                    </tr>
                    </table>';

                    $header;
	
                if(is_array($samePage) && sizeof($samePage) > 1){
				
                    foreach($samePage as $index1 => $array1){
						
						$invoice = $mysqli->query("select * from report_content join tests on report_content.testId = tests.testId where report_content.reportContentId in(select reportContentId from report_output where idNo = '$metaArray[idNo]' and pageSl = '$array1') order by report_content.reportContentId asc");
						//echo $metaArray[idNo];
						
						$data = array();
						while($invoiceRow = $invoice->fetch_array()){
							$id = $invoiceRow['testCategoryId'];
							$testId = $invoiceRow['testId'];
							unset($invoiceRow['testCategoryId']);
							$data[$id][] = $invoiceRow;
						}
						$sl = 1;
						?>
                        <ul>
                        <?php

						foreach($data as $id => $values) {
							
							$getCategory = $mysqli->query("select * from test_category where categoryId = '$id'");
							
							if($getCategory->num_rows > 0){
								$categoryArray = $getCategory->fetch_array();
								?>
                                <li>
                                <?php
									echo '<font style="font-size:14pt"><b><u>'.$categoryArray['categoryName'].'</u></b></font>';
									if($id == 29 || $testId == 1217){
										echo $head2;
										$header = false;
									}else{
										echo $head;
										$header = true;
									}
								?>
                                
                                <ul>
                                <?php
                                $invoice->data_seek(0);
                                $rhpid = '';
                                $rhrid = '';
								while($array = $invoice->fetch_array()){

									$r = $mysqli->query("select * from report where reportContentId = '$array[reportContentId]' order by reportId asc");
									echo '<table border=0 width="100%" cellspacing=0 style="font-size:13pt"><tr valign="top">';
									$rid1 = '';
									$pid1 = '';
									while($rows = $r->fetch_array()){
									?>
										<td valign="top" width="<?php echo $rows['columnWidth'] ?>%" style="padding: 5px 0px">
											<?php
											$rhrid = $rows['reportHeaderId'];
											$pid2 = $rhrid;
											if($rows['resultName'] <> '' && $rows['resultName'] <> ':'){
												//echo $rhrid;
												//echo $rhpid;
                                                $rid1 = $rhrid;
                                                $pid1 = $rhpid;
                                                if($rhrid == 0){

                                                }
                                                if($rhrid == $rhpid || $rhrid == 0){

                                                }else{
                                                  $getH = $mysqli->query("select * from report_header where reportHeaderId = '$rhrid'");
                                                  $hArray = $getH->fetch_array();
                                                  echo '<b>',$hArray['reportHeader'],'</b><br/>';
                                                }

                                            }
                                            //echo $rid1;
                                            //echo $pid1;
                                            if($rid1 == $pid1 || ($rows['resultName'] <> '' && $rows['resultName'] <> ':') || $rid1 == 0){
                                            	
                                            }else{
                                            	echo "<br/>";
                                            }

											if($rows['resultName'] <> ''){
												echo $rows['resultName'];
											}
											if($rows['isInput'] == 1){
												$getValue = $mysqli->query("select value from report_output where reportId = '$rows[reportId]' and idNo = '$metaArray[idNo]'");
												$valueArray = $getValue->fetch_array();
												
												if($rows['calculationValue'] <> ''){
													//echo $rows['calculationValue'];
													$operation= $valueArray['value'].$rows['calculationValue'];
													$value=eval("return ($operation);");
													echo sprintf('%.2f',$value);
												}
												if($rows['calculationUnit'] <> ''){
													echo $rows['calculationUnit']. ' = ';
												}
												
												echo $valueArray['value'];
											}
											if($rows['unit'] <> ''){
												echo " ".$rows['unit'];
											}
											if($rows['rangeValue'] <> ''){
												echo $rows['rangeValue'];
											}
											?>
										</td>
										<?php
										if($rows['resultName'] <> '' && $rows['resultName'] <> ':'){
                                            $rhpid = $rhrid;
                                        }
									}
									echo '</tr></table>';
								}
                                ?>
                                </ul>
                                <?php
								//////////////////////////////////////
									
								
								
								//////////////////////////////////////
							}
							if($header == true){
								$head = "";
							}
						}
						?>
                        </ul>
                        <br />
                        <?php
                    }	
                }else{

					//echo $array;
					$invoice = $mysqli->query("select * from report_content join tests on report_content.testId = tests.testId where report_content.reportContentId in(select reportContentId from report_output where idNo = '$metaArray[idNo]' and pageSl = '$array') order by report_content.reportContentId asc");
						
					//echo $invoice->num_rows;
					
					$data = array();
					while($invoiceRow = $invoice->fetch_array()){
						
						$id = $invoiceRow['testCategoryId'];
						$testId = $invoiceRow['testId'];
						unset($invoiceRow['testCategoryId']);
						$data[$id][] = $invoiceRow;
					}
					$sl = 1;
					?>
					<ul>
					<?php
					foreach($data as $id => $values) {
					
						$getCategory = $mysqli->query("select * from test_category where categoryId = '$id'");

						if($getCategory->num_rows > 0){
							$categoryArray = $getCategory->fetch_array();
							?>
							<li>
							<?php
								echo '<font style="font-size:14pt"><b><u>'.$categoryArray['categoryName'].'</u></b></font>';
								if($id == 29 || $testId == 1217){
									echo $head2;
									$header = false;
								}else{
									echo $head;
									$header = true;
								}
							?>
							<ul>
							<?php
                                $invoice->data_seek(0);
                                $rhpid = '';
                                $rhrid = '';
								while($array = $invoice->fetch_array()){

									$r = $mysqli->query("select * from report where reportContentId = '$array[reportContentId]' order by reportId asc");
									echo '<table border=0 width="100%" cellspacing=0 style="font-size:13pt"><tr valign="top">';
									$rid1 = '';
									$pid1 = '';
									while($rows = $r->fetch_array()){
									?>
										<td valign="top" width="<?php echo $rows['columnWidth'] ?>%" style="padding: 5px 0px">
											<?php
											$rhrid = $rows['reportHeaderId'];
											$pid2 = $rhrid;
											if($rows['resultName'] <> '' && $rows['resultName'] <> ':'){
												//echo $rhrid;
												//echo $rhpid;
                                                $rid1 = $rhrid;
                                                $pid1 = $rhpid;
                                                if($rhrid == 0){

                                                }
                                                if($rhrid == $rhpid || $rhrid == 0){

                                                }else{
                                                  $getH = $mysqli->query("select * from report_header where reportHeaderId = '$rhrid'");
                                                  $hArray = $getH->fetch_array();
                                                  echo '<b>',$hArray['reportHeader'],'</b><br/>';
                                                }

                                            }
                                            //echo $rid1;
                                            //echo $pid1;
                                            if($rid1 == $pid1 || ($rows['resultName'] <> '' && $rows['resultName'] <> ':') || $rid1 == 0){
                                            	
                                            }else{
                                            	echo "<br/>";
                                            }
											if($rows['resultName'] <> ''){
												echo $rows['resultName'];
											}
											if($rows['isInput'] == 1){
												$getValue = $mysqli->query("select value from report_output where reportId = '$rows[reportId]' and idNo = '$metaArray[idNo]'");
												$valueArray = $getValue->fetch_array();
												
												if($rows['calculationValue'] <> ''){
													//echo $rows['calculationValue'];
													$operation= $valueArray['value'].$rows['calculationValue'];
													$value=eval("return ($operation);");
													echo sprintf('%.2f',$value);
												}
												if($rows['calculationUnit'] <> ''){
													echo $rows['calculationUnit']. ' = ';
												}
												
												echo $valueArray['value'];
											}
											if($rows['unit'] <> ''){
												echo " ".$rows['unit'];
											}
											if($rows['rangeValue'] <> ''){
												echo $rows['rangeValue'];
											}
											?>
										</td>
										<?php
										if($rows['resultName'] <> '' && $rows['resultName'] <> ':'){
                                            $rhpid = $rhrid;
                                        }
									}
									echo '</tr></table>';
								}
                                ?>
							</ul>
							<?php
							//////////////////////////////////////
								
							
							
							//////////////////////////////////////
						}
						if($header == true){
							$head = "";
						}
					}
					?>
					</ul>
					<?php
				}
                ?>
                </td>
                </tr>
                </table>
                </div>
            </div>
            <?php
			$i++;
		}
		?>
        </div>
        <?php
		
	//}
	
}else{
	header("Location:index.php");	
}
?>