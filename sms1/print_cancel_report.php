<?php
ob_start();
@session_start();
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
        top: .5in;
        left: -1in;
      }
	  #pagi-link, #print_btn{
		  display:none
		}
    }
  </style>
<script>
function load_perpage(perpage, page, searchByDate){
	window.location = 'print_cancel_report.php?perpage='+perpage+'&page='+page+searchByDate;
}

function load_pagination(page, perpage, searchByDate){
	window.location = 'print_cancel_report.php?perpage='+perpage+'&page='+page+searchByDate;
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

if($_GET['from_date'] <> '' && $_GET['to_date'] <> ''){
	$condition = "where isCancel = '1' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'";
	$searchByDate = "&from_date=$_GET[from_date]&to_date=$_GET[to_date]";
}else{
	$condition = "where isCancel = '1'";	
	$searchByDate = "";
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
            	Cancel Report
                
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
        <table border="0" width="90%" cellspacing="0" style="font-size:12px">
          <tr>
                <th style="border:1px solid; font-style:italic">SL</th>
                <th style="border:1px solid; border-left:none; font-style:italic">ID</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Name</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Mobile</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Refd By</th>
                <th style="border:1px solid; border-left:none; font-style:italic">C/O</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Total Amount</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Discount</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Net</th>
                <th style="border:1px solid; border-left:none; font-style:italic">Date</th>
            </tr>
        <?php
			$sl = $start + 1;
			$totalAmount = 0;
			$totalDiscount = 0;
			$totalNetAmount = 0;
			while($rows = $query->fetch_array()){
				$getCO = $mysqli->query("select * from co where coId = '$rows[coId]'");
				$coArray = $getCO->fetch_array();
				
				$getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
				$refdArray = $getRefd->fetch_array();
				
				$writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$rows[invoiceId]'");
				$writeOffArray = $writeOff->fetch_array();
			?>
			<tr>
				<td style="border:1px solid; border-top:none; text-align:center"><?php echo $sl; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none"><?php echo $rows['idNo']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $rows['patientName']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $rows['patientMobile']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $refdArray['doctor_name']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px"><?php echo $coArray['coName']; ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$rows['totalTestAmount']); ?></td>
				<td style="border:1px solid; border-top:none; border-left:none; text-align:center">
				<?php
				$get_dis = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
				$dis_array = $get_dis->fetch_array();
				echo sprintf('%.2f',$dis_array[0]);
				
				?>
				</td>
                <td style="border:1px solid; border-top:none; border-left:none; text-align:center">
                	<?php echo $net = $rows['totalTestAmount'] - ($dis_array[0] + $writeOffArray[0]); ?>
                </td>
				<td style="border:1px solid; border-top:none; border-left:none; padding:0px 3px">
					<?php
						$invoiceDate = new DateTime($rows['invoiceDate']);
						echo $invoiceDate->format('d-m-Y');
					?>
				</td>
			</tr>
			<?php
			$totalAmount += $rows['totalTestAmount'];
			$totalDiscount += $dis_array[0];
			$totalNetAmount += $net;
			$sl++;
			}
		?>
        <tr style="font-weight:bold">
        	<td style="border:1px solid; border-top:none; text-align:right" colspan="6">Total=</td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalAmount); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalDiscount); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none; text-align:center"><?php echo sprintf('%.2f',$totalNetAmount); ?></td>
            <td style="border:1px solid; border-top:none; border-left:none">&nbsp;</td>
        </tr>
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