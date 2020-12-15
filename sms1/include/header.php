<?php
ob_start();
@session_start();
require_once('connect.php');
?>

<!doctype html>
<html lang="en">

<head>
	<title><?php
	if(isset($_GET['active'])){
		$active = explode("_",$_GET['active']);
		
		foreach($active as $name){
			echo ucfirst($name);
			echo " ";
		}
		echo "|";
	}
	?> <?php
                  $labsql = "SELECT * FROM lab_info WHERE id=1";
                  $result = $mysqli->query($labsql); 
                  while ($row = $result->fetch_assoc()) {
                    echo $row['lab_name'];
                    }
                ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<!-- VENDOR CSS -->
<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <script src="js/jquery-ui-1.10.4.min.js"></script>

	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	
	

<!--	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>-->
	
	
	
	


	<!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>	 
	<script src="js/bootstrap.js"></script>

	
<style>
    .active + .collapse {display:block!important;}

 
</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->		
		<nav class="navbar navbar-default navbar-fixed-top ">

					
						
						<div class="navbar-collapse collapse">
						<ul class="nav navbar-left">
							<!-- start: MESSAGES DROPDOWN -->
								
								<h2><b><font color="white" size="5px">&nbsp&nbsp&nbsp&nbspNath Pathology</font></b></h2>
							</li>
							
						
						
							
				
					
					<!-- end: NAVBAR COLLAPSE -->
				</header>

			<!--<div class="brand">
				<a href="index.php"><img style="height:40px;" src="assets/img/logo.png"  class="img-responsive logo"></a>
			</div>-->
			<div class="container-fluid">
			<!--	<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>-->

			<!--	<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
                      <?php
		                if($_SESSION['userType'] == 'Administrator'){
		                ?>
						<li class="dropdown">
							<a href="#settings" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-cog"></i> <span>Settings</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul id="#settings" class="dropdown-menu">
								<li><a class="" href="add_pathology.php?active=add_pathology">Add Pathology</a></li>
	                      		<li><a class="" href="add_user.php?active=add_user">Add User</a></li>
	                            <li><a class="" href="add_category.php?active=add_category">Add Category</a></li>
	                            <li><a class="" href="add_test.php?active=add_test">Add Test</a></li>
	                            <li><a class="" href="add_doctor.php?active=add_doctor">Add Doctor</a></li>
	                            <li><a class="" href="add_co.php?active=add_co">Add CO</a></li>
	                            <li><a class="" href="pathology_details.php?active=pathology_details">Pathology Details</a></li>
	                            <li><a class="" href="user_management.php?active=user_management">User Management</a></li>
	                            <li><a class="" href="category.php?active=category">All Category</a></li>                          
	                            <li><a class="" href="test.php?active=test">All Test</a></li>                          
	                            <li><a class="" href="doctor.php?active=doctor">All Doctor</a></li>                          
	                            <li><a class="" href="co.php?active=co">All CO</a></li> 
							</ul>
						</li>
						<?php } ?>
						<li class="dropdown">--
							<a href="#log" class="dropdown-toggle" data-toggle="dropdown">
							<i class="lnr lnr-user"></i> 
							<span>
                            <?php 
                              $id=$_SESSION['userId'];
                              $query = $mysqli->query("select * from user where id=$id");
                              while($rows = $query->fetch_array()){
                              	echo $rows['full_name'];
                              }

                            ?>


							</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								
								<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>

					</ul>
				</div>-->
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<br>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
					   <?php
		                if($_SESSION['userType'] == 'Administrator'){
		                ?>                
		                  <li >
		                      <a <?php if(isset($_GET['active']) && $_GET['active'] == 'dashboard'){ echo 'class="active"';} ?> href="dashboard.php?active=dashboard">
		                          <i class="lnr lnr-home" color="#51C6EA"></i>
		                          <span>Dashboard</span>
		                      </a>
		                  </li>
						  <li >
		                      <a  <?php if(isset($_GET['active']) && ($_GET['active'] == 'receipt')){ echo 'class="active"';} ?> href="receipt.php?active=receipt">
		                         <i class="fa fa-user" ></i>
		                          <!--<i class="fa fa-id-card-o" aria-hidden="true"></i>-->
		                          <span>Add Patient</span>
		                      </a>
		                  </li>
		                 <!-- <li >
		                      <a href="#subPages3" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'pathology_test'||$_GET['active'] == 'cbc_report'||$_GET['active'] == 'cbc_test'  || $_GET['active'] == 'urine_test' || $_GET['active'] == 'semen_report' || $_GET['active'] == 'stool_test' || $_GET['active'] == 'pathology_report' || $_GET['active'] == 'urine_report' || $_GET['active'] == 'semen_test' || $_GET['active'] == 'stool_report' || $_GET['active'] == 'bone_marrow' || $_GET['active'] == 'bone_marrow_report')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-stethoscope"></i>
		                          <span>Pathology</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages3" class="collapse">
		                       <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'pathology_test'){echo 'class="active"';} ?> href="pathology.php?active=pathology_test">Pathology Test</a></li>
		                         < !-- <li><a <?php if($_GET['active'] == 'urine_test'){echo 'class="active"';} ?> href="urine.php?active=urine_test">Urine Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'semen_test'){echo 'class="active"';} ?> href="semen.php?active=semen_test">Semen Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'stool_test'){echo 'class="active"';} ?> href="stool.php?active=stool_test">Stool Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'cbc_test'){echo 'class="active"';} ?> href="cbc.php?active=cbc_test">CBC Test</a></li>-->
		                         <!-- <li><a <?php if($_GET['active'] == 'pathology_report'){echo 'class="active"';} ?> href="report.php?active=pathology_report">Pathology Report</a></li>-->
		                        <!--  <li><a <?php if($_GET['active'] == 'urine_report'){echo 'class="active"';} ?> href="urine_report.php?active=urine_report">Urine Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'semen_report'){echo 'class="active"';} ?> href="semen_report.php?active=semen_report">Semen Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'stool_report'){echo 'class="active"';} ?> href="stool_report.php?active=stool_report">Stool Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'cbc_report'){echo 'class="active"';} ?> href="cbc_report.php?active=cbc_report">CBC Report</a></li>
		                      </ul>
		                  </li>-->
		                    <li >
		                     <a <?php if($_GET['active'] == 'pathology_test'){echo 'class="active"';} ?> href="pathology.php?active=pathology_test">
		                         <i class="fa fa-list" ></i>
		                         
		                          <span>Pending Patient</span>
		                      </a>
		                  </li>
		                   <li >
		                    <a <?php if($_GET['active'] == 'pathology_report'){echo 'class="active"';} ?> href="report.php?active=pathology_report">
		                         <i class="fa fa-users" ></i>
		                          <!--<i class="fa fa-id-card-o" aria-hidden="true"></i>-->
		                          <span>Manage Patient</span>
		                      </a>
		                  </li>
		                  <li >
		                      <a href="#subPages2" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'due_payment' || $_GET['active'] == 'refd_payment' || $_GET['active'] == 'co_payment')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa ">৳ </i>
		                          <span> Invoice Details</span>
		                          <i class="icon-submenu lnr lnr-chevron-left" ></i>
		                      </a>
		                      <div id="subPages2" class="collapse">
		                       <ul class="nav">
		                       	 <li><a <?php if($_GET['active'] == 'receipt_report'){echo 'class="active"';} ?>href="receipt_report.php?active=receipt_report">Search Invoice</a></li>
		                        <!--  <li><a <?php if($_GET['active'] == 'due_payment'){echo 'class="active"';} ?> href="due_payment.php?active=due_payment">Due Payment</a></li>
		                          <li><a <?php if($_GET['active'] == 'refd_payment'){echo 'class="active"';} ?> href="refd_payment_details.php?active=refd_payment">Refd Pay Info</a></li>
		                          <li><a <?php if($_GET['active'] == 'co_payment'){echo 'class="active"';} ?> href="co_payment_details.php?active=co_payment">C/O Pay Info</a></li>-->
		                      </ul>
		                  </li>
		                  <li >
		                      <a href="#subPages4" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'add_head' || $_GET['active'] == 'add_expense' || $_GET['active'] == 'expense'||$_GET['active'] == 'todays_expense')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-money" ></i
		                          <span>Inventory</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages4" class="collapse">
		                       <ul class="nav">
		                          
		                          <li><a <?php if($_GET['active'] == 'add_expense'){echo 'class="active"';} ?> href="addexpense.php?active=add_expense">Add Inventory</a></li>
		                          <li><a <?php if($_GET['active'] == 'todays_expense'){echo 'class="active"';} ?> href="todays_expense.php?active=todays_expense">Today's Inventory Details</a></li>
		                          <li><a <?php if($_GET['active'] == 'expense'){echo 'class="active"';} ?> href="expense_list.php?active=expense">All Inventory Details</a></li>
		                      </ul>
		                  </li>
		                  <li >
		                      <a href="#subPages1" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'receipt_report' ||$_GET['active'] == 'balance_report' || $_GET['active'] == 'daily_statement_refd' || $_GET['active'] == 'due_report' || $_GET['active'] == 'cancel_report' || $_GET['active'] == 'payment_report' || $_GET['active'] == 'due_collected_report' || $_GET['active'] == 'refd_payment_report')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-file" aria-hidden="true"></i>
		                          <span>Report</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages1" class="collapse">
		                       <ul class="nav">
		                           <li><a <?php if($_GET['active'] == 'balance_report'){echo 'class="active"';} ?>href="balance_report.php?active=balance_report">Balance Report</a></li>
		                     
		                          <li><a <?php if($_GET['active'] == 'receipt_report'){echo 'class="active"';} ?>href="receipt_report.php?active=receipt_report">Receipt Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'daily_statement_refd'){echo 'class="active"';} ?> href="daily_statement_refd.php?active=daily_statement_refd">Daily St. of Refd</a></li>
		                          <li><a <?php if($_GET['active'] == 'due_report'){echo 'class="active"';} ?> href="due_report.php?active=due_report">Due Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'cancel_report'){echo 'class="active"';} ?> href="cancel_report.php?active=cancel_report">Cancel Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'payment_report'){echo 'class="active"';} ?> href="payment_report.php?active=payment_report">Payment Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'refd_payment_report'){echo 'class="active"';} ?> href="refd_payment_report.php?active=refd_payment_report">Refd Payment Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'due_collected_report'){echo 'class="active"';} ?> href="due_collected_report.php?active=due_collected_report">Due Coll. Report</a></li>
		                      </ul>
		                     </div>
		                  </li>
		                  <li >
		                      <a href="#subPages" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'user_management' || $_GET['active'] == 'add_test' || $_GET['active'] == 'add_user' || $_GET['active'] == 'add_doctor' || $_GET['active'] == 'test' || $_GET['active'] == 'doctor' || $_GET['active'] == 'add_category' || $_GET['active'] == 'category' || $_GET['active'] == 'add_co' || $_GET['active'] == 'co' || $_GET['active'] == 'add_pathology' || $_GET['active'] == 'pathology_details' || $_GET['active'] == 'add_bone_marrow')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-gear"></i>
		                          <span>Settings</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages" class="collapse ">
		                       <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'add_pathology'){echo 'class="active"';} ?> href="add_pathology.php?active=add_pathology">Add Pathology</a></li>
		                      		<li><a <?php if($_GET['active'] == 'add_user'){echo 'class="active"';} ?> href="add_user.php?active=add_user">Add User</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_category'){echo 'class="active"';} ?> href="add_category.php?active=add_category">Add Category</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_test'){echo 'class="active"';} ?> href="add_test.php?active=add_test">Add Test</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_doctor'){echo 'class="active"';} ?> href="add_doctor.php?active=add_doctor">Add Doctor</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_co'){echo 'class="active"';} ?> href="add_co.php?active=add_co">Add CO</a></li>
		                            <li><a <?php if($_GET['active'] == 'pathology_details'){echo 'class="active"';} ?> href="pathology_details.php?active=pathology_details">Pathology Details</a></li>
		                            <li><a <?php if($_GET['active'] == 'user_management'){echo 'class="active"';} ?> href="user_management.php?active=user_management">User Management</a></li>
		                            <li><a <?php if($_GET['active'] == 'category'){echo 'class="active"';} ?> href="category.php?active=category">All Category</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'test'){echo 'class="active"';} ?> href="test.php?active=test">All Test</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'doctor'){echo 'class="active"';} ?> href="doctor.php?active=doctor">All Doctor</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'co'){echo 'class="active"';} ?> href="co.php?active=co">All CO</a></li>                          
		                      </ul>
		                     </div>
		                  </li>
		                  <li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>






		                  <?php
						}else if($_SESSION['userType'] == 'User'){
						?>
		                  <li >
		                      <a <?php if(isset($_GET['active']) && $_GET['active'] == 'dashboard'){ echo 'class="active"';} ?> href="dashboard.php?active=dashboard">
		                          <i class="lnr lnr-home"></i>
		                          <span>Dashboard</span>
		                      </a>
		                  </li>
						  <li >
		                      <a  <?php if(isset($_GET['active']) && ($_GET['active'] == 'receipt')){ echo 'class="active"';} ?> href="receipt.php?active=receipt">
		                         <i class="fa fa-medkit"></i>
		                          <!--<i class="fa fa-id-card-o" aria-hidden="true"></i>-->
		                          <span>Receipt</span>
		                      </a>
		                  </li>
		                  <li >
		                      <a href="#subPages2" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'due_payment' || $_GET['active'] == 'refd_payment' || $_GET['active'] == 'co_payment')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa ">৳ </i>
		                          <span> Payment</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages2" class="collapse">
		                       <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'due_payment'){echo 'class="active"';} ?> href="due_payment.php?active=due_payment">Due Payment</a></li>
		                          <li><a <?php if($_GET['active'] == 'refd_payment'){echo 'class="active"';} ?> href="refd_payment_details.php?active=refd_payment">Refd Pay Info</a></li>
		                          <li><a <?php if($_GET['active'] == 'co_payment'){echo 'class="active"';} ?> href="co_payment_details.php?active=co_payment">C/O Pay Info</a></li>
		                      </ul>
		                  </li>
		                  <li >
		                      <a href="#subPages" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'user_management' || $_GET['active'] == 'add_test' || $_GET['active'] == 'add_user' || $_GET['active'] == 'add_doctor' || $_GET['active'] == 'test' || $_GET['active'] == 'doctor' || $_GET['active'] == 'add_category' || $_GET['active'] == 'category' || $_GET['active'] == 'add_co' || $_GET['active'] == 'co' || $_GET['active'] == 'add_pathology' || $_GET['active'] == 'pathology_details' || $_GET['active'] == 'add_bone_marrow')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-gear"></i>
		                          <span>Settings</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages" class="collapse ">
		                       <ul class="nav">
		                          
		                      		
		                            <li><a <?php if($_GET['active'] == 'add_category'){echo 'class="active"';} ?> href="add_category.php?active=add_category">Add Category</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_test'){echo 'class="active"';} ?> href="add_test.php?active=add_test">Add Test</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_doctor'){echo 'class="active"';} ?> href="add_doctor.php?active=add_doctor">Add Doctor</a></li>
		                            <li><a <?php if($_GET['active'] == 'add_co'){echo 'class="active"';} ?> href="add_co.php?active=add_co">Add CO</a></li>
		                            
		                            <li><a <?php if($_GET['active'] == 'category'){echo 'class="active"';} ?> href="category.php?active=category">All Category</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'test'){echo 'class="active"';} ?> href="test.php?active=test">All Test</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'doctor'){echo 'class="active"';} ?> href="doctor.php?active=doctor">All Doctor</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'co'){echo 'class="active"';} ?> href="co.php?active=co">All CO</a></li>                          
		                      </ul>
		                     </div>
		                  </li>
		                	 <li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>




						<?php	
						}else if($_SESSION['userType'] == 'Pathology'){
						?>	
							<li >
		                      <a <?php if(isset($_GET['active']) && $_GET['active'] == 'dashboard'){ echo 'class="active"';} ?> href="dashboard.php?active=dashboard">
		                          <i class="lnr lnr-home"></i>
		                          <span>Dashboard</span>
		                      </a>
		                  </li>
		                 <li >
		                      <a href="#subPages3" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'pathology_test'||$_GET['active'] == 'cbc_report'||$_GET['active'] == 'cbc_test'  || $_GET['active'] == 'urine_test' || $_GET['active'] == 'semen_report' || $_GET['active'] == 'stool_test' || $_GET['active'] == 'pathology_report' || $_GET['active'] == 'urine_report' || $_GET['active'] == 'semen_test' || $_GET['active'] == 'stool_report' || $_GET['active'] == 'bone_marrow' || $_GET['active'] == 'bone_marrow_report')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-stethoscope"></i>
		                          <span>Pathology</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages3" class="collapse">
		                       <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'pathology_test'){echo 'class="active"';} ?> href="pathology.php?active=pathology_test">Pathology Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'urine_test'){echo 'class="active"';} ?> href="urine.php?active=urine_test">Urine Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'semen_test'){echo 'class="active"';} ?> href="semen.php?active=semen_test">Semen Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'stool_test'){echo 'class="active"';} ?> href="stool.php?active=stool_test">Stool Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'cbc_test'){echo 'class="active"';} ?> href="cbc.php?active=cbc_test">CBC Test</a></li>
		                          <li><a <?php if($_GET['active'] == 'pathology_report'){echo 'class="active"';} ?> href="report.php?active=pathology_report">Pathology Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'urine_report'){echo 'class="active"';} ?> href="urine_report.php?active=urine_report">Urine Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'semen_report'){echo 'class="active"';} ?> href="semen_report.php?active=semen_report">Semen Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'stool_report'){echo 'class="active"';} ?> href="stool_report.php?active=stool_report">Stool Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'cbc_report'){echo 'class="active"';} ?> href="cbc_report.php?active=cbc_report">CBC Report</a></li>
		                      </ul>
		                  </li>
				          <li >
		                      <a href="#subPages" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'user_management' || $_GET['active'] == 'add_test' || $_GET['active'] == 'add_user' || $_GET['active'] == 'add_doctor' || $_GET['active'] == 'test' || $_GET['active'] == 'doctor' || $_GET['active'] == 'add_category' || $_GET['active'] == 'category' || $_GET['active'] == 'add_co' || $_GET['active'] == 'co' || $_GET['active'] == 'add_pathology' || $_GET['active'] == 'pathology_details' || $_GET['active'] == 'add_bone_marrow')){ echo 'active';}else{echo 'collapsed';} ?>">
		                          <i class="fa fa-gear"></i>
		                          <span>Settings</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages" class="collapse ">
		                       <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'add_pathology'){echo 'class="active"';} ?> href="add_pathology.php?active=add_pathology">Add Pathology</a></li>
		                      		
		                            <li><a <?php if($_GET['active'] == 'pathology_details'){echo 'class="active"';} ?> href="pathology_details.php?active=pathology_details">Pathology Details</a></li>
		                                 <li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>                      
		                      </ul>
		                     </div>
		                  </li>
		                
		               <?php
						}
						  ?>
						<!-- <li><a href="developer.php"><i class="lnr lnr-mustache"></i><span>Developer</span></a></li> -->
					</ul>
				</nav>
			</div>
		</div>


<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid"> 