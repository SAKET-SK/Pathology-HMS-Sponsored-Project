<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('connect.php');
date_default_timezone_set('UTC');
$mkdate = mktime(date('H') + 6, date('i'), date('s'));
$date = date('Y-m-d', $mkdate);
$time = date('H:i:s', $mkdate);
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style type="text/css">
    .receipt {
      height: 8.5in;
      width: 11in;
    }
    .output {
      height: 8.5in;
      width: 11in;
      position: absolute;
      top: 0px;
      left: 0px;
    }
	.header-title{
		font-size:20px;
		font-style:italic;
	}
	.address{
		font-size:14px;
		font-style:italic;
	}
	.report-title{
		font-size:14px;
		font-style:italic;
	}
    @media print {
       
      .output {
        -ms-transform: rotate(270deg);
      
        -webkit-transform: rotate(270deg);
      
        transform: rotate(270deg);
        top: 2.5in;
        left: -.6in;
      }
	  #pagi-link, #print_btn{
		  display:none
		}
    }
  </style>
<script>
function load_perpage(perpage, page, searchByDate){
	window.location = 'print_daily_state_refd_report.php?perpage='+perpage+'&page='+page+searchByDate;
}

function load_pagination(page, perpage, searchByDate){
	window.location = 'print_daily_state_refd_report.php?perpage='+perpage+'&page='+page+searchByDate;
}
</script>
</head>

<body>
<?php
if(isset($_GET['perpage'])){
	$perpage = intval($_GET['perpage']);	
}else{
	$perpage = 10;	
}

if(isset($_GET['page'])){
	$page = intval($_GET['page']);	
}else{
	$page = 1;	
}


$searchByDate = "&from_date=$_GET[from_date]&to_date=$_GET[to_date]";

$pagination_order = $mysqli->query("select * from invoice where isCancel = '0' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]' order by invoiceDate asc");
$count_rows = $pagination_order->num_rows;

