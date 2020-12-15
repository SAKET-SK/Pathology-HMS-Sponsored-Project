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
				<div class="col-md-6">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Bar Chartt</h3>
								</div>
								<div class="panel-body">
									<div id="demo-bar-chart" class="ct-chart">sgdrhg
									    <?php date_default_timezone_set('UTC');
		$mkdate = mktime(date('H') + 6, date('i'), date('s'));
		$date = date('Y-m-d', $mkdate);
		echo $date;
		$time = date('h:i:s', $mkdate);
		$query= $mysqli->query("select count(*) from invoice where invoiceDate=$date "); 
		echo $query; echo "2";
		?> 
									    
									    
									    
									</div>
								</div>
							</div>
						</div>
					</div>
				
	</section>
</section>
<?php

require_once('include/footer.php');	
}
else{
	header("Location:index.php");	
}
?>