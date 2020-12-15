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
					<h1>&nbsp&nbsp&nbspDashboard</h1>
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
          <div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> </span>
											<h4 class="StepTitle">Profile Details</h4>
											
										<!--	<p class="links cl-effect-1">
												<a href="edit-profile.php">
													View Profile
												</a>
											</p>-->
										<h2>	 <?php 
                              $id=$_SESSION['userId'];
                              $query = $mysqli->query("select * from user where id=$id");
                              while($rows = $query->fetch_array()){
                              	echo $rows['full_name'];
                              }

                            ?>
  </h2>

										</div>
									</div>
								</div>
								
								
							</div>
						</div>
		
      <!--    <div class="row">
                
                <div class="col-md-5">
					    <div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Today's Report</h3>
								<div class="right">
									<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
								</div>
							</div>
							
							<div class="panel-body ">
							   s
							</div>
							
						</div>
				</div>
				
				 
				

		</div>-->
	</section>
	
 
</section>
<br>
<br>
<?php
require_once('include/footer.php');	
}else{
	//ader("Location:index.php");	
}
?>