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
        	<div class="col-md-12" align="center">
            <?php
				if(!empty($_POST)){
				    $isPath=0;
				    if(isset($_POST[isPathology])){
				        $isPath=$_POST[isPathology];
				        //echo $isPath;
				    }
				    
					$check = $mysqli->query("select * from test_category where categoryName = '$_POST[categoryName]'");
					if($check->num_rows > 0){
						echo "<font color='#FF0000' size='+1'><b>Category <u>$_POST[categoryName]</u> Allready exists</b></font>";	
					}else{
						
						$insert = $mysqli->query("insert into test_category (categoryName,is_Path) values( '$_POST[categoryName]', '$isPath')");
						
						if($insert){
							echo "<font color='#009900' size='+1'><b>Category Saved</b></font>";	
						}else{
							echo "<font color='#FF0000' size='+1'><b>Failed</b></font>";	
						}
						//echo $mysqli->error;
					}
				}
			?>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="pull-left">New Category Information</div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                    
                      <div class="form">
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal" action="" method="post">
                                          <!-- Title -->   
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="categoryName">Category Name</label>
                                            <div class="col-lg-8"> 
                                              <textarea type="text" class="form-control" id="categoryName" autoComplete="off" autoFocus required name="categoryName"></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="isPathology">Is Pathology</label>
                                            <div class="col-lg-1"> 
                                              <input type="checkbox" class="form-control" id="isPathology" value="1" autoComplete="off" name="isPathology">
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