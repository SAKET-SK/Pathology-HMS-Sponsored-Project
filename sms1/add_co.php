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
					$check = $mysqli->query("select * from co where (coMobile = '$_POST[coMobile]' and coCode = '$_POST[coCode]') or coCode = '$_POST[coCode]'");
					if($check->num_rows > 0){
						echo "<font color='#FF0000' size='+1'><b>CO Code <u>$_POST[coCode]</u> Allready exists</b></font>";	
					}else{
						
						$insert = $mysqli->query("insert into co values('', '$_POST[coName]', '$_POST[coMobile]', '$_POST[coCode]')");
						
						if($insert){
							echo "<font color='#009900' size='+1'><b>CO Saved</b></font>";	
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
                  <div class="pull-left">New CO Information</div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                    
                      <div class="form">
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal" action="" method="post">
                                          <!-- Title -->   
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="coName">CO Name</label>
                                            <div class="col-lg-8"> 
                                              <input type="text" class="form-control" id="coName" autoComplete="off" required name="coName">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="coMobile">CO Mobile</label>
                                            <div class="col-lg-8"> 
                                              <input type="text" class="form-control" id="coMobile" autoComplete="off" required name="coMobile">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="coCode">CO Code</label>
                                            <div class="col-lg-8"> 
                                              <input type="text" class="form-control" id="coCode" autoComplete="off" required name="coCode">
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