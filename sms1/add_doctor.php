<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'User')){
require_once('include/header.php');
require_once('connect.php');
?>
<style>
.control-label{
	color:#000;
	font-weight:bold;
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
        	<div class="col-md-12" align="center">
            <?php
				if(!empty($_POST)){
					$check = $mysqli->query("select * from doctor where doctor_name = '$_POST[doctorName]'");
					if($check->num_rows > 0){
						echo "<font color='#FF0000' size='+1'><b>Doctor <u>$_POST[doctorName]</u> Allready exists</b></font>";	
					}else{
						
						$insert = $mysqli->query("insert into doctor values('', '$_POST[doctorName]')");
						
						if($insert){
							echo "<font color='#009900' size='+1'><b>Doctor Saved</b></font>";	
						}else{
							echo "<font color='#FF0000' size='+1'><b>Failed</b></font>";	
						}
					}
				}
			?>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="pull-left">New Doctor Information</div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                    
                      <div class="form">
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal" action="" method="post">
                                          <!-- Title -->   
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="testName">Doctor Name</label>
                                            <div class="col-lg-8"> 
                                              <textarea class="form-control" id="testName" autoComplete="off" required name="doctorName"></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                             <!-- Buttons -->
											 <div class="col-lg-offset-5 col-lg-9">
												<button type="submit" class="btn btn-primary">Save</button>
											 </div>
                                          </div>
                                      </form>
                                    </div>
                  

                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div>
              </div>
              
            </div>       
          </div> 
              <!-- project team & activity end -->

          </section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>