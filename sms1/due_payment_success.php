<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('connect.php');
$mktime = mktime(date("H")+6, date("i"), date("s"));
$date = date('Y-m-d',$mktime);
$time = date('H:i:s', $mktime);

	if($_POST['pPay'] <> ''){
	    
		
		if($_POST['pDue'] == 0){
			$mysqli->query("update invoice set isDue = '0' where invoiceId = '$_POST[invoiceId]'");
		}
		
		$mysqli->query("insert into patient_due_payment (invoiceId,patientDuePayAmount,patientDuePayDate,isCancel) values( '$_POST[invoiceId]', '$_POST[pPay]', '$date', '0')");
	}
	
	if($_POST['rPay'] <> ''){
	    //echo $mysqli->error;
		
		if($_POST['refdPayOption'] == 'refd')
		{
			$mysqli->query("insert into refd_payment (invoiceId,refdId,coId,refdPayAmount,refdPaymentBy,refdPayDate,isCancel) values('$_POST[invoiceId]', '$_POST[refdId]', '0', '$_POST[rPay]', '$_SESSION[fullName]', '$date', '0')");
		}else{
			$mysqli->query("insert into refd_payment (invoiceId,refdId,coId,refdPayAmount,refdPaymentBy,refdPayDate,isCancel) values('$_POST[invoiceId]', '0', '$_POST[coId]', '$_POST[rPay]', '$_SESSION[fullName]', '$date', '0')");
		}
		
	}
	
	if(isset($_POST['writeOff']) && $_POST['writeOff'] == 'writeOff'){
		$mysqli->query("insert into write_off (invoiceId,writeOffAmount,writeOffDate,isCancel) values('$_POST[invoiceId]', '$_POST[pPreDue]', '$date', '0')");
		$mysqli->query("update invoice set isDue = '0' where invoiceId = '$_POST[invoiceId]'") or die($mysqli->error);
	}
	
	if(isset($_POST['cbAmount']) && $_POST['cbAmount'] <> ''){
		
		$mysqli->query("insert into cash_back (invoiceId,CashBackAmount,CashBackDate,isCancel) values('$_POST[invoiceId]', '$_POST[cbAmount]', '$date', '0')");	
		
	}
	
	if(isset($_POST['refd'])){
		$refd = $_POST['refd'];	
	}else{
		$refd = $_POST['co'];	
	}
	
	header("Location:due_payment.php?active=due_payment&idNo=$_POST[idNo]&refd=$refd");


}else{
	header("Location:index.php");	
}
?>