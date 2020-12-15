<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'User')){
require_once('include/header.php');
require_once('connect.php');
?>

<script>
$(function(){
	$('#myTable').DataTable();
	$("#co").select();
	$("#co").typeahead({
		source:function(query, process){
			$.getJSON('get_co.php?query='+query, function(data){
				process(data);
			});
		},
		updater: function(item){
			window.location = 'co_payment_details.php?active=co_payment&refdName='+item;
		}
	});
	
});

function confirmInvoice(id){
		
		
		var myBars = 'directories=no,location=no,menubar=yes,status=no';
		
		myBars += ',titlebar=yes,toolbar=no';
		
		var myOptions = 'scrollbars=no,width=750,height=500,resizeable=no,top=10, left=300,';
		var myFeatures = myBars + ',' + myOptions;
		
		
		var win = window.open('invoice.php?id='+id, 'myDoc', myFeatures);
		
	return true;

}
function report(){
	
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var coName = $('#co').val();
	
	if(from_date.length > 0 && to_date.length > 0){
		from_date = from_date.split('/');
		from_date = from_date[2]+'-'+from_date[0]+'-'+from_date[1];
		
		to_date = to_date.split('/');
		to_date = to_date[2]+'-'+to_date[0]+'-'+to_date[1];
		
		var myBars = 'directories=no,location=no,menubar=yes,status=no';
	
		myBars += ',titlebar=yes,toolbar=no';
		
		var myOptions = 'scrollbars=yes,width=1000,height=500,resizeable=no,top=10, left=200,';
		var myFeatures = myBars + ',' + myOptions;
		
		
		var win = window.open('print_co_payment_report.php?from_date='+from_date+'&to_date='+to_date+'&refdName='+coName,'myDoc', myFeatures);	
		
	}else{
		alert('Date field empty!');
	}
	
}

function searchByDate(){
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var coName = $('#co').val();

	if(from_date.length > 0 && to_date.length > 0){
		from_date = from_date.split('/');
		from_date = from_date[2]+'-'+from_date[0]+'-'+from_date[1];
		
		to_date = to_date.split('/');
		to_date = to_date[2]+'-'+to_date[0]+'-'+to_date[1];
		

		window.location = 'co_payment_details.php?active=refd_payment&from_date='+from_date+'&to_date='+to_date+'&refdName='+coName;
	}else{
		alert('Date field empty!');
	}
	
}
</script>      
<style>
.form-control{
	color:#000;
	border:1px solid;
}
.control-label{
	color:#000;
	font-weight:bold;
}
.dueFree{
	color:#000;
	font-weight:bold;
	padding:2px 0px;
}
.due{
	color:#F00;
	font-weight:bold;
	padding:2px 0px;
}
.form-row input {
    width: 180px;
    padding: 3px 1px;
    border: 1px solid #090;
    box-shadow: none;
}
</style>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
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
                          
        <div class="row">
        	<div class="col-lg-4 col-lg-offset-4">
        		<?php
        			if(isset($_GET['refdName']) && $_GET['refdName'] <> ''){
        				$searchValue = $_GET['refdName'];
        			}else{
        				$searchValue = '';
        			}
        		?>
            	<input type="text" value="<?php echo $searchValue; ?>" class="input-control" id="co" placeholder="Search C/O Name">
            </div>
        </div>     
		
            <?php
			
			if(isset($_GET['refdName']) && $_GET['refdName'] <> ''){
			
				$query = $mysqli->query("select * from co where coName = '$_GET[refdName]'");			
				
				if($query->num_rows > 0){
					$refdArray = $query->fetch_array();
					?>
                <div class="row">
                	<div class="col-lg-4">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">C/O Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form"  style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="100px" style="padding:2px 3px; border-bottom:1px solid #999">C/O Name</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['coName']; ?></td>
                                </tr>
                                <tr>
                                	<td width="100px" style="padding:2px 3px; border-bottom:1px solid #999">C/O Mobile</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['coMobile']; ?></td>
                                </tr>
                                <tr>
                                	<td width="100px" style="padding:2px 3px; border-bottom:1px solid #999">C/O Code</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['coCode']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Invoice Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form" style="min-height:100px;">
                              	<div class="form-row show-inputbtns" align="center">
                              		
			                        <input type="text" id="from_date" /> To
			                        <input type="text" id="to_date" />
			                        <button class="btn btn-primary" onclick="searchByDate()">Search</button>
			                        <button class="btn btn-primary" onclick="report()">Report</button>
			                    </div>
								<div class="table-responsive">
									<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
									<tr style="font-size: 13px;">
										<th width="20px">SL</th>
										<th>ID No</th>
										<th width="70px">Inv. (Paid)</th>
										<th>Amount</th>
										<th>Paid</th>
										<th>Due</th>
										<th>Date</th>
										<th>Time</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
										<?php
											$refdId = $refdArray['coId'];
											if(isset($_GET['from_date']) <> '' && isset($_GET['to_date']) <> ''){
												$condition = "AND invoiceDate BETWEEN '$_GET[from_date]' AND '$_GET[to_date]'";
											}else{
												$condition = '';
											}
											$getInvoice = $mysqli->query("SELECT * FROM invoice WHERE coId = '$refdId' AND isCancel = '0' $condition ORDER BY invoiceId DESC");
											
											if($getInvoice->num_rows > 0){
											
												$sl = 1;
												$invoiceAmount = 0;
												while($refdRows = $getInvoice->fetch_array()){

													$invoiceId = $refdRows['invoiceId'];

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

													$date = new DateTime($refdRows['invoiceDate'].$refdRows['invoiceTime']);

													$payAmount = $payArray[0] + $duePayArray[0];

													$invoiceAmount += $payAmount;

											?>
												<tr>
													<td><?php echo $sl; ?></td>
													<td><?php echo $refdRows['idNo']; ?></td>
													<td align="center"><?php echo $payAmount; ?></td>
													<td align="center"><?php echo '<b>'.$refdfeeamount.'</b>'; ?></td>
													<td>
													<?php
													if($refdPaidArray[2] > 0){
													 echo '<b>'.$refdPaidArray[0].'</b>'; 
														if($refdPaidArray[1] == 0){
															echo '(Dr.)';
														}
													}
													?>
													</td>
													<td align="center"><?php echo $refdDueAmount; ?></td>
													<td><?php echo $date->format('d-m-Y') ?></td>
													<td><?php echo $date->format('h:i:s A') ?></td>
													<td><a href="#" onclick="return confirmInvoice(<?php echo $refdRows['invoiceId']; ?>)">Invoice</a> | <a href="due_payment.php?active=due_payment&idNo=<?php echo $refdRows['idNo']; ?>&refd=co">Pay</a></td>
												</tr>
											<?php
												$sl++;
												}
											}
										?>
									</tbody>
									<tfoot>
										<tr style="font-size: 13px;">
											<th width="20px">SL</th>
											<th>ID No</th>
											<th>Inv. (Paid)</th>
											<th>Amount</th>
											<th>Paid</th>
											<th>Due</th>
											<th>Date</th>
											<th>Time</th>
											<th>Action</th>
										</tr>
									</tfoot>
									</table>
								</div>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    </div>
                
                <?php
			
				}else{
					echo "Data Not Found!";	
				}
			}
			?>
        </div>
        </div>
            </div>	       
        </div> 
        
             

      	</section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>