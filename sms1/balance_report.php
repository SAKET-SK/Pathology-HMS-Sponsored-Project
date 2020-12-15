<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
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


function searchByDate(){
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();

	if(from_date.length > 0 && to_date.length > 0){
		from_date = from_date.split('/');
		from_date = from_date[2]+'-'+from_date[0]+'-'+from_date[1];
		
		to_date = to_date.split('/');
		to_date = to_date[2]+'-'+to_date[0]+'-'+to_date[1];
		
		window.location = 'balance_report.php?active=balance_report&from_date='+from_date+'&to_date='+to_date;
		//window.location = 'due_report.php?active=due_report&from_date='+from_date+'&to_date='+to_date;
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
.metric {
    padding: 10px 20px;
    height: 100px;
}
.col-md-6{margin-bottom: 10px;}
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
               <div class="row" style="margin-bottom:20px;">
               	<div class="col-lg-12">
                	<div class="form-row show-inputbtns" align="center">
                        <input type="text" id="from_date" /> To
                        <input type="text" id="to_date" />
                        <button class="btn btn-primary" onclick="searchByDate()">Search</button>
                    </div>
                </div>
               </div>
               <?php
					if(isset($_GET['from_date']) <> '' && isset($_GET['to_date']) <> ''){
					    $fromDate = date('d-F-Y', strtotime($_GET['from_date']));
					    $toDate = date('d-F-Y', strtotime($_GET['to_date']));
					    echo "<h4>Report From <span style='color:#db4905'>".$fromDate."</span> to<span style='color:#db4905'> ".$toDate."</span></h4>";

						$condition = "where patient_payment.isCancel = '0' and patient_payment.patientPayDate between '$_GET[from_date]' and '$_GET[to_date]'";

						$condition2 = "where isCancel = '0' and refdPayDate between '$_GET[from_date]' and '$_GET[to_date]'";

						$condition_due = "where isCancel = '0' and isDue = '1' and invoiceDate between '$_GET[from_date]' and '$_GET[to_date]'";
                        $dueCondition ="where isCancel = '0' and patientDuePayDate between '$_GET[from_date]' and '$_GET[to_date]'";

						//code start for expense (FROM_DATE TO_DATE)
						$query = $mysqli->query("select * from expense_details order by Id desc");
            			if($query->num_rows > 0){
            		    	$total_expense=0;
            		    
        					while($rows = $query->fetch_array()){

                				$expense_date = date('Y-m-d',strtotime($rows['date']));

                				if (($_GET['from_date']<=$expense_date) && $_GET['to_date']>=$expense_date) {
                    				$total_expense=$total_expense+$rows['amount'];
                				}
        					}
            			}   	  
						//code end for expense (FROM_DATE TO_DATE)
						
					}else{
					    echo "<br>";
					    $today = date('d-F-Y', strtotime($date));
					    echo "<h4>Report of <span style='color:#db4905'>".$today."</span></h4>";

						$condition = "where patient_payment.isCancel = '0' and patient_payment.patientPayDate='$date'";	

						$condition2 = "where isCancel = '0' and refdPayDate='$date'";

						$condition_due = "where isCancel = '0' and isDue = '1' and invoiceDate = '$date'";
						$dueCondition="where isCancel = '0' and patientDuePayDate = '$date' ";

						//code start for expense (TODAY)
						$query = $mysqli->query("select * from expense_details order by Id desc");
            			if($query->num_rows > 0){
            		    	$total_expense=0;
            		    
        					while($rows = $query->fetch_array()){

                				$expense_date = date('Y-m-d',strtotime($rows['date']));

                				if ($expense_date==$date) {
                    				$total_expense=$total_expense+$rows['amount'];
                				}
        					}
            			} 
            			//code end for expense (TODAY)
					}

					//code start for refd amount & c/o amount
					$query3 = $mysqli->query("select * from refd_payment $condition2 order by refdPaymentId desc");
					$refd_amount=0;
					$co_amount=0;
					if($query3->num_rows > 0){
						
						while($rows = $query3->fetch_array()){
							$getCO = $mysqli->query("select * from co where coId = '$rows[coId]'");
							$coArray = $getCO->fetch_array();
							
							$getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
							$refdArray = $getRefd->fetch_array();

                            if(isset($refdArray['doctor_name']))
                            	$refd_amount=$refd_amount+$rows['refdPayAmount'];

                            elseif (isset($coArray['coName'])) 
                            	$co_amount=$co_amount+$rows['refdPayAmount'];              
						}
					}
					//code end for refd amount & c/o amount
					
					//code start for due amount

					$query = $mysqli->query("select * from invoice $condition_due order by invoiceId desc");

					$total_due=0;
					if($query->num_rows > 0){
						$price = 0;
						while($rows = $query->fetch_array()){
							$getCO = $mysqli->query("select * from co where coId = '$rows[coId]'");
							$coArray = $getCO->fetch_array();
							
							$getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
							$refdArray = $getRefd->fetch_array();
							
							$writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$rows[invoiceId]'");
							$writeOffArray = $writeOff->fetch_array();
						
							$get_dis = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$dis_array = $get_dis->fetch_array();
							
							$net = $rows['totalTestAmount'] - ($dis_array[0] + $writeOffArray[0]);

							$get_pay = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$pay_array = $get_pay->fetch_array();
							
							$get_due_pay = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$due_pay_array = $get_due_pay->fetch_array();
							
							$totalPaid = $pay_array[0] + $due_pay_array[0];
							
							$due = $net - $totalPaid;

							$total_due = $total_due + $due;
						
						$price += $rows['totalTestAmount'];
						
						}
					}
					
					//code end for due amount

					//code start for total income

				 	$query = $mysqli->query("select * from patient_payment join invoice on patient_payment.invoiceId = invoice.invoiceId $condition order by patient_payment.patientPayId desc");

				 	$income=0;
				 	if($query->num_rows > 0){
						$price = 0;
						while($rows = $query->fetch_array()){
							
							$patientPayment = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$rows[invoiceId]'") or die($mysqli->error);
							$patientPayArray = $patientPayment->fetch_array();
                            
                           	$income=$income+$patientPayArray[0];
                            						
						$price += $rows['totalTestAmount'];
						}
					}

					$total_income=$income+$total_due;
				 	//code end for total income

                    //code Start for due collection
                    $query = $mysqli->query("select * from patient_due_payment  $dueCondition");

				 	$dueCollection=0;
				 	if($query->num_rows > 0){
						while($rows = $query->fetch_array()){
							
							$dueCollection=$dueCollection+$rows['patientDuePayAmount'];
						}
					}

                    //balance
				 	$balance = $total_income + $dueCollection - $total_expense - $total_due - $refd_amount - $co_amount;

					//unset($total_expense,$total_due,$refd_amount,$co_amount,$total_income);
					?>

            <div class="row" style="margin-bottom:20px;">
			<?php 
            ?>
                
               
                
					
	    </div>
    </center>
            
            <!-- bar chart -->
    <div class="row">
        <div class="col-md-6">					
			<div class="panel panel-body padding" >
	           <div id="demo-bar-chart" class="ct-chart"></div>			
	        </div>					
		</div>
            

        <!--Display Values  -->
		<div class="col-md-6">
		    <div class="col-md-12">
		        <div class="col-md-6">
					<div class="metric" style="background: #220547e6;">
						
						<p>
							<span class="number">
								<?php echo $total_income;?><sup>৳</sup>
							</span>
							<span class="title">Total Income</span>
						</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="metric" style="background: #ed6007;">
						
						<p>
							<span class="number">
								<?php echo $dueCollection;?><sup>৳</sup>
							</span>
							<span class="title">Due Collection</span>
						</p>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="metric" style="background:#161e59;">
					
						<p>
							<span class="number">
								<?php 
								echo $refd_amount;?><sup>৳</sup>
									</span>
							<span class="title">Refd Amount</span>
						</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="metric" style="background: #a7139a;">
						
						<p>
							<span class="number">
								<?php 
								echo  $co_amount; ?><sup>৳</sup>
							</span>
							<span class="title">C/O Amount</span>
						</p>
					</div>
				</div>
											
			    <div class="col-md-6">
					<div class="metric " style="background: red;">
						
						<p>
						<span class="number">
						<?php echo $total_expense; ?> <sup>৳</sup>
						 </span>
						 <span class="title">Total Expense</span>
						</p>
					</div>
				</div>
			    <div class="col-md-6">
					<div class="metric" style="background: blue;">
						
						<p>
							<span class="number">
								<?php echo $total_due;?><sup>৳</sup>
							</span>
							<span class="title">Total Due</span>
						</p>
					</div>
				</div>
				
				<hr>
			    <div class="col-md-6">
					<div class="metric" style="background: green;">
						
						<p>
							<span class="number">
								<?php echo $balance;?><sup>৳</sup>
							</span>
							<span class="title">Balance</span>
						</p>
					</div>
				</div>
			</div>
		</div>					 
          
    </div> 
</section>

<script>
	$(function() {
		var options;

		var data = {
			labels: ['Total Income','Due Collection', 'Refd Amount','C/O Amount','Total Expense', 'Total Due', 'Balance'] ,
			series: [
				[<?php echo $total_income;?>,<?php echo $dueCollection;?>,<?php echo $refd_amount;?>,<?php echo  $co_amount; ?>,<?php echo $total_expense; ?>,<?php echo $total_due;?>,<?php echo $balance;?>] ,
			]
		};
		options = {
			width: "100%",
			height:"420px",
			axisX: {
				showGrid: false
			}
		};

		new Chartist.Bar('#demo-bar-chart', data, options);
	});
</script>

<?php
require_once('include/footer.php');	
}
else{
	header("Location:index.php");	
}
?>