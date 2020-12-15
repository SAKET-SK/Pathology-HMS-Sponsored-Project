<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && $_SESSION['userType'] == 'Administrator'){
require_once('include/header.php');
require_once('connect.php');


?>
<style>
.control-label{
	color:#000;
	font-weight:bold;
	cursor:pointer;
}
.form-control{
	color:#000;
	border:1px solid;
}
</style>      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!--overview start-->
			  <div class="row">
					<h1>Add Inventory</h1>
				</div>


<div class="">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class=""><center>Add New Inventory Details</center></div>
                </div>
                <div class="panel-body">
                  <div class="padd">
		<form action="" id="expense" method="post">
		    <br>
			<h4>Inventory Item*</h4>
			<input type="text" name="name" placeholder="Inventory Name" required/>
			<br>
			


			<h4>Amount*</h4>
			<input type="number" name="amount" placeholder="Expense Amount" required/>
			<br>
			<h4>Quantity*</h4>
			<input type="number" name="quantity" placeholder="Quantity Of items" />
			<br>
			<br>
			<center><button type="submit" class="btn btn-primary" name="submit" >Add Inventory</button></center>
		</form>
	</div>
</div>
</div>
</div>
</section>
</section>

<?php
date_default_timezone_set('Asia/Dhaka');
$date = date('Y-m-d H:i:s');




//$by=$_SESSION['fullName'];
//echo $by;
if ( isset($_POST['submit']) ) {
	//	$id = trim($_POST['id']);
		//$exp_type = trim($_POST['exp_type']);
		$name = trim($_POST['name']);
		$amount = trim($_POST['amount']);
		$details = trim($_POST['quantity']);
	//	$by=trim($_SESSION['fullName']);

		$query = $mysqli->query("INSERT INTO expense_details (details,  date, amount, quantity) VALUES('$name','$date','$amount','$details')");
        echo $mysqli->error;

}
require_once('include/footer.php');	
}
else{
	header("Location:index.php");	
}
?>