$total_page = ceil($count_rows / $perpage);
$start = ($page - 1) * $perpage;
?>
  <div class="output">
    <div class="receipt">
    	<div class="print-header">
        	<?php
              $labsql = "SELECT * FROM lab_info WHERE id=1";
              $result = $mysqli->query($labsql); 
              while ($row = $result->fetch_assoc()) {
                echo '<div class="header-title"><b>'.$row['lab_name'].'</b></div><div class="address">'.$row['address'].' </div>';
               }
            ?>
        	
            <div class="report-title">
            	Detail Statement of All Refd. Prof./Dr./C/O
                
               	<?php
				
				if($_GET['from_date'] <> '' && $_GET['to_date']){
					echo " On: ";	
					$n_f_d = new DateTime($_GET['from_date']);	
					$n_t_d = new DateTime($_GET['to_date']);	
					
					echo $n_f_d->format('d<\s\up>S</\s\up> M/Y') ." To ".$n_t_d->format('d<\s\up>S</\s\up> M/Y');
				}else{
					echo "All";	
				}
				?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Printed &nbsp;&nbsp; <?php $dt = new DateTime($date); echo $dt->format('l, M, d, Y'); ?>
            </div>
        </div>
        
        <?php	
		$query = $mysqli->query("select * from invoice where isCancel = '0' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]' order by invoiceDate asc limit $start, $perpage");
		
		if($query->num_rows > 0){
		?>
        <table border="0" width="100%" cellspacing="0" style="font-size:14px">
          <tr>
                <th style="border:1px solid; font-style:italic">Date</th>
                <th style="border:1px solid; border-left:none; font-style:italic">C/O</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Refd. Prof./Dr.</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Patient</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Contact</th>
                <th style="border:1px solid; border-left:none; font-style:italic">SL</th>
                <th style="border:1px solid; border-left:none; font-style:italic">ID</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Rate</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Disc.</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Net.</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Recvd.</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Due</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Refd. Fee.</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Adv. Paid</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Due Fee</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Adv.By</th>
            </tr>
        <?php
			$totalRate = 0;
			$totalDiscount = 0;
			$totalNet = 0;
			$totalPReceive = 0;
			$totalPdue = 0;
			$totalRefdFee = 0;
			$totalRefdAdv = 0;
			$totalRefdDue = 0;
			while($rows = $query->fetch_array()){
				$getCO = $mysqli->query("select * from co where coId = '$rows[coId]'");
				$coArray = $getCO->fetch_array();
				
				$getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
				$refdArray = $getRefd->fetch_array();
				
				$refdFeeAmount = $mysqli->query("select sum(refdFeeAmount) from refdfeeamount where invoiceId = '$rows[invoiceId]'");
				$refdAmountArray = $refdFeeAmount->fetch_array();
				
				$patientPayment = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$rows[invoiceId]'");
				$patientPayArray = $patientPayment->fetch_array();
				
				$patientDuePayment = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$rows[invoiceId]'");
				$patientDuePayArray = $patientDuePayment->fetch_array();
				
				$refdPayment = $mysqli->query("select sum(refdPayAmount), refdPaymentBy from refd_payment where invoiceId = '$rows[invoiceId]'");
				$refdPayArray = $refdPayment->fetch_array();
				
				$writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$rows[invoiceId]'");
				$writeOffArray = $writeOff->fetch_array();
			?>
			<tr>
				<td style="border:1px solid; border-top:none; text-align:center">
				<?php
                    $invoiceDate = new DateTime($rows['invoiceDate']);
                    echo $invoiceDate->format('d-M-y');
                ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none"><?php echo $coArray['coName']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none; width:190px"><?php echo $refdArray['doctor_name']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none"><?php echo $rows['patientName']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none"><?php echo $rows['patientMobile']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo $rows['labDailySl']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo $rows['idNo']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo $rows['totalTestAmount']; ?></td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                <?php
                $get_dis = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
                $dis_array = $get_dis->fetch_array();
                echo $dis_array[0];
                
                ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $net = $rows['totalTestAmount'] - $dis_array[0]; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $pPay = $patientPayArray[0] + $patientDuePayArray[0]; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $patientDue = $net - ($patientPayArray[0] + $patientDuePayArray[0] + $writeOffArray[0]); ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $refdFee = $refdAmountArray[0] - $dis_array[0]; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $refdPayArray[0]; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $refdDue = $refdFee - $refdPayArray[0]; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px">
                    <?php echo $refdPayArray[1]; ?>
                </td>
			</tr>
			<?php			
			$totalRate += $rows['totalTestAmount'];
			$totalDiscount += $dis_array[0];
			$totalNet += $net;
			$totalPReceive += $pPay;
			$totalPdue += $patientDue;
			$totalRefdFee += $refdFee;
			$totalRefdAdv += $refdPayArray[0];
			$totalRefdDue += $refdDue;
			}
		?>
        <tr style="font-weight:bold">
        	<td style="border:1px solid; border-top:none; text-align:right" colspan="7">Total=</td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalRate); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalDiscount); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalNet); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalPReceive); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalPdue); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalRefdFee); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalRefdAdv); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalRefdDue); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none">&nbsp;</td>
        </tr>
        <?php
            if($page == $total_page){
				$tQuery = $mysqli->query("select * from invoice where isCancel = '0' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'");
				
				$totalRate2 = 0;
				$totalDiscount2 = 0;
				$totalNet2 = 0;
				$totalPReceive2 = 0;
				$totalPdue2 = 0;
				$totalRefdFee2 = 0;
				$totalRefdAdv2 = 0;
				$totalRefdDue2 = 0;
				while($rows2 = $tQuery->fetch_array()){
					
					$getCO = $mysqli->query("select * from co where coId = '$rows2[coId]'");
					$coArray = $getCO->fetch_array();
					
					$getRefd = $mysqli->query("select * from doctor where id = '$rows2[refdId]'");
					$refdArray = $getRefd->fetch_array();
					
					$refdFeeAmount = $mysqli->query("select sum(refdFeeAmount) from refdfeeamount where invoiceId = '$rows2[invoiceId]'");
					$refdAmountArray = $refdFeeAmount->fetch_array();
					
					$patientPayment = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$rows2[invoiceId]'");
					$patientPayArray = $patientPayment->fetch_array();
					
					$patientDuePayment = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$rows2[invoiceId]'");
					$patientDuePayArray = $patientDuePayment->fetch_array();
					
					$refdPayment = $mysqli->query("select sum(refdPayAmount), refdPaymentBy from refd_payment where invoiceId = '$rows2[invoiceId]'");
					$refdPayArray = $refdPayment->fetch_array();
					
					$writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$rows2[invoiceId]'");
					$writeOffArray = $writeOff->fetch_array();
					
					$get_dis1 = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$rows2[invoiceId]'") or die($mysqli->error);
	                $dis_array1 = $get_dis1->fetch_array();
					
					$net1 = $rows2['totalTestAmount'] - $dis_array1[0];
					
					$pPay1 = $patientPayArray[0] + $patientDuePayArray[0];
					
					$patientDue1 = $net1 - ($patientPayArray[0] + $patientDuePayArray[0] + $writeOffArray[0]);
					
					$refdFee1 = $refdAmountArray[0] - $dis_array1[0];
					
					$refdDue1 = $refdFee1 - $refdPayArray[0];
					
					$totalRate2 += $rows2['totalTestAmount'];
					$totalDiscount2 += $dis_array1[0];
					$totalNet2 += $net1;
					$totalPReceive2 += $pPay1;
					$totalPdue2 += $patientDue1;
					$totalRefdFee2 += $refdFee1;
					$totalRefdAdv2 += $refdPayArray[0];
					$totalRefdDue2 += $refdDue1;
				}
				?>
                <tr style="font-weight:bold">
                    <td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:right" colspan="7">Grand Total=</td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalRate2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalDiscount2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalNet2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalPReceive2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalPdue2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalRefdFee2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalRefdAdv2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalRefdDue2); ?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center">&nbsp;</td>
                </tr>
		<tr>
		<td colspan="16">
			<table border="0" width="30%" cellspacing="0" style="font-size: 12pt; font-weight: bold;">
        <tr>
            <td width="55%">Total Cash Received</td>
            <td width="1%">:</td>
            <td><?php echo $totalNet = $totalNet2 + 0; ?> Tk.</td>
        </tr>
        <tr>
            <td width="55%">Total Refd Payment</td>
            <td width="1%">:</td>
            <td><?php echo $totalRefdFee = $totalRefdFee2 + 0; ?> Tk.</td>
        </tr>
        <tr>
            <td width="55%" style="border-top: 1px solid">Total Net Cash</td>
            <td width="1%" style="border-top: 1px solid">:</td>
            <td style="border-top: 1px solid"><?php echo $totalCash = $totalNet - $totalRefdFee + 0; ?> Tk.</td>
        </tr>
      </table>
		</td>
		</tr>
                <?php
			}
		?>
      </table>
      <?php
	/*
        $getPay = $mysqli->query("select sum(patientPayAmount) from patient_payment where isCancel = '0' and patientPayDate between '$_GET[from_date]' and '$_GET[to_date]'");
        $payArray = $getPay->fetch_array();

        $getDuePay = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where isCancel = '0' and patientDuePayDate between '$_GET[from_date]' and '$_GET[to_date]'");
        $duePayArray = $getDuePay->fetch_array();

        $refdPayment = $mysqli->query("select sum(refdPayAmount) from refd_payment where isCancel = '0' and refdPayDate between '$_GET[from_date]' and '$_GET[to_date]'");
        $refdPayArray = $refdPayment->fetch_array();
	*/
      ?>
      
      	<div style="margin-left:5%">
            Per page <input type="text" id="perpage" value="<?php echo $perpage; ?>" onChange="load_perpage(this.value,<?php echo $page; ?>,'<?php echo $searchByDate; ?>')" onFocus="this.select()" style="width:30px; padding:4px; border:1px solid #060; text-align:center" />
            <?php
            if($page <= 1){
        
            }else{
                $j = $page - 1;
                ?>
                <span id="pagi-link">
                    <button id="<?php echo $j; ?>" onClick="load_pagination(this.id,<?php echo $perpage; ?>,'<?php echo $searchByDate; ?>')" style="padding:4px; background-color:#CCC; color:#000; font-weight:bold; cursor:pointer">Prev</button>
                </span>
                <?php
            }
            ?>
            <select id="select-pagi-link" onChange="load_pagination(this.value,<?php echo $perpage; ?>,'<?php echo $searchByDate; ?>')" style="width:150px; padding:4px; border:1px solid #060">
            <?php
                for ($i=1; $i <= $total_page; $i++) { 
                ?>
                    <option value="<?php echo $i; ?>" <?php if($i == $page){ echo "selected = 'selected'";} ?>><?php echo "Page ".$i. " of ". $total_page; ?></option>
                <?php
                }
            ?>
            </select>
            <?php
            if($page == $total_page){
        
            }else{
                $j = $page + 1;
                ?>
                <span id="pagi-link">
                    <button id="<?php echo $j; ?>" onClick="load_pagination(this.id,<?php echo $perpage; ?>,'<?php echo $searchByDate; ?>')" style="padding:4px; background-color:#CCC; color:#000; font-weight:bold; cursor:pointer">Next</button>
                </span>
                <?php
            }
            ?>
        </div>
        <center><button onClick="window.print()" id="print_btn" style="padding:5px 15px; font-weight:bold">Print</button></center>
	  <?php
      }else{
			echo "<hr><font size='+1'>Data Not Found</font>";  
		}
		?>
    </div>
  </div>
</body>

</html>
<?php
}else{
	header("Location:index.php");	
}
?>