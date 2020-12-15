<?php
ob_start();
@session_start(); 
if(!isset($_SESSION['userId'])){
	header("Location:index.php");
}
else
{
?>

<html>
<head>
	<title>Receipt</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
	/*.back_btn{
		padding:5px;
		text-decoration:none;
		color:#FFF;
		background:#660;
	}
	.back_btn:hover{
		background:#F90;
		color:#FFF;
	}*/
	#memo{
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
	
	#invoice_1{
		width:700px;
		height:792px;
	}
	#invoice_2{
		width:700px;
		height:792px;
		display:none;
	}
	
</style>
<style media="print">
	#invoice_2{
		display:inline-table;
	}

	#print_btn{
		display:none;
	}
</style>
</head>
</html>
<?php
	require_once('connect.php');
	date_default_timezone_set('UTC');
	$mktime = mktime(date("H")+6, date("i"), date("s"));
	$date = date('Y-m-d',$mktime);
	$time = date('H:i:s', $mktime);
	
	
	
		//$query = $mysqli->query("select * from invoice where invoiceId = '112'");
		
		$getId = $_GET['id'];

		$query = $mysqli->query("select * from invoice where invoiceId = '$getId'");
		
		$array = $query->fetch_array();
		
		$invoiceId = $array['invoiceId'];
		$refdId = $array['refdId'];
		$coId = $array['coId'];

		
		if($query)
		{
			
			$invoice = $mysqli->query("select * from invoice_tests join tests on invoice_tests.testId = tests.testId where invoice_tests.invoiceId = '$invoiceId' order by invoice_tests.invoiceTestId asc");
			
			$count = $invoice->num_rows;
			
			if($count > 0){
				
				$getPay = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$invoiceId'");
				$payArray = $getPay->fetch_array();

				$getDuePay = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$invoiceId'");
            	$duePayArray = $getDuePay->fetch_array();

				$getDis = $mysqli->query("select sum(disPersent) from patient_discount where invoiceId = '$invoiceId'");
				$disArray = $getDis->fetch_array();

				$getDisTk = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$invoiceId'");
				$disTkArray = $getDisTk->fetch_array();

                $cashBack = $mysqli->query("select sum(cashBackAmount) from cash_back where invoiceId = '$invoiceId'");
                $cashBackArray = $cashBack->fetch_array();

				?>
                <center><button onclick="window.print()" id="print_btn" style="padding:5px 15px; font-weight:bold">Print</button></center>
                <div id="main_page">
                <?php
				
				$invoiceSl = 1;
				?>
                
                
                <!--------- Start Invoice Part 1 ---------->
                
                <div id="invoice_<?php echo $invoiceSl; ?>">
                    	<div id="memo">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                    	<td colspan="5" style="padding-bottom:10px">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" width="100">&nbsp;</td>
                                    <?php
                                      $labsql = "SELECT * FROM lab_info WHERE id=1";
                                      $result = $mysqli->query($labsql); 
                                      while ($row = $result->fetch_assoc()) {
                                        echo '<td align="center" valign="top"><font style="font-size:18px; font-weight:bold">'.$row['lab_name'].'</font><br />
                                            <font style="font-size:12px">'.$row['address'].'<br />Mob: '.$row['contact'].'</font></td>';
                                       }
                                    ?>
                                    <td valign="top" align="center">
                                    <font style="font-size:16px; font-weight:bold">Cash Receipt</font><br />
                                    <font style="font-size:16px; font-weight:bold; text-decoration:underline">Patient's Copy</font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="5">
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                            	<td width="65%" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            		<tr>
                                    	<td width="150px">Name of Patient</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientName']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td width="110px">Age</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientAge']; ?></td>
                                   </tr>
                                   <tr>
                                   		<td width="110px">Sex</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientSex']; ?></td>
                                   </tr>
                                   <tr>
                                    	<td width="110px">Refd.By</td>
                                        <td width="10px">:</td>
                                        <td style="font-size:12px">
										<?php
											$getRefd2 = $mysqli->query("select * from doctor where id = '$refdId'");
											$refdArray2 = $getRefd2->fetch_array();
											echo $refdArray2['doctor_name'];
										?>
                                        </td>
                                   </tr>
                                    </table>
                               	</td>
                                
                                <td width="40%" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                    <tr>
                                    	<td width="80px" align="left">SL No</td>
                                        <td width="10px">:</td>
                                        <td align="right"><?php echo $array['labDailySl']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td width="80px" align="left">Patient's ID</td>
                                        <td width="10px">:</td>
                                        <td align="right"><?php echo $array['idNo']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Date</td>
                                        <td width="10px">:</td>
                                        <td align="right">
                                        <?php 
                                            $invDate = new DateTime($array['invoiceDate']);
											$invTime = new DateTime($array['invoiceTime']);
                                            echo $invDate->format('d/m/Y');
											echo ",&nbsp;&nbsp;";
											echo $invTime->format('h:i:s A');
                                        ?>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="font-weight:bold; font-style:italic; text-align:center; font-size:14px">
                        <td style="border:1px solid #000; border-right:none" width="10%">SL.</td>
                        <td width="40%" style="border:1px solid #000; border-right:none">Advice</td>
                        <td width="15%" style="border:1px solid #000; border-right:none">Amount</td>
                        <td width="10%" style="border:1px solid #000; border-right:none">Dis(%)</td>
                        <td width="15%" style="border:1px solid #000">Total Amount</td>
                    </tr>
                    <?php
						$sl = 1;
						$totalAmount = 0;
						$totalDisP = 0;
						while($partOneRow = $invoice->fetch_array()){
							$tA = $partOneRow['rate'] - ($partOneRow['discount'] * $partOneRow['rate'])/100;
						?>
                        <tr style="font-size:14px">
                        	<td style="padding:3px" align="center"><?php echo $sl; ?></td>
                        	<td width="300px" style="padding:3px 7px"><?php echo $partOneRow['testName']; ?></td>
                            <td align="center"><?php echo sprintf('%.2f',$partOneRow['rate']); ?></td>
                            <td align="center"><?php echo $partOneRow['discount']; ?></td>
                            <td align="right"><?php echo sprintf('%.2f',$tA); ?></td>
                        </tr>
                        <?php	
						$totalAmount += $tA;
						$totalDisP += $partOneRow['discount'];
						$sl++;
						}
						?>
                        <tr>
                            <td colspan="5" style="border-top:1px solid">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                <tr>
                                    <td width="60%" valign="top" style="padding:2px">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:normal; font-size:12px" colspan="3" align="left">
                                            ** বিশেষ কারণে পরীক্ষা নিরীক্ষা ও রিপোর্ট ডেলিভারি বিলম্ব হতে পারে।<br />
                                            ** রিপোর্ট ডেলিভারির সময় এই মেমো অবশ্যই নিয়ে আসতে হবে।
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">Prepd. By</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px"><?php echo $array['invoiceBy']; ?></td>
                                        </tr>
                                        </table>
                                    </td>
                                    <td valign="top" style="padding:2px">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                        <tr>
                                        	<td width="200px" style="font-weight:bold">Gross Total</td>
                                            <td width="10px">:</td>
                                            <td width="150px" align="right"><?php echo sprintf('%.2f',ceil($totalAmount)); ?></td>
                                        </tr>
                                        <?php
                                        if($totalDisP > 0){
                                        ?>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Paid</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													echo sprintf('%.2f',$payArray[0] + $duePayArray[0] - $cashBackArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Due</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													$totalDue = ceil($totalAmount) - ($payArray[0] + $duePayArray[0] - $cashBackArray[0]);
													echo sprintf('%.2f',$totalDue);
												?>
                                            </td>
                                        </tr>
                                        <?php
                                        }else{
                                        ?>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold">Discount(%)</td>
                                            <td width="10px">:</td>
                                            <td width="150px" align="right">
												<?php
													echo sprintf('%.2f',$disArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold">Discount(Tk)</td>
                                            <td width="10px">:</td>
                                            <td width="150px" align="right">
												<?php
													echo sprintf('%.2f',$disTkArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Net Total</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													$netTotal = ceil($totalAmount - $disTkArray[0]);
													echo sprintf('%.2f',$netTotal);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Paid</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													
													echo sprintf('%.2f',$payArray[0] + $duePayArray[0] - $cashBackArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Due</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													$totalDue = $netTotal - ($payArray[0] + $duePayArray[0] - $cashBackArray[0]);
													echo sprintf('%.2f',$totalDue);
												?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="font-size:18px; font-weight:bold">
                                    <?php
                                    if($totalDue > 0){
                                        echo "Due";	
                                    }else{
                                        echo "Paid";	
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="5" style="padding-top:0px">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                    <tr>
                                    	<td colspan="2" align="left"><b>Delivery Date:
                                    	<?php
                                    		echo $array['deli_time'];
                                    	?></b></td>
                                    </tr>
                                    <tr>
                                    	<td align="left"><u><b>Report Delivered By</b></u></td>
                                        <td align="right"><u><b>Authorized Signature</b></u></td>
                                    </tr>
                                    </table>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        
                        </table>
                        </div>
                    </div>
                
                
                <!------------------------------End Invoice Part 1--------------------------->
                
                <!------------------------Start Invoice Part 2-------------------------------->
                <?php
				$isl0 = $invoiceSl + 1;	
				?>
                <div id="invoice_<?php echo $isl0; ?>">
                    	<div id="memo">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                    	<td colspan="5" style="padding-bottom:10px">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" width="100">&nbsp;</td>
                                   <?php
                                      $labsql = "SELECT * FROM lab_info WHERE id=1";
                                      $result = $mysqli->query($labsql); 
                                      while ($row = $result->fetch_assoc()) {
                                        echo '<td align="center" valign="top"><font style="font-size:18px; font-weight:bold">'.$row['lab_name'].'</font><br />
                                            <font style="font-size:12px">'.$row['address'].'<br />Mob: '.$row['contact'].'</font></td>';
                                       }
                                    ?>
                                    <td valign="top" align="center">
                                    <font style="font-size:16px; font-weight:bold">Cash Receipt</font><br />
                                    <font style="font-size:16px; font-weight:bold; text-decoration:underline">Office Copy</font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="5">
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                            	<td width="65%" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            		<tr>
                                    	<td width="150px">Name of Patient</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientName']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td width="110px">Age</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientAge']; ?></td>
                                   </tr>
                                   <tr>
                                   		<td width="110px">Sex</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientSex']; ?></td>
                                   </tr>
                                   <tr>
                                    	<td width="110px">Refd.By</td>
                                        <td width="10px">:</td>
                                        <td style="font-size:12px">
										<?php
											$getRefd2 = $mysqli->query("select * from doctor where id = '$refdId'");
											$refdArray2 = $getRefd2->fetch_array();
											echo $refdArray2['doctor_name'];
										?>
                                        </td>
                                   </tr>
                                    </table>
                               	</td>
                                
                                <td width="40%" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                    <tr>
                                    	<td width="80px" align="left">SL No</td>
                                        <td width="10px">:</td>
                                        <td align="right"><?php echo $array['labDailySl']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td width="80px" align="left">Patient's ID</td>
                                        <td width="10px">:</td>
                                        <td align="right"><?php echo $array['idNo']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Date</td>
                                        <td width="10px">:</td>
                                        <td align="right">
                                        <?php 
                                            $invDate = new DateTime($array['invoiceDate']);
											$invTime = new DateTime($array['invoiceTime']);
                                            echo $invDate->format('d/m/Y');
											echo ",&nbsp;&nbsp;";
											echo $invTime->format('h:i:s A');
                                        ?>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="font-weight:bold; font-style:italic; text-align:center; font-size:14px">
                        <td style="border:1px solid #000; border-right:none" width="10%">SL.</td>
                        <td width="50%" style="border:1px solid #000; border-right:none">Advice</td>
                        <td width="15%" style="border:1px solid #000; border-right:none">Amount</td>
                        <td width="10%" style="border:1px solid #000; border-right:none">Dis(%)</td>
                        <td width="15%" style="border:1px solid #000">Total Amount</td>
                    </tr>
                    <?php
						$invoice->data_seek(0);
						$sl = 1;
						$totalAmount = 0;
						$totalDisP = 0;
						while($partTwoRow = $invoice->fetch_array()){
							$tA = $partTwoRow['rate'] - ($partTwoRow['discount'] * $partTwoRow['rate'])/100;
						?>
                        <tr style="font-size:14px">
                        	<td style="padding:3px" align="center"><?php echo $sl; ?></td>
                        	<td width="600px" style="padding:3px 7px"><?php echo $partTwoRow['testName']; ?></td>
                            <td align="center"><?php echo sprintf('%.2f',$partTwoRow['rate']); ?></td>
                            <td align="center"><?php echo $partTwoRow['discount']; ?></td>
                            <td align="right"><?php echo sprintf('%.2f',$tA); ?></td>
                        </tr>
                        <?php	
						$totalAmount += $tA;
						$totalDisP += $partTwoRow['discount'];
						$sl++;
						}
						?>
                        <tr>
                            <td colspan="5" style="border-top:1px solid">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                <tr>
                                    <td width="60%" valign="top" style="padding:2px">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">Contact</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px"><?php echo $array['patientMobile']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">C/O</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px">
												<?php
													$getCO2 = $mysqli->query("select * from co where coId = '$coId'");
													$coArray2 = $getCO2->fetch_array();
												 	echo $coArray2['coName'];
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">Prepd. By</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px"><?php echo $array['invoiceBy']; ?></td>
                                        </tr>
                                        </table>
                                    </td>
                                    <td valign="top" style="padding:2px">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                        <tr>
                                        	<td width="200px" style="font-weight:bold">Gross Total</td>
                                            <td width="10px">:</td>
                                            <td width="150px" align="right"><?php echo sprintf('%.2f',ceil($totalAmount)); ?></td>
                                        </tr>
                                        <?php
                                        if($totalDisP > 0){
                                        ?>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Paid</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													echo sprintf('%.2f',$payArray[0] + $duePayArray[0] - $cashBackArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Due</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													$totalDue = ceil($totalAmount) - ($payArray[0] + $duePayArray[0] - $cashBackArray[0]);
													echo sprintf('%.2f',$totalDue);
												?>
                                            </td>
                                        </tr>
                                        <?php
                                        }else{
                                        ?>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold">Discount(%)</td>
                                            <td width="10px">:</td>
                                            <td width="150px" align="right">
												<?php
													echo sprintf('%.2f',$disArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold">Discount(Tk)</td>
                                            <td width="10px">:</td>
                                            <td width="150px" align="right">
												<?php
													echo sprintf('%.2f',$disTkArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Net Total</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													$netTotal = ceil($totalAmount - $disTkArray[0]);
													echo sprintf('%.2f',$netTotal);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Paid</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													
													echo sprintf('%.2f',$payArray[0] + $duePayArray[0] - $cashBackArray[0]);
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="200px" style="font-weight:bold; border-top:1px solid">Due</td>
                                            <td width="10px" style="border-top:1px solid">:</td>
                                            <td width="150px" align="right" style="border-top:1px solid">
												<?php
													$totalDue = ceil($netTotal) - ($payArray[0] + $duePayArray[0] - $cashBackArray[0]);
													echo sprintf('%.2f',$totalDue);
												?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="font-size:18px; font-weight:bold">
                                    <?php
                                    if($totalDue > 0){
                                        echo "Due";	
                                    }else{
                                        echo "Paid";	
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="5" style="padding-top:25px">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                    <tr>
                                    	<td colspan="2" align="left"><b>Delivery Date: 
                                    	<?php
                                    		echo $array['deli_time'];
                                    	?>
                                    	</b></td>
                                    </tr>
                                    <tr>
                                    	<td align="left"><u><b>Report Delivered By</b></u></td>
                                        <td align="right"><u><b>Authorized Signature</b></u></td>
                                    </tr>
                                    </table>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        
                        </table>
                        </div>
                    </div>
                
                <!------------------------------------------End Invoice Part 2------------------------>
                
                <?php
				$isl = $isl0 + 1;
				
				$invoice->data_seek(0);
				$data = array();
				while($invoiceRow = $invoice->fetch_array()){
					
					$id = $invoiceRow['testCategoryId'];
					unset($invoiceRow['testCategoryId']);
					$data[$id][] = $invoiceRow;
				}
				foreach($data as $id => $values) {
					
					$getCategory = $mysqli->query("select * from test_category where categoryId = '$id' and is_path = '0'");
					if($getCategory->num_rows > 0){
						$categoryArray = $getCategory->fetch_array();
					?>
                    <style>
					#invoice_<?php echo $isl; ?>{
						width:700px;
						height:792px;
						display:none;
					}
					</style>
                    <style media="print">
						#back_btn, #print_btn{
							display:none;
						}
						#invoice_<?php echo $isl; ?>{
							display:inline-table;
						}
					
					</style>
                    <div id="invoice_<?php echo $isl; ?>">
                    	<div id="memo">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                    	<td colspan="5" style="padding-bottom:10px">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top" width="450px">
                                        <?php
                                      $labsql = "SELECT * FROM lab_info WHERE id=1";
                                      $result = $mysqli->query($labsql); 
                                      while ($row = $result->fetch_assoc()) {
                                        echo '<font style="font-size:18px; font-weight:bold">'.$row['lab_name'].'</font>';
                                       }
                                    ?>
                                    </td>
                                    <td valign="top" align="right"><font style="font-size:14px; font-weight:bold; text-decoration:underline"><?php echo $categoryArray['categoryName']; ?></font></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="5">
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                            	<td width="65%" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            		<tr>
                                    	<td width="150px">Name of Patient</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientName']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td width="110px">Age</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientAge']; ?></td>
                                   </tr>
                                   <tr>
                                   		<td width="110px">Sex</td>
                                        <td width="10px">:</td>
                                        <td><?php echo $array['patientSex']; ?></td>
                                   </tr>
                                   <tr>
                                    	<td width="110px">Refd.By</td>
                                        <td width="10px">:</td>
                                        <td style="font-size:12px">
										<?php
											$getRefd2 = $mysqli->query("select * from doctor where id = '$array[refdId]'");
											$refdArray2 = $getRefd2->fetch_array();
											echo $refdArray2['doctor_name'];
										?>
                                        </td>
                                   </tr>
                                    </table>
                               	</td>
                                
                                <td width="40%" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                    <tr>
                                    	<td width="80px" align="left">SL No</td>
                                        <td width="10px">:</td>
                                        <td align="right"><?php echo $array['labDailySl']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td width="80px" align="left">Patient's ID</td>
                                        <td width="10px">:</td>
                                        <td align="right"><?php echo $array['idNo']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Date</td>
                                        <td width="10px">:</td>
                                        <td align="right">
                                        <?php 
                                            $invDate = new DateTime($array['invoiceDate']);
											$invTime = new DateTime($array['invoiceTime']);
                                            echo $invDate->format('d/m/Y');
											echo ",&nbsp;&nbsp;";
											echo $invTime->format('h:i:s A');
                                        ?>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="font-weight:bold; font-style:italic; text-align:center; font-size:14px">
                        <td style="border:1px solid #000; border-right:none" width="10%">SL.</td>
                        <td width="50%" style="border:1px solid #000; border-right:none">Advice</td>
                        <td width="15%" style="border:1px solid #000; border-right:none">Amount</td>
                        <td width="10%" style="border:1px solid #000; border-right:none">Dis(%)</td>
                        <td width="15%" style="border:1px solid #000">Total Amount</td>
                    </tr>
                    <?php
						$sl = 1;
						$totalAmount = 0;
						$totalDisP = 0;
						foreach($values as $field) {
							$tA = $field[7] - ($field[3] * $field[7])/100;
						?>
                        <tr style="font-size:14px">
                        	<td style="padding:3px" align="center"><?php echo $sl; ?></td>
                        	<td width="600px" style="padding:3px 7px"><?php echo $field[6]; ?></td>
                            <td align="center"><?php echo sprintf('%.2f',$field[7]); ?></td>
                            <td align="center"><?php echo $field[3]; ?></td>
                            <td align="right"><?php echo sprintf('%.2f',$tA); ?></td>
                        </tr>
                        <?php	
						$totalAmount += $tA;
						$totalDisP += $field[3];
						$sl++;
						}
						?>
                        <tr>
                            <td colspan="5" style="border-top:1px solid">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                <tr>
                                    <td width="65%" valign="top" style="padding:2px">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">Contact</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px"><?php echo $array['patientMobile']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">C/O</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px">
												<?php
													$getCO2 = $mysqli->query("select * from co where coId = '$array[coId]'");
													$coArray2 = $getCO2->fetch_array();
												 	echo $coArray2['coName'];
												?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td width="60px" style="padding:2px; font-weight:bold">Prepd. By</td>
                                            <td width="10px">:</td>
                                            <td width="250px" style="padding:2px"><?php echo $array['invoiceBy']; ?></td>
                                        </tr>
                                        </table>
                                    </td>
                                    <td valign="top" style="padding:2px">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                        <tr>
                                        	<td style="font-weight:bold">Total</td>
                                            <td width="10px">:</td>
                                            <td width="180px" align="right"><?php echo sprintf('%.2f',ceil($totalAmount)); ?></td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="3" style="padding-top:25px">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                                    <tr>
                                    	<td align="left"><u><b>Report Delivered By</b></u></td>
                                        <td align="right"><u><b>Authorized Signature</b></u></td>
                                    </tr>
                                    </table>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        
                        </table>
                        </div>
                    </div>
                    <?php
					$isl++;
					}
				}
				?>
                </div>
                <?php
			}
			
			$invoice2 = $mysqli->query("select * from invoice_tests join tests on invoice_tests.testId = tests.testId where invoice_tests.invoiceId = '$invoiceId' and tests.testCategoryId in(select categoryId from test_category where is_path = '1') order by  invoice_tests.invoiceTestId asc");
			
			$count2 = $invoice2->num_rows;
			
			if($count2){
				$isl1 = $isl + 1;
			?>
            <style>
			#invoice_<?php echo $isl1; ?>{
				width:700px;
				height:792px;
				display:none;
			}
			</style>
			<style media="print">
				#invoice_<?php echo $isl1; ?>{
					display:inline-table;
				}
			
			</style>
            <div id="main_page">
            <div id="invoice_<?php echo $isl1; ?>">
                <div id="memo">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                <td colspan="5" style="padding-bottom:10px">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" valign="top" width="450px">
                                <?php
                                      $labsql = "SELECT * FROM lab_info WHERE id=1";
                                      $result = $mysqli->query($labsql); 
                                      while ($row = $result->fetch_assoc()) {
                                        echo '<font style="font-size:18px; font-weight:bold">'.$row['lab_name'].'</font>';
                                       }
                                    ?>
                            </td>
                            <td valign="top" align="right">
                            	<font style="font-size:16px; font-weight:bold"><u>Pathology</u></font>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="65%" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            <tr>
                                <td width="150px">Name of Patient</td>
                                <td width="10px">:</td>
                                <td><?php echo $array['patientName']; ?></td>
                            </tr>
                            <tr>
                                <td width="110px">Age</td>
                                <td width="10px">:</td>
                                <td><?php echo $array['patientAge']; ?></td>
                           </tr>
                           <tr>
                                <td width="110px">Sex</td>
                                <td width="10px">:</td>
                                <td><?php echo $array['patientSex']; ?></td>
                           </tr>
                           <tr>
                                <td width="110px">Refd.By</td>
                                <td width="10px">:</td>
                                <td style="font-size:12px">
                                <?php
                                    $getRefd2 = $mysqli->query("select * from doctor where id = '$array[refdId]'");
                                    $refdArray2 = $getRefd2->fetch_array();
                                    echo $refdArray2['doctor_name'];
                                ?>
                                </td>
                           </tr>
                            </table>
                        </td>
                        
                        <td width="40%" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            <tr>
                                <td width="80px" align="left">SL No</td>
                                <td width="10px">:</td>
                                <td align="right"><?php echo $array['labDailySl']; ?></td>
                            </tr>
                            <tr>
                                <td width="80px" align="left">Patient's ID</td>
                                <td width="10px">:</td>
                                <td align="right"><?php echo $array['idNo']; ?></td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td width="10px">:</td>
                                <td align="right">
                                <?php 
                                    $invDate = new DateTime($array['invoiceDate']);
                                    $invTime = new DateTime($array['invoiceTime']);
                                    echo $invDate->format('d/m/Y');
                                    echo ",&nbsp;&nbsp;";
                                    echo $invTime->format('h:i:s A');
                                ?>
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            <tr style="font-weight:bold; font-style:italic; text-align:center; font-size:14px">
                <td style="border:1px solid #000; border-right:none" width="10%">SL.</td>
                <td width="50%" style="border:1px solid #000; border-right:none">Advice</td>
                <td width="15%" style="border:1px solid #000; border-right:none">Amount</td>
                <td width="10%" style="border:1px solid #000; border-right:none">Dis(%)</td>
                <td width="15%" style="border:1px solid #000">Total Amount</td>
            </tr>
            <?php
                $invoice->data_seek(0);
                $sl = 1;
                $totalAmount = 0;
                $totalDisP = 0;
                while($partThreeRow = $invoice2->fetch_array()){
                	$tA = $partThreeRow['rate'] - ($partThreeRow['discount'] * $partThreeRow['rate'])/100;
                ?>
                <tr style="font-size:14px">
                    <td style="padding:3px" align="center"><?php echo $sl; ?></td>
                    <td width="600px" style="padding:3px 7px"><?php echo $partThreeRow['testName']; ?></td>
                    <td align="center"><?php echo sprintf('%.2f',$partThreeRow['rate']); ?></td>
                    <td align="center"><?php echo $partThreeRow['discount']; ?></td>
                    <td align="right"><?php echo sprintf('%.2f',$tA); ?></td>
                </tr>
                <?php	
                $totalAmount += $tA;
                $totalDisP += $partThreeRow['discount'];
                $sl++;
                }
                ?>
                <tr>
                    <td colspan="5" style="border-top:1px solid">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                    <tr>
                        <td width="65%" valign="top" style="padding:2px">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            <tr>
                                <td width="60px" style="padding:2px; font-weight:bold">Contact</td>
                                <td width="10px">:</td>
                                <td width="250px" style="padding:2px"><?php echo $array['patientMobile']; ?></td>
                            </tr>
                            <tr>
                                <td width="60px" style="padding:2px; font-weight:bold">C/O</td>
                                <td width="10px">:</td>
                                <td width="250px" style="padding:2px">
                                    <?php
                                        $getCO2 = $mysqli->query("select * from co where coId = '$coId'");
                                        $coArray2 = $getCO2->fetch_array();
                                        echo $coArray2['coName'];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px" style="padding:2px; font-weight:bold">Prepd. By</td>
                                <td width="10px">:</td>
                                <td width="250px" style="padding:2px"><?php echo $array['invoiceBy']; ?></td>
                            </tr>
                            </table>
                        </td>
                        <td valign="top" style="padding:2px">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                            <tr>
                                <td style="font-weight:bold">Total</td>
                                <td width="10px">:</td>
                                <td width="180px" align="right"><?php echo sprintf('%.2f',ceil($totalAmount)); ?></td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding-top:25px">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px">
                        <tr>
                            <td align="left"><u><b>Report Delivered By</b></u></td>
                            <td align="right"><u><b>Authorized Signature</b></u></td>
                        </tr>
                        </table>
                        </td>
                    </tr>
                    </table>
                </td>
                </tr>
                
                </table>
                </div>
            </div>
            </div>
            <?php	
			}
			
			
		}
	
	
}
?>

