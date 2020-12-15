<?php
ob_start();
@session_start();
require_once('connect.php');
?>

<!doctype html>
<html lang="en">

<head>
	<title><?php 
		$active = explode("_",$_GET['active']);
		
		foreach($active as $name){
			echo ucfirst($name);
			echo " ";
		}
	?> | <?php
                                      $labsql = "SELECT * FROM lab_info WHERE id=1";
                                      $result = $mysqli->query($labsql); 
                                      while ($row = $result->fetch_assoc()) {
                                        echo $row['lab_name'];
                                       }
                                    ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/logo.png">
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <script src="js/jquery-ui-1.10.4.min.js"></script>
    <script src="js/jquery.datepick.js"></script>
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="index.php"><img style="height:55px;" src="assets/img/logo.png" alt="Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<!-- <form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form>
				<div class="navbar-btn navbar-btn-right">
					<a class="btn btn-success update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
				</div> -->
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<!-- <li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li> -->
						<li class="dropdown">
							<a href="#d1" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-cog"></i> <span>Settings</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul id="#d1" class="dropdown-menu">
								<li><a class="" href="add_pathology.php?active=add_pathology">Add Pathology</a></li>
	                      		<li><a class="" href="add_user.php?active=add_user">Add User</a></li>
	                            <li><a class="" href="add_category.php?active=add_category">Add Category</a></li>
	                            <li><a class="" href="add_test.php?active=add_test">Add Test</a></li>
	                            <li><a class="" href="add_doctor.php?active=add_doctor">Add Doctor</a></li>
	                            <li><a class="" href="add_co.php?active=add_co">Add CO</a></li>
	                            <li><a class="" href="pathology_details.php?active=pathology_details">Pathology</a></li>
	                            <li><a class="" href="user_management.php?active=user_management">User Management</a></li>
	                            <li><a class="" href="category.php?active=category">Category</a></li>                          
	                            <li><a class="" href="test.php?active=test">Test</a></li>                          
	                            <li><a class="" href="doctor.php?active=doctor">Doctor</a></li>                          
	                            <li><a class="" href="co.php?active=co">CO</a></li> 
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								
								<li><a href="#"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
					   <?php
		                if($_SESSION['userType'] == 'Administrator'){
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
		                      <a href="#subPages3" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'pathology' || $_GET['active'] == 'urine' || $_GET['active'] == 'semen' || $_GET['active'] == 'stool' || $_GET['active'] == 'report' || $_GET['active'] == 'urine_report' || $_GET['active'] == 'semen_report' || $_GET['active'] == 'stool_report' || $_GET['active'] == 'bone_marrow' || $_GET['active'] == 'bone_marrow_report')){ echo 'active';} ?>">
		                          <i class="fa fa-gear"></i>
		                          <span>Pathology</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages3" class="collapse">
		                       <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="pathology.php?active=pathology">Pathology</a></li>
		                          <li><a <?php if($_GET['active'] == 'urine'){echo 'class="active"';} ?> href="urine.php?active=urine">Urine</a></li>
		                          <li><a <?php if($_GET['active'] == 'semen'){echo 'class="active"';} ?> href="semen.php?active=semen">Semen</a></li>
		                          <li><a <?php if($_GET['active'] == 'stool'){echo 'class="active"';} ?> href="stool.php?active=stool">Stool</a></li>
		                          <li><a <?php if($_GET['active'] == 'report'){echo 'class="active"';} ?> href="report.php?active=report">Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'urine_report'){echo 'class="active"';} ?> href="urine_report.php?active=urine_report">Urine Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'semen_report'){echo 'class="active"';} ?> href="semen_report.php?active=semen_report">Semen Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'stool_report'){echo 'class="active"';} ?> href="stool_report.php?active=stool_report">Stool Report</a></li>
		                      </ul>
		                  </li>
		                  <li >
		                      <a href="#subPages2" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'due_payment' || $_GET['active'] == 'refd_payment' || $_GET['active'] == 'co_payment')){ echo 'active';} ?>">
		                          <i class="fa fa-gear"></i>
		                          <span>Payment</span>
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
		                      <a href="#subPages1" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'receipt_report' || $_GET['active'] == 'daily_statement_refd' || $_GET['active'] == 'due_report' || $_GET['active'] == 'cancel_report' || $_GET['active'] == 'payment_report' || $_GET['active'] == 'due_collected_report' || $_GET['active'] == 'refd_payment_report')){ echo 'active';}?>">
		                          <i class="fa fa-gear"></i>
		                          <span>Report</span>
		                          <i class="icon-submenu lnr lnr-chevron-left"></i>
		                      </a>
		                      <div id="subPages1" class="collapse">
		                       <ul class="nav">
		                     
		                          <li><a <?php if($_GET['active'] == 'receipt_report'){echo 'class="active"';} ?> href="receipt_report.php?active=receipt_report">Receipt Report</a></li>
		                          <li><a <?php if($_GET['daily_statement_refd'] == 'pathology'){echo 'class="active"';} ?> href="daily_statement_refd.php?active=daily_statement_refd">Daily Statement</a></li>
		                          <li><a <?php if($_GET['active'] == 'due_report'){echo 'class="active"';} ?> href="due_report.php?active=due_report">Due Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'cancel_report'){echo 'class="active"';} ?> href="cancel_report.php?active=cancel_report">Cancel Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'payment_report'){echo 'class="active"';} ?> href="payment_report.php?active=payment_report">Payment Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'refd_payment_report'){echo 'class="active"';} ?> href="refd_payment_report.php?active=refd_payment_report">Refd Payment Report</a></li>
		                          <li><a <?php if($_GET['active'] == 'due_collected_report'){echo 'class="active"';} ?> href="due_collected_report.php?active=due_collected_report">Due Collection Report</a></li>
		                      </ul>
		                     </div>
		                  </li>
		                  <li >
		                      <a href="#subPages" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'user_management' || $_GET['active'] == 'add_test' || $_GET['active'] == 'add_user' || $_GET['active'] == 'add_doctor' || $_GET['active'] == 'test' || $_GET['active'] == 'doctor' || $_GET['active'] == 'add_category' || $_GET['active'] == 'category' || $_GET['active'] == 'add_co' || $_GET['active'] == 'co' || $_GET['active'] == 'add_pathology' || $_GET['active'] == 'pathology_details' || $_GET['active'] == 'add_bone_marrow')){ echo 'active';} ?>">
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
		                            <li><a <?php if($_GET['active'] == 'pathology_details'){echo 'class="active"';} ?> href="pathology_details.php?active=pathology_details">Pathology</a></li>
		                            <li><a <?php if($_GET['active'] == 'user_management'){echo 'class="active"';} ?> href="user_management.php?active=user_management">User Management</a></li>
		                            <li><a <?php if($_GET['active'] == 'category'){echo 'class="active"';} ?> href="category.php?active=category">Category</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'test'){echo 'class="active"';} ?> href="test.php?active=test">Test</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'doctor'){echo 'class="active"';} ?> href="doctor.php?active=doctor">Doctor</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'co'){echo 'class="active"';} ?> href="co.php?active=co">CO</a></li>                          
		                      </ul>
		                     </div>
		                  </li> 






		                  <?php
						}else if($_SESSION['userType'] == 'User'){
						?>
		                  <li <?php if(isset($_GET['active']) && $_GET['active'] == 'dashboard'){ echo 'class="active"';} ?>>
		                      <a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="dashboard.php?active=dashboard">
		                          <i class="icon_house_alt"></i>
		                          <span>Dashboard</span>
		                      </a>
		                  </li>
						  <li class="sub-menu <?php if(isset($_GET['active']) && ($_GET['active'] == 'receipt')){ echo 'active';} ?>">
		                      <a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="receipt.php?active=receipt">
		                          <i class="fa fa-shopping-cart"></i>
		                          <span>Receipt</span>
		                      </a>
		                  </li> 
		                  <li class="<?php if(isset($_GET['active']) && ($_GET['active'] == 'due_payment' || $_GET['active'] == 'refd_payment' || $_GET['active'] == 'co_payment')){ echo 'active';} ?>">
		                      <a href="javascript:;" <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?>>
		                          <i class="fa fa-bank"></i>
		                          <span>Payment</span>
		                          <span class="menu-arrow arrow_carrot-right"></span>
		                      </a>
		                      <ul class="nav">
		                          <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="due_payment.php?active=due_payment">Due Payment</a></li>
		                          <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="refd_payment_details.php?active=refd_payment">Refd Pay Info</a></li>
		                          <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="co_payment_details.php?active=co_payment">C/O Pay Info</a></li>
		                      </ul>
		                  </li>
		                  <li class="sub-menu <?php if(isset($_GET['active']) && ($_GET['active'] == 'user_management' || $_GET['active'] == 'add_test' || $_GET['active'] == 'add_user' || $_GET['active'] == 'add_doctor' || $_GET['active'] == 'test' || $_GET['active'] == 'doctor' || $_GET['active'] == 'add_category' || $_GET['active'] == 'category' || $_GET['active'] == 'add_co' || $_GET['active'] == 'co' || $_GET['active'] == 'add_pathology' || $_GET['active'] == 'pathology_details')){ echo 'active';} ?>">
		                      <a href="javascript:;" <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?>>
		                          <i class="fa fa-wrench"></i>
		                          <span>Settings</span>
		                          <span class="menu-arrow arrow_carrot-right"></span>
		                      </a>
		                      <ul class="nav">
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="add_category.php?active=add_category">Add Category</a></li>
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="add_test.php?active=add_test">Add Test</a></li>
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="add_doctor.php?active=add_doctor">Add Doctor</a></li>
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="add_co.php?active=add_co">Add CO</a></li>
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="category.php?active=category">Category</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="test.php?active=test">Test</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="doctor.php?active=doctor">Doctor</a></li>                          
		                            <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="co.php?active=co">CO</a></li>                          
		                      </ul>
		                  </li> 
		                	



		                	
						<?php	
						}else if($_SESSION['userType'] == 'Pathology'){
						?>	
							<li <?php if(isset($_GET['active']) && $_GET['active'] == 'dashboard'){ echo 'class="active"';} ?>>
		              <a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="dashboard.php?active=dashboard">
		                  <i class="icon_house_alt"></i>
		                  <span>Dashboard</span>
		              </a>
		          </li>
		          <li >
                      <a href="#subPages3" data-toggle="collapse" class="collapsed <?php if(isset($_GET['active']) && ($_GET['active'] == 'pathology' || $_GET['active'] == 'urine' || $_GET['active'] == 'semen' || $_GET['active'] == 'stool' || $_GET['active'] == 'report' || $_GET['active'] == 'urine_report' || $_GET['active'] == 'semen_report' || $_GET['active'] == 'stool_report' || $_GET['active'] == 'bone_marrow' || $_GET['active'] == 'bone_marrow_report')){ echo 'active';} ?>">
                          <i class="fa fa-gear"></i>
                          <span>Pathology</span>
                          <i class="icon-submenu lnr lnr-chevron-left"></i>
                      </a>
                      <div id="subPages3" class="collapse">
                       <ul class="nav">
                          <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="pathology.php?active=pathology">Pathology</a></li>
                          <li><a <?php if($_GET['active'] == 'urine'){echo 'class="active"';} ?> href="urine.php?active=urine">Urine</a></li>
                          <li><a <?php if($_GET['active'] == 'semen'){echo 'class="active"';} ?> href="semen.php?active=semen">Semen</a></li>
                          <li><a <?php if($_GET['active'] == 'stool'){echo 'class="active"';} ?> href="stool.php?active=stool">Stool</a></li>
                          <li><a <?php if($_GET['active'] == 'report'){echo 'class="active"';} ?> href="report.php?active=report">Report</a></li>
                          <li><a <?php if($_GET['active'] == 'urine_report'){echo 'class="active"';} ?> href="urine_report.php?active=urine_report">Urine Report</a></li>
                          <li><a <?php if($_GET['active'] == 'semen_report'){echo 'class="active"';} ?> href="semen_report.php?active=semen_report">Semen Report</a></li>
                          <li><a <?php if($_GET['active'] == 'stool_report'){echo 'class="active"';} ?> href="stool_report.php?active=stool_report">Stool Report</a></li>
                      </ul>
                  </li> 
		          <li class="sub-menu <?php if(isset($_GET['active']) && ($_GET['active'] == 'user_management' || $_GET['active'] == 'add_test' || $_GET['active'] == 'add_user' || $_GET['active'] == 'add_doctor' || $_GET['active'] == 'test' || $_GET['active'] == 'doctor' || $_GET['active'] == 'add_category' || $_GET['active'] == 'category' || $_GET['active'] == 'add_co' || $_GET['active'] == 'co' || $_GET['active'] == 'add_pathology' || $_GET['active'] == 'pathology_details')){ echo 'active';} ?>">
		              <a href="javascript:;" <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?>>
		                  <i class="fa fa-wrench"></i>
		                  <span>Settings</span>
		                  <span class="menu-arrow arrow_carrot-right"></span>
		              </a>
		              <ul class="nav">
		                  <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="add_pathology.php?active=add_pathology">Add Pathology</a></li>
		                  <li><a <?php if($_GET['active'] == 'pathology'){echo 'class="active"';} ?> href="pathology_details.php?active=pathology_details">Pathology</a></li>                          
		              </ul>
		          </li>
		        <?php
						}
						  ?> 





						
					</ul>
				</nav>
			</div>
		</div>


<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid"> 