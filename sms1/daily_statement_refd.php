<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && $_SESSION['userType'] == 'Administrator'){
require_once('include/header.php');
require_once('connect.php');
date_default_timezone_set('UTC');
$mkdate = mktime(date('H') + 6, date('i'), date('s'));
$date = date('Y-m-d', $mkdate);
$time = date('h:i:s', $mkdate);
?>

<script>
$(document).ready(function() {
	$('#myTable').DataTable();
} );

function report(){
	
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
	if(from_date.length > 0 && to_date.length > 0){
		from_date = from_date.split('/');
		from_date = from_date[2]+'-'+from_date[0]+'-'+from_date[1];
		
		to_date = to_date.split('/');
		to_date = to_date[2]+'-'+to_date[0]+'-'+to_date[1];
		
		var myBars = 'directories=no,location=no,menubar=yes,status=no';
		
		myBars += ',titlebar=yes,toolbar=no';
		
		var myOptions = 'scrollbars=yes,width=1000,height=500,resizeable=no,top=10, left=200,';
		var myFeatures = myBars + ',' + myOptions;
		
		
		var win = window.open('print_daily_state_refd_report.php?from_date='+from_date+'&to_date='+to_date,'myDoc', myFeatures);	
	}else{
		alert('Please select date');
	}
	
}

function searchByDate(){
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();

	if(from_date.length > 0 && to_date.length > 0){
		from_date = from_date.split('/');
		from_date = from_date[2]+'-'+from_date[0]+'-'+from_date[1];
		
		to_date = to_date.split('/');
		to_date = to_date[2]+'-'+to_date[0]+'-'+to_date[1];
		
		window.location = 'daily_statement_refd.php?active=daily_statement_refd&from_date='+from_date+'&to_date='+to_date;
	}else{
		alert('Date field empty!');
	}
	
}
</script>
<style>
.input-group{
	margin-bottom:10px;
}
.form-row input {
    width: 220px;
    padding: 3px 1px;
    border: 1px solid #090;
    box-shadow: none;
}
</style>     
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
			  <div class="row">
					<ol class="breadcrumb">
						<li><i class="fa fa-angle-double-right"></i><a href="index.php">&nbsp; Home</a></li>
						<li style="color:#1a1a1a;">
			            <?php
			              if(isset($_GET['active'])){ 
			                $active = explode("_",$_GET['active']);
			                
			                foreach($active as $name){
			                  echo ucfirst($name);
			                  echo " ";
			                }
			              }
			            ?>
			            </li>							  	
					</ol>
				</div>
            <center>
            	<div class="row">
                	<div class="col-lg-12">
                    	<!--<button class="btn btn-primary" onclick="report()">Report</button>-->
                        <?php
						if(isset($_GET['delete']) && $_GET['delete'] <> '')
						{
							echo "<center><font color='#F00'><b>Cancel Successed</font></center>";
						}
						?>
                    </div>
               </div>
               <div class="row">
               	<div class="col-lg-12">
                	<div class="form-row show-inputbtns" align="center">
                        <input type="text" id="from_date" /> To
                        <input type="text" id="to_date" />
                        <button class="btn btn-primary" onclick="searchByDate()">Search</button>
                        <button class="btn btn-primary" onclick="report()">Report</button>
                    </div>
                </div>
               </div>
               </center>
               <?php
			   if(isset($_GET['from_date']) && isset($_GET['to_date'])){
			   ?>
                  <div class="row">
                  <div class="col-lg-12">
					<div class="table-responsive">
					<?php
					$query = $mysqli->query("select * from invoice where isCancel = '0' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]' order by invoiceDate asc");

					if($query->num_rows > 0){
					?>
                    <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>C/O</th>
                            <th>Refd. Prof./Dr.</th>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Rate</th>
                            <th>Disc.</th>
                            <th>Net.</th>
                            <th>Recvd.</th>
                            <th>Due</th>
                            <th>Refd. Fee.</th>
                            <th>Adv. Paid</th>
                            <th>Due Fee</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>C/O</th>
                        <th>Refd. Prof./Dr.</th>
                        <th>Patient</th>
                        <th>Contact</th>
                        <th>SL</th>
                        <th>ID</th>
                        <th>Rate</th>
                        <th>Disc.</th>
                        <th>Net.</th>
                        <th>Recvd.</th>
                        <th>Due</th>
                        <th>Refd. Fee.</th>
                        <th>Adv. Paid</th>
                        <th>Due Fee</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
					
						$sl = 1;
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
							<td>
							<?php
								$invoiceDate = new DateTime($rows['invoiceDate']);
								echo $invoiceDate->format('d-M-y');
							?>
                            </td>
                            <td><?php echo $refdArray['doctor_name']; ?></td>
                            <td><?php echo $coArray['coName']; ?></td>
                            <td><?php echo $rows['patientName']; ?></td>
                            <td><?php echo $rows['patientMobile']; ?></td>
                            <td><?php echo $rows['labDailySl']; ?></td>
                            <td><?php echo $rows['idNo']; ?></td>
                            <td><?php echo $rows['totalTestAmount']; ?></td>
                            <td>
							<?php
							$get_dis = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$dis_array = $get_dis->fetch_array();
							echo $dis_array[0];
							
							?>
                            </td>
                            <td>
								<?php echo $net = $rows['totalTestAmount'] - $dis_array[0]; ?>
                            </td>
                            <td>
                            	<?php echo $pPay = $patientPayArray[0] + $patientDuePayArray[0]; ?>
                            </td>
                            <td>
                            	<?php echo $patientDue = $net - ($patientPayArray[0] + $patientDuePayArray[0] + $writeOffArray[0]); ?>
                            </td>
                            <td>
                            	<?php echo $refdFee = $refdAmountArray[0] - $dis_array[0]; ?>
                            </td>
                            <td>
                            	<?php echo $refdPayArray[0]; ?>
                            </td>
                            <td>
                            	<?php echo $refdDue = $refdFee - $refdPayArray[0]; ?>
                            </td>
						</tr>
						<?php
						$sl++;
						}
						?>
					</tbody>  
                    </table> 
						<?php
					}else{
                		echo "<center><h4><font color='#F00'>Data Not Found!</font></h4></center>";
                	}
					?>
                    
                     </div>
				</div><!--/.col-->
			</div><!--/.row-->
            <?php
			   }
			?>
            
		</section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>