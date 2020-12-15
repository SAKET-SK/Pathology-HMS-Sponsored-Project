<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'User')){
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
		
		
		var win = window.open('print_receipt_report.php?from_date='+from_date+'&to_date='+to_date,'myDoc', myFeatures);	
		
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
		
		window.location = 'receipt_report.php?active=receipt_report&from_date='+from_date+'&to_date='+to_date;
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
function confirmAllInvoice(id){
		
		
		var myBars = 'directories=no,location=no,menubar=yes,status=no';
		
		myBars += ',titlebar=yes,toolbar=no';
		
		var myOptions = 'scrollbars=no,width=750,height=500,resizeable=no,top=10, left=300,';
		var myFeatures = myBars + ',' + myOptions;
		
		
		var win = window.open('invoice_all.php?id='+id, 'myDoc', myFeatures);
		
	return true;

}

function invoiceEdit(invoiceId, patientName){
	
	var nameBox = prompt("Change Patient Name", patientName);

	if(nameBox != null){
		window.location = 'invoice_edit.php?invoiceId='+invoiceId+'&patientName='+nameBox;
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
					<h1>&nbsp&nbsp&nbspInvoice Details</h1>
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
               	<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
               	<div class="col-lg-12">
               		<h3>Search Invoice </h3>
                	<div class="form-row show-inputbtns" align="center">

                      <input type="text" id="from_date" /> To
                        <input type="text" id="to_date" />
                        <br>
                        <br>
                        <button class="btn btn-primary" onclick="searchByDate()">Search</button>
                        <button class="btn btn-primary" onclick="report()">Report</button>
                    </div>
                </div>
               </div>
               </center>
                  <div class="row">
                  <div class="col-lg-12">
                  	<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<br>
					<div class="table-responsive">
					<?php
					if(isset($_GET['from_date']) <> '' && isset($_GET['to_date']) <> ''){
						$condition = "where isCancel = '0' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'";
					
					
					$query = $mysqli->query("select * from invoice $condition order by invoiceId desc");
					if($query->num_rows > 0){	
					?>
                    <table id="myTable" class="table  table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                         <!--   <th>Refd By</th>
                            <th>C/O</th>-->
                            <th>Total Price</th>
                            <th>Discount</th>
                            <th>Net</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                    <?php
					
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
									$invoiceDate = new DateTime($rows['invoiceDate']);
									echo $invoiceDate->format('d-m-Y');
								?>
                            </td>
							<td align="center" width="180px">
                            <a href="#" onclick="return confirmInvoice(<?php echo $rows['invoiceId']; ?>)">Invoice</a> |

                            <a href="#" onclick="return confirmAllInvoice(<?php echo $rows['invoiceId']; ?>)">All Invoice</a> |
                            <?php
                            	$patientName = $rows['patientName'];
                            ?>
                            <a href="#" onclick="invoiceEdit(<?php echo $rows['invoiceId']; ?>, '<?php echo $patientName; ?>')">Edit</a> |
                            
                              <a href="receipt_delete.php?invoiceId=<?php echo $rows['invoiceId']; ?>" onclick="return confirm('Are you sure to Cancel this')">Cancel</a>
                            </td>
						</tr>
						<?php
						$price += $rows['totalTestAmount'];
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
                    
                    <?php
                	}
                    ?> 
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