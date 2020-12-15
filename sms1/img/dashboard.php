<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('include/header.php');
?>
      
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
              
         
          <script>
		  $(document).ready(function(){
			  	window.onresize = function(event){
					document.getElementById('size').innerHTML = $(window).width();
				}
			});
		  </script>
		
		     
              <!-- project team & activity end -->

         </section>
          
		         <div class="row" style="margin-bottom:20px;">
								<div class="col-md-3">
									<div class="metric " style="background: #ea6d12;">
										<span class="icon"><i class="fa fa-user-md"></i></span>
										<p>
										<span class="number">
										<?php 
										if ($result = $mysqli->query("SELECT * FROM doctor")) {
										    $row_cnt = $result->num_rows;
										    echo $row_cnt;
										}
										else echo "0";
										?>
										 </span>
										 <span class="title">Doctorss</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric" style="background:#044b04;">
										<span class="icon"><i class="fa fa-stethoscope"></i></span>
										<p>
											<span class="number">
												<?php 
												if ($result = $mysqli->query("SELECT * FROM test_category")) {
												    $row_cnt = $result->num_rows;
												    echo $row_cnt;
												}
												else echo "0";
												?>
													</span>
											<span class="title">Pathology</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric" style="background: #ff0900;">
										<span class="icon"><i class="fa fa-heartbeat"></i></span>
										<p>
											<span class="number">
												<?php 
												if ($result = $mysqli->query("SELECT * FROM tests")) {
												    $row_cnt = $result->num_rows;
												    echo $row_cnt;
												}
												else echo "0";
												?>
											</span>
											<span class="title">Test</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric" style="background: #161e59;">
										<span class="icon"><i class="fa fa-medkit"></i></span>
										<p>
											<span class="number">
												<?php 
												if ($result = $mysqli->query("SELECT * FROM report")) {
												    $row_cnt = $result->num_rows;
												    echo $row_cnt;
												}
												else echo "0";
												?>
											</span>
											<span class="title">Services</span>
										</p>
									</div>
								
							
							 
          </div>
          </div>
          <div class="row">
                <div class="col-md-4">
					    <div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Today's Report</h3>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
								</div>
							</div>
							
							<div class="panel-body ">
							    <?php require_once('report_dashboard.php'); ?>
							</div>
							
						</div>
				</div>
				<div class="col-md-8">
					<!-- RECENT PURCHASES -->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Today's Expenses</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body no-padding">
							<?php require_once('expense_dashboard.php'); ?> 
						</div>
						
					</div>
					<!-- END RECENT PURCHASES -->
				</div>

		</div>
       
          

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>