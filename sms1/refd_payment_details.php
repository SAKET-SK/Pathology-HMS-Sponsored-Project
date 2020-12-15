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
	$("#refd").select();
	$("#refd").typeahead({
		source:function(query, process){
			$.getJSON('get_refdby.php?query='+query, function(data){
				process(data);
			});
		},
		updater: function(item){
			refdName = item.replace("&","%26");
			window.location = 'refd_payment_details.php?active=refd_payment&refdName='+refdName;
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
            	<input type="text" class="input-control" id="refd" placeholder="Search Refd Name">
            </div>
        </div>     
		
            <?php
			
			if(isset($_GET['refdName']) && $_GET['refdName'] <> ''){
			
				$query = $mysqli->query("select * from doctor where doctor_name = '$_GET[refdName]'");			
				
				if($query->num_rows > 0){
					$refdArray = $query->fetch_array();
					
					?>
                <div class="row">
                	<div class="col-lg-3">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Refd Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form"  style="min-height:100px;">
                                C/O Name: <br>
                                    <b><?php echo $refdArray['doctor_name']; ?> </b>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Invoice Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form" style="min-height:100px;">
								<div class="table-responsive">
									<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
									<tr>
										<th width="40px">SL</th>
										<th>ID No</th>
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
											
											$refdId = $refdArray['id'];
											$getInvoice = $mysqli->query("SELECT * FROM invoice WHERE refdId = '$refdId' ORDER BY invoiceId DESC");
											
											if($getInvoice->num_rows > 0){
											
												$sl = 1;
												while($refdRows = $getInvoice->fetch_array()){

													$invoiceId = $refdRows['invoiceId'];
													$refdAmount = $mysqli->query("SELECT refdFeeAmount FROM refdfeeamount WHERE invoiceId = '$invoiceId'");
													$refdAmountArray = $refdAmount->fetch_array();

													$disAmount = $mysqli->query("SELECT SUM(disAmount) FROM patient_discount WHERE invoiceId = '$invoiceId'");
													$disAmountArray = $disAmount->fetch_array();
													
													$refdfeeamount = $refdAmountArray[0] - $disAmountArray[0];
													
													$refdPaid = $mysqli->query("SELECT SUM(refdPayAmount), refdId, COUNT(*) FROM refd_payment WHERE invoiceId = '$invoiceId'");

													$refdPaidArray = $refdPaid->fetch_array();

													$refdDueAmount = $refdfeeamount - $refdPaidArray[0];

													$date = new DateTime($refdRows['invoiceDate'].$refdRows['invoiceTime']);

											?>
												<tr>
													<td><?php echo $sl; ?></td>
													<td><?php echo $refdRows['idNo']; ?></td>
													<td align="center"><?php echo '<b>'.$refdfeeamount.'</b>'; ?></td>
													<td>
													<?php
													if($refdPaidArray[2] > 0){
													 echo '<b>'.$refdPaidArray[0].'</b>'; 
														if($refdPaidArray[1] == 0){
															echo '(CO)';
														}
													}
													?>
													</td>
													<td align="center"><?php echo $refdDueAmount; ?></td>
													<td><?php echo $date->format('d-m-Y') ?></td>
													<td><?php echo $date->format('h:i:s A') ?></td>
													<td><a href="#" onclick="return confirmInvoice(<?php echo $refdRows['invoiceId']; ?>)">Invoice</a> | <a href="due_payment.php?active=due_payment&idNo=<?php echo $refdRows['idNo']; ?>&refd=doctor">Pay</a></td>
												</tr>
											<?php
												$sl++;
												}
											}
										?>
									</tbody>
									<tfoot>
										<th width="40px">SL</th>
										<th>ID No</th>
										<th>Amount</th>
										<th>Paid</th>
										<th>Due</th>
										<th>Date</th>
										<th>Time</th>
										<th>Action</th>
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