<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'User')){
require_once('include/header.php');
require_once('connect.php');
?>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>

<script>
$(function(){

    $('#idNo').typeahead({
        source:function(query, process){
            $.getJSON('search_id_no.php?query='+query, function(data){
                process(data);
            })
        },
        updater:function(item){
            document.location='due_payment.php?active=due_payment&idNo='+item;
        }
    });

	$('#pPay').keyup(function(){
		var value = this.value;
		var amountToPay = $('#pPreDue').val();
		if(value.length > 0){
            if(parseInt(amountToPay) < parseInt(value)){
                alert('Sorry! Payment is over.');
                $('#pPay').val(0);
                $('#pDue').val(amountToPay);
                $('#pPay').select();
            }else{
			     $('#pDue').val(parseInt(amountToPay) - parseInt(value));
            }
		}else{
			$('#pDue').val(amountToPay);
		}
	});
	
	$('#rPay').keyup(function(){
		var value = this.value;
		var amountToPay = $('#rPreDue').val();

		if(value.length > 0){
            if(parseInt(amountToPay) < parseInt(value)){
                alert('Sorry! Payment is over');
                $('#rPay').val(0);
                $('#rDue').val(amountToPay);
                $('#rPay').select();
            }else{
			     $('#rDue').val(parseInt(amountToPay) - parseInt(value));
            }
		}else{
			$('#rDue').val(amountToPay);
		}
	});	
	
});

function invoiceEdit(invoiceId, patientName){
    
    var nameBox = prompt("Change Patient Name", patientName);

    if(nameBox != null){
        window.location = 'invoice_edit.php?invoiceId='+invoiceId+'&patientName='+nameBox;
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

function confirmInvoiceOffice(id){
        
    var myBars = 'directories=no,location=no,menubar=yes,status=no';
    
    myBars += ',titlebar=yes,toolbar=no';
    
    var myOptions = 'scrollbars=no,width=750,height=500,resizeable=no,top=10, left=300,';
    var myFeatures = myBars + ',' + myOptions;
    
    
    var win = window.open('office_copy.php?id='+id, 'myDoc', myFeatures);
    
    return true;

}
</script>      
<style>
</style>
<!--onChange="document.location='due_payment.php?active=due_payment&idNo='+this.value"-->
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
            	<input type="text" class="input-control" id="idNo" name="idNo" placeholder="Search by ID" autoFocus>
            </div>
        </div>     
		
            <?php
			
			if(isset($_GET['idNo']) && $_GET['idNo'] <> ''){

				$query = $mysqli->query("select * from invoice where idNo = '$_GET[idNo]'");			
				
				if($query->num_rows > 0){
					if(isset($_GET['refd']) && $_GET['refd'] == 'doctor')
					{
					?>
						<script>
                        $(function(){
                            $('#refdPayRefd').prop('checked', true);
							$('#refd').prop('checked', true);
                        });
                        </script>
                    <?php	
					}else if(isset($_GET['refd']) && $_GET['refd'] == 'co')
					{
					?>
						<script>
                        $(function(){
                            $('#refdPayCo').prop('checked', true);
							$('#co').prop('checked', true);
                        });
                        </script>
                    <?php	
					}else{
					?>
						<script>
                        $(function(){
                            $('#refdPayCo').prop('checked', true);
							$('#co').prop('checked', true);
                        });
                        </script>
                    <?php
					}
					
					$array = $query->fetch_array();
					
                    ?>
                        <div align="center" style="margin: 5px 0px">
                            <?php $patientName = $array['patientName']; ?>
                            <a href="#" onclick='invoiceEdit(<?php echo $array['invoiceId']; ?>, "<?php echo $patientName; ?>")'><button class="btn btn-primary">Edit</button></a>
                            <a href="#" onclick="return confirmInvoice(<?php echo $array['invoiceId']; ?>)"><button class="btn btn-primary">Patient's Copy</button></a>
                            <a href="#" onclick="return confirmInvoiceOffice(<?php echo $array['invoiceId']; ?>)"><button class="btn btn-primary">Office Copy</button></a>
                        </div>
                    <?php

					$getCO = $mysqli->query("select * from co where coId = '$array[coId]'");
					$coArray = $getCO->fetch_array();
					
					$getRefd = $mysqli->query("select * from doctor where id = '$array[refdId]'");
					$refdArray = $getRefd->fetch_array();
					
					$refdFeeAmount = $mysqli->query("select sum(refdFeeAmount) from refdfeeamount where invoiceId = '$array[invoiceId]'");
					$refdAmountArray = $refdFeeAmount->fetch_array();
					
					$patientPayment = $mysqli->query("select sum(patientPayAmount) from patient_payment where invoiceId = '$array[invoiceId]'");
					$patientPayArray = $patientPayment->fetch_array();
					
					$patientDuePayment = $mysqli->query("select sum(patientDuePayAmount) from patient_due_payment where invoiceId = '$array[invoiceId]'");
					$patientDuePayArray = $patientDuePayment->fetch_array();
					
					$get_dis = $mysqli->query("select sum(disAmount) from patient_discount where invoiceId = '$array[invoiceId]'") or die($mysqli->error);
					$dis_array = $get_dis->fetch_array();
					
					$refdPayment = $mysqli->query("select sum(refdPayAmount), refdPaymentBy from refd_payment where invoiceId = '$array[invoiceId]'");
					$refdPayArray = $refdPayment->fetch_array();
					
					$writeOff = $mysqli->query("select sum(writeOffAmount) from write_off where invoiceId = '$array[invoiceId]'");
					$writeOffArray = $writeOff->fetch_array();
					
					$cashBack = $mysqli->query("select sum(cashBackAmount) from cash_back where invoiceId = '$array[invoiceId]'");
					$cashBackArray = $cashBack->fetch_array();
				?>
                <div class="row">
                	<div class="col-lg-5">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Refd. Prof./Dr./C/O Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form"  style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Refd By</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['doctor_name']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">C/O</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $coArray['coName']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Lab Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form" style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Patient SL</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['labDailySl']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">ID</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['idNo']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Patient Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="100px" style="padding:2px 3px; border-bottom:1px solid #999">Patient Name</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientName']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">Contact</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientMobile']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">Age</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientAge']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">Sex</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientSex']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
                <form action="due_payment_success.php" method="post">
                <input type="checkbox" style="display:none" id="refd" name="refd" value="doctor" />
                <input type="checkbox" style="display:none" id="co" name="co" value="co" />
                
                <input type="hidden" name="invoiceId" value="<?php echo $array['invoiceId']; ?>" />
                <input type="hidden" name="idNo" value="<?php echo $array['idNo']; ?>" />
                <input type="hidden" name="refdId" value="<?php echo $array['refdId']; ?>" />
                <input type="hidden" name="coId" value="<?php echo $array['coId']; ?>" />
                <div class="row">
                	<div class="col-lg-5">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Test Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form" style="min-height:200px; max-height:200px; overflow-y:scroll">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                    <td width="8%" align="center" style="font-weight:bold; padding:2px; border-bottom:4px double #999">Sl No.</td>
                                    <td align="center" width="75%" style="font-weight:bold; padding:2px; border-bottom:4px double #999">Test Name</td>
                                    <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double #999">Amount</td>
                                    <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double #999">Dis(%)</td>
                                    <td align="right" style="font-weight:bold; padding:2px; border-bottom:4px double #999">T. Amount</td>
                                </tr>
                                <?php
								$invoice = $mysqli->query("select * from invoice_tests join tests on invoice_tests.testId = tests.testId where invoice_tests.invoiceId = '$array[invoiceId]' order by invoice_tests.invoiceTestId asc");
								$sl = 1;
								while($invoiceRows = $invoice->fetch_array()){
                                    $tA = $invoiceRows['rate'] - ($invoiceRows['discount'] * $invoiceRows['rate'])/100;
								?>
                                <tr>
									<td width="6%" align="center" style="padding:2px; border-bottom:1px solid #999"><?php echo $sl; ?></td>
									<td align="left" width="55%" style="padding:2px; border-bottom:1px solid #999"><?php echo $invoiceRows['testName']; ?></td>
									<td align="center" style="padding:2px; border-bottom:1px solid #999"><?php echo sprintf('%.2f', $invoiceRows['rate']); ?></td>
                                    <td align="center" style="padding:2px; border-bottom:1px solid #999"><?php echo $invoiceRows['discount']; ?></td>
                                    <td align="right" style="padding:2px; border-bottom:1px solid #999"><?php echo sprintf('%.2f', $tA); ?></td>
								</tr>
                                <?php
								$sl++;
								}
								?>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Amount Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999">Test Amount</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right"><?php echo sprintf('%.2f', $array['totalTestAmount']); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Discount</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
									<?php
									echo sprintf('%.2f', $dis_array[0]);
									?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Net Amount</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
									<?php
									$net = ceil($array['totalTestAmount'] - $dis_array[0]);
									echo sprintf('%.2f', $net);
									?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Paid Amount</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
									<?php
                                    $paymentPayment = $patientPayArray[0] + $patientDuePayArray[0];
									echo sprintf('%.2f', $paymentPayment);
									?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Cash Back</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
                                    <?php
                                    echo sprintf('%.2f', $cashBackArray[0]);
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999; font-weight: bold;">Due</td>
                                    <td width="5px" style="border-bottom:1px solid #999; font-weight: bold;">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999; font-weight: bold;" align="right">
									<?php
									$patientDue = $net - ($patientPayArray[0] + $patientDuePayArray[0] + $writeOffArray[0] - $cashBackArray[0]);
									echo sprintf('%.2f', $patientDue);
									?>
                                    <input type="hidden" id="pPreDue" name="pPreDue" value="<?php echo $patientDue; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Refd Fee</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
									<?php
									$refdFee = $refdAmountArray[0] - $dis_array[0];
									echo sprintf('%.2f', $refdFee);
									?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Paid Refd Fee</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
									<?php
									echo sprintf('%.2f', $refdPayArray[0]);
									?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Refd Due</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right">
									<?php
									$refdDue = $refdFee - $refdPayArray[0];
									echo sprintf('%.2f', $refdDue);
									?>
                                    <input type="hidden" id="rPreDue" name="rPreDue" value="<?php echo $refdDue; ?>" />
                                    </td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Payment Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form">
                                <table border="0" width="100%" style="color:#000">
                                <?php
								if($patientDue > 0){
								?>
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999">P. Pay.</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right" colspan="2">
                                    	<input class="form-control" id="pPay" name="pPay" style="width:120px; text-align:right" autoComplete="off" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999">P. Due</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right" colspan="2">
                                    	<input class="form-control" id="pDue" name="pDue" style="width:120px; text-align:right" readonly="readonly" />
                                    </td>
                                </tr>
                                <?php
								}else if($patientDue == 0){
								?>
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999">Refd. Pay.</td>
                                    <td style="border-bottom:1px solid #999" align="right"><input type="radio" name="refdPayOption" id="refdPayRefd" value="refd" />Refd<input type="radio" name="refdPayOption" id="refdPayCo" value="co" />C/O</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right" colspan="2">
                                    	<input class="form-control" onfocus="this.select()" id="rPay" name="rPay" style="width:120px; text-align:right" autoComplete="off" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999">R. Due</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right" colspan="2">
                                    	<input class="form-control" id="rDue" name="rDue" style="width:120px; text-align:right" readonly="readonly" />
                                    </td>
                                </tr>
                                <?php
								}
								?>
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999">Cash Back</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right" colspan="2">
                                    	<input class="form-control" id="cbAmount" name="cbAmount" style="width:120px; text-align:right" />
                                    </td>
                                </tr>
                                <?php 
								if($patientDue > 0){
								?>
                                <tr>
                                    <td width="120px" style="padding:2px 3px; border-bottom:1px solid #999"><label class="control-label" for="writeOff">Write Off</label></td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999" align="right" colspan="2">
                                    	<input type="checkbox" id="writeOff" name="writeOff" value="writeOff" />
                                    </td>
                                </tr>
                                <?php
								}
								?>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12" align="center">
                    	<button type="submit" class="btn btn-primary" style="padding:5px 35px; font-weight:bold">Save</button>
                    </div>
                </div>
                </form>
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