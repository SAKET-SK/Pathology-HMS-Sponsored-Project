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
		
		
		var win = window.open('print_due_report.php?from_date='+from_date+'&to_date='+to_date,'myDoc', myFeatures);	
		
	}else{
		alert('Date field empty!');
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
		
		window.location = 'due_report.php?active=due_report&from_date='+from_date+'&to_date='+to_date;
	}else{
		alert('Date field empty!');
	}
	
}

function confirmInvoice(id){
		
		
		var myBars = 'directories=no,location=no,menubar=yes,status=no';
		
		myBars += ',titlebar=yes,toolbar=no';
		
		var myOptions = 'scrollbars=no,width=750,height=500,resizeable=no,top=10, left=300,';
		var myFeatures = myBars + ',' + myOptions;
		
		
		var win = window.open('invoice.php?id='+id, 'myDoc', myFeatures);
		
	return true;

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
                  <div class="row">
                  <div class="col-lg-12">
					<div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Refd By</th>
                            <th>C/O</th>
                            <th>Total Price</th>
                            <th>Discount</th>
                            <th>Net</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Refd By</th>
                        <th>C/O</th>
                        <th>Total Price</th>
                        <th>Discount</th>
                        <th>Net</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
					if(isset($_GET['from_date']) <> '' && isset($_GET['to_date']) <> ''){
						$condition = "where isCancel = '0' and isDue = '1' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'";
					}else{
						$condition = "where isCancel = '0' and isDue = '1'";	
					}
					
					$query = $mysqli->query("select * from invoice $condition order by invoiceId desc");
					if($query->num_rows > 0){
						$sl = 1;
						$price = 0;
						while($rows = $query->fetch_array()){
							$getCO = $mysqli->query("select * from co where coId = '$rows[coId]'");
							$coArray = $getCO->fetch_array();
							
							$getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
							$refdArray = $getRefd->fetch_array();
							
							$writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$rows[invoiceId]'");
							$writeOffArray = $writeOff->fetch_array();
						?>
						<tr>
							<td><?php echo $sl; ?></td>
                            <td><?php echo $rows['idNo']; ?></td>
                            <td><?php echo $rows['patientName']; ?></td>
                            <td><?php echo $rows['patientMobile']; ?></td>
                            <td><?php echo $refdArray['doctor_name']; ?></td>
                            <td><?php echo $coArray['coName']; ?></td>
                            <td><?php echo $rows['totalTestAmount']; ?></td>
                            <td>
							<?php
							$get_dis = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$dis_array = $get_dis->fetch_array();
							echo $dis_array[0];
							
							?>
                            </td>
                            <td>
                            	<?php echo $net = $rows['totalTestAmount'] - ($dis_array[0] + $writeOffArray[0]); ?>
                            </td>
                            <td>
							<?php
							$get_pay = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$pay_array = $get_pay->fetch_array();
							
							$get_due_pay = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$due_pay_array = $get_due_pay->fetch_array();
							
							echo $totalPaid = $pay_array[0] + $due_pay_array[0];
							
							?>
                            </td>
                            <td>
                            	<?php echo $due = $net - $totalPaid; ?>
                            </td>
                            <td>
								<?php
									$invoiceDate = new DateTime($rows['invoiceDate']);
									echo $invoiceDate->format('d-m-Y');
								?>
                            </td>
							<td align="center">
                            <a href="#" onclick="return confirmInvoice(<?php echo $rows['invoiceId']; ?>)">Invoice</a>
                            </td>
						</tr>
						<?php
						$price += $rows['totalTestAmount'];
						$sl++;
						}
					}
					?>
                    </tbody>  
                    </table> 
                     </div>
				</div><!--/.col-->
			</div><!--/.row-->
            
		</section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>