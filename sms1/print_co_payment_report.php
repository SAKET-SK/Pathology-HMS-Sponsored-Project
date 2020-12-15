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
        /* IE 9 */
        -webkit-transform: rotate(270deg);
        /* Chrome, Safari, Opera */
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
	window.location = 'print_co_payment_report.php?perpage='+perpage+'&page='+page+searchByDate;
}

function load_pagination(page, perpage, searchByDate){
	window.location = 'print_co_payment_report.php?perpage='+perpage+'&page='+page+searchByDate;
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

$refdName = $_GET['refdName'];

$query = $mysqli->query("select * from co where coName = '$refdName'");
$refdArray = $query->fetch_array();

$refdId = $refdArray['coId'];

if($_GET['from_date'] <> '' && $_GET['to_date'] <> ''){
	$condition = "where coId = '$refdId' and isCancel = '0' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'";
	$condition2 = "where invoice.coId = '$refdId' and invoice.isCancel = '0' and invoice.invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'";
	$searchByDate = "&from_date=$_GET[from_date]&to_date=$_GET[to_date]&refdName=$refdName";
}else{
	$condition = "where coId = '$refdId' and isCancel = '0'";	
	$condition2 = "where invoice.coId = '$refdId' and invoice.isCancel = '0'";	
	$searchByDate = "&refdName=$refdName";
}

$pagination_order = $mysqli->query("select * from invoice $condition") or die($mysqli->error);
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
            	CO Work Report <b>"<?php echo $refdName; ?>"</b>
                
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
            </div>
        </div>
        
        <?php	
		$query = $mysqli->query("select * from invoice $condition order by invoiceId desc limit $start, $perpage");
		
		if($query->num_rows > 0){
		?>
        <table border="0" width="100%" cellspacing="0" style="font-size:14px">
          <tr>
                <th style="border:1px solid; font-style:italic">SL</th>
                <th style="border:1px solid; border-left:none; font-style:italic">ID</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Name</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Mobile</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Refd By</th>
                <th style="border:1px solid; border-left:none; font-style:italic">C/O</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Invoice Amount</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Received</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Refd Amount</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Refd Paid</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Date</th>
            </tr>
        <?php
			$sl = $start + 1;
			$totalInvoiceAmount = 0;
			$totalReceived = 0;
			$totalRefdAmount = 0;
            $totalRefdPaid = 0;

			while($rows = $query->fetch_array()){
				
                $invoiceId = $rows['invoiceId'];

                $getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
                $refdArray = $getRefd->fetch_array();

                $pay = $mysqli->query("SELECT SUM(patientPayAmount) FROM patient_payment WHERE invoiceId = '$invoiceId'");
                $payArray = $pay->fetch_array();

                $duePay = $mysqli->query("SELECT SUM(patientDuePayAmount) FROM patient_due_payment WHERE invoiceId = '$invoiceId'");
                $duePayArray = $duePay->fetch_array();

                $refdAmount = $mysqli->query("SELECT refdFeeAmount FROM refdfeeamount WHERE invoiceId = '$invoiceId'");
                $refdAmountArray = $refdAmount->fetch_array();

                $disAmount = $mysqli->query("SELECT SUM(disAmount) FROM patient_discount WHERE invoiceId = '$invoiceId'");
                $disAmountArray = $disAmount->fetch_array();
                
                $refdfeeamount = $refdAmountArray[0] - $disAmountArray[0];
                
                $refdPaid = $mysqli->query("SELECT SUM(refdPayAmount), coId, COUNT(*) FROM refd_payment WHERE invoiceId = '$invoiceId'");

                $refdPaidArray = $refdPaid->fetch_array();

                $refdDueAmount = $refdfeeamount - $refdPaidArray[0];

                $date = new DateTime($rows['invoiceDate'].$rows['invoiceTime']);

                $payAmount = $payArray[0] + $duePayArray[0];

                $writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$invoiceId'");
                $writeOffArray = $writeOff->fetch_array();
                
                $cashBack = $mysqli->query("select sum(cashBackAmount) from cash_back where invoiceId = '$invoiceId'");
                $cashBackArray = $cashBack->fetch_array();

                $invAmount = $rows['totalTestAmount'] - ($disAmountArray[0] + $writeOffArray[0] - $cashBackArray[0]);
			?>
			<tr>
				<td style="border:1px solid; border-top:none; text-align:center"><?php echo $sl; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none"><?php echo $rows['idNo']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $rows['patientName']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $rows['patientMobile']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $refdArray['doctor_name']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $refdName; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$invAmount); ?></td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                	<?php echo $payAmount; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $refdfeeamount; ?>
                </td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                    <?php echo $refdPaidArray[0]; ?>
                </td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px">
					<?php
						echo $date->format('d-m-Y');
					?>
				</td>
			</tr>
			<?php
			$totalInvoiceAmount += $invAmount;
			$totalReceived += $payAmount;
			$totalRefdAmount += $refdfeeamount;
            $totalRefdPaid += $refdPaidArray[0];
			$sl++;
			}
		?>
        <tr style="font-weight:bold">
        	<td style="border:1px solid; border-top:none; text-align:right" colspan="6">Total=</td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalInvoiceAmount); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalReceived); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalRefdAmount); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                <?php echo sprintf('%.2f',$totalRefdPaid); ?>
            </td>
            <td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px">
                &nbsp;
            </td>
        </tr>
        <?php
            if($page == $total_page){
				
				$totalQuery = $mysqli->query("select * from invoice $condition") or die($mysqli->error);
				
				$totalInvoiceAmount2 = 0;
                $totalReceived2 = 0;
                $totalRefdAmount2 = 0;
                $totalRefdPaid2 = 0;
				while($array = $totalQuery->fetch_array()){
					
                    $invoiceId = $array['invoiceId'];

                    $pay = $mysqli->query("SELECT SUM(patientPayAmount) FROM patient_payment WHERE invoiceId = '$invoiceId'");
                    $payArray = $pay->fetch_array();

                    $duePay = $mysqli->query("SELECT SUM(patientDuePayAmount) FROM patient_due_payment WHERE invoiceId = '$invoiceId'");
                    $duePayArray = $duePay->fetch_array();

                    $refdAmount = $mysqli->query("SELECT refdFeeAmount FROM refdfeeamount WHERE invoiceId = '$invoiceId'");
                    $refdAmountArray = $refdAmount->fetch_array();

                    $disAmount = $mysqli->query("SELECT SUM(disAmount) FROM patient_discount WHERE invoiceId = '$invoiceId'");
                    $disAmountArray = $disAmount->fetch_array();
                    
                    $refdfeeamount = $refdAmountArray[0] - $disAmountArray[0];
                    
                    $refdPaid = $mysqli->query("SELECT SUM(refdPayAmount), coId, COUNT(*) FROM refd_payment WHERE invoiceId = '$invoiceId'");

                    $refdPaidArray = $refdPaid->fetch_array();

                    $refdDueAmount = $refdfeeamount - $refdPaidArray[0];

                    $payAmount = $payArray[0] + $duePayArray[0];

                    $writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$invoiceId'");
                    $writeOffArray = $writeOff->fetch_array();
                    
                    $cashBack = $mysqli->query("select sum(cashBackAmount) from cash_back where invoiceId = '$invoiceId'");
                    $cashBackArray = $cashBack->fetch_array();

                    $invAmount = $array['totalTestAmount'] - ($disAmountArray[0] + $writeOffArray[0] - $cashBackArray[0]);

                    $totalInvoiceAmount2 += $invAmount;
                    $totalReceived2 += $payAmount;
                    $totalRefdAmount2 += $refdfeeamount;
                    $totalRefdPaid2 += $refdPaidArray[0];
				}
				
        	?>
            
          	<tr style="font-weight:bold">
                <td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:right" colspan="6">Grand Total=</td>
                <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalInvoiceAmount2); ?></td>
                <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalReceived2); ?></td>
                <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalRefdAmount2); ?></td>
                <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center"><?php echo sprintf('%.2f',$totalRefdPaid2); ?></td>
                <td style="border-bottom:1px solid; border-right:1px solid; border-top:4px double; text-align:center">&nbsp;</td>
            </tr>
            
            <tr>
            	<td colspan="6">
                    <table style="font-weight: bold;" cellspacing="0">
                    <tr>
                        <td>Total Received </td><td>:</td><td> <?php echo sprintf('%.2f',$totalReceived2); ?>
                    </tr>
                    <tr>
                        <td>Total Refd Payment</td><td> :</td><td> <?php echo sprintf('%.2f',$totalRefdPaid2); ?></td>
                    </tr>
                    <tr>
                        <td style="border-top:1px solid">Net Cash</td><td style="border-top:1px solid"> :</td><td style="border-top:1px solid"> <?php echo sprintf('%.2f',$totalReceived2 - $totalRefdPaid2); ?></td>
                    </tr>
                    </table>
                </td>
            </tr>
        	
            <?php
            }
			?>
      </table>
      
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